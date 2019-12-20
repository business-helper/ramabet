<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use App\Admin;
use App\Notifications\RepliedToThread;
/**/
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Auth;
class PaymentController extends Controller
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    public function index()
    {
        return view('paywithpaypal');
    }
    public function payWithpaypal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('Item 1') /** item name **/
        ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->get('amount')); /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('amount'));
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('status/'.$request->get('amount'))) /** Specify return URL **/
        ->setCancelUrl(URL::to('status'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return Redirect::to('/');
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::to('/');
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');
        return Redirect::to('/');
    }
    public function getPaymentStatus($amount)
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('error', 'Payment failed');
            return Redirect::to('/paywithpaypal');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            \Session::put('success', 'Payment success');
            $ballance=DB::table('users')
                ->where('id', Auth::user()->id)->value('wallet');
            $inserarr=[
                'user_id'=>Auth::user()->id,
                'amount'=>$amount,
                'getway'=>'paypal',
                'type'=>'deposite',
                'before_amount'=>$ballance,
                'after_amount'=>(float)$ballance+(float)$amount
            ];
            $t_id=DB::table('payment_history')->insertGetId($inserarr);
            $wallet_inserarr=[
                'user_id'=>Auth::user()->id,
                'change_amount'=>$amount,
                'remark'=>'deposite',
                'before_amount'=>$ballance,
                'after_amount'=>(float)$ballance+(float)$amount,
                't_id'=>$t_id
            ];
            DB::table('wallet_history')->insert($wallet_inserarr);

            DB::table('users')
                ->where('id', Auth::user()->id)
                ->increment('wallet',$amount);
            $user=User::where('id',Auth::user()->id)->first();
            $admin=Admin::where('id','2')->first();
            $notification_data='';
            $notification_data['type']='deposit';
            $notification_data['message']=$user->name.' have deposit $'.$amount.' just now';
            $admin->notify(new RepliedToThread($user,$notification_data));
            return Redirect::to('/account/summary');
        }
        \Session::put('error', 'Payment failed');
        return Redirect::to('/paywithpaypal');
    }
    public function payout(Request $request){
        $payouts = new \PayPal\Api\Payout();
// This is how our body should look like:
        /*
         * {
                    "sender_batch_header":{
                        "sender_batch_id":"2014021801",
                        "email_subject":"You have a Payout!"
                    },
                    "items":[
                        {
                            "recipient_type":"EMAIL",
                            "amount":{
                                "value":"1.0",
                                "currency":"USD"
                            },
                            "note":"Thanks for your patronage!",
                            "sender_item_id":"2014031400023",
                            "receiver":"shirt-supplier-one@mail.com"
                        }
                    ]
                }
         */
        $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();
// ### NOTE:
// You can prevent duplicate batches from being processed. If you specify a `sender_batch_id` that was used in the last 30 days, the batch will not be processed. For items, you can specify a `sender_item_id`. If the value for the `sender_item_id` is a duplicate of a payout item that was processed in the last 30 days, the item will not be processed.
// #### Batch Header Instance
        $senderBatchHeader->setSenderBatchId(uniqid())
            ->setEmailSubject("You have a Payout!");
// #### Sender Item
// Please note that if you are using single payout with sync mode, you can only pass one Item in the request
        $senderItem = new \PayPal\Api\PayoutItem();
        $senderItem->setRecipientType('Email')
            ->setNote('Thanks for your patronage!')
            ->setReceiver('shirt-supplier-one@gmail.com')
            ->setSenderItemId("2014031400023")
            ->setAmount(new \PayPal\Api\Currency('{
                        "value":"1.0",
                        "currency":"USD"
                    }'));
        $payouts->setSenderBatchHeader($senderBatchHeader)
            ->addItem($senderItem);
// For Sample Purposes Only.
        $request = clone $payouts;
        try {
            $output = $payouts->createSynchronous($this->_api_context);
        }catch (Exception $ex) {
            ResultPrinter::printError("Created Single Synchronous Payout", "Payout", null, $request, $ex);
            exit(1);
            return "error";

        }
        ResultPrinter::printResult("Created Single Synchronous Payout", "Payout", $output->getBatchHeader()->getPayoutBatchId(), $request, $output);
        return "ssss";
        //return $output;
    }
    public function skrill_state(Request $request,$user_id){
        $amount=$request->get('amount');
        $ballance=DB::table('users')
            ->where('id', $user_id)->value('wallet');
        $inserarr=[
            'user_id'=>$user_id,
            'amount'=>$amount,
            'getway'=>'Skrill',
            'type'=>'deposite',
            'before_amount'=>$ballance,
            'after_amount'=>(float)$ballance+(float)$amount
        ];
        DB::table('payment_history')->insert($inserarr);
        DB::table('users')->where('id', $user_id)->increment('wallet',$amount);
        $user=User::where('id',$user_id)->first();
        $admin=Admin::where('id','2')->first();
        $notification_data='';
        $notification_data['type']='deposit';
        $notification_data['message']=$user->name.' have deposit $'.$amount.' just now';
        $admin->notify(new RepliedToThread($user,$notification_data));
        return 'adsf';
    }

}