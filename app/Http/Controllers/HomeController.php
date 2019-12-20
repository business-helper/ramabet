<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//use App\User;
use Illuminate\Support\Facades\Input;
use PhpParser\Node\Expr\Array_;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $sport_data;
    //public $api;
    public function __construct()
    {
        //$this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        /*if (!isset(Auth::user()->id)){
            $matched_bet=array();
            $unmatched_bet=array();
        }
        else{
            $matched_bet=DB::table('InPlay')
                ->where([['state','progress'],['bet.user_id',Auth::user()->id],['result',null]])
                ->join('bet','InPlay.id','bet.eventId')
                ->join('sports','sports.id','InPlay.sport_id')
                ->orderBy('bet.eventId','asc')
                ->orderBy('bet.bet_date','asc')
                ->get();
            $unmatched_bet=DB::table('InPlay')
                ->where([['state','<>','progress'],['bet.user_id',Auth::user()->id],['result',null]])
                ->join('bet','InPlay.id','bet.eventId')
                ->join('sports','sports.id','InPlay.sport_id')
                ->orderBy('bet.eventId','asc')
                ->orderBy('bet.bet_date','asc')
                ->get();
        }*/


        return view('user/Layout/page_template');
    }

    public function updatedata(){
        $sports_list=DB::table('sport_names')->where('is_active','true')->get();
        return view('user/pages/updatedata');
    }
    public function updatedataRunner(){
        return view('user/pages/updatedataRunner');
    }
    public function promotions(){
        if (!isset(Auth::user()->id)){
            $matched_bet=array();
            $unmatched_bet=array();
        }
        else{
            $matched_bet=DB::table('InPlay')
                ->where([['state','progress'],['bet.user_id',Auth::user()->id],['result',null]])
                ->join('bet','InPlay.id','bet.eventId')
                ->join('sports','sports.id','InPlay.sport_id')
                ->orderBy('bet.eventId','asc')
                ->orderBy('bet.bet_date','asc')
                ->get();
            $unmatched_bet=DB::table('InPlay')
                ->where([['state','<>','progress'],['bet.user_id',Auth::user()->id],['result',null]])
                ->join('bet','InPlay.id','bet.eventId')
                ->join('sports','sports.id','InPlay.sport_id')
                ->orderBy('bet.eventId','asc')
                ->orderBy('bet.bet_date','asc')
                ->get();
        }
        $bet_data['matched_bet']=$matched_bet;
        $bet_data['unmatched_bet']=$unmatched_bet;
        $sports_list=DB::table('sport_names')->where('is_active','true')->get();
        $link_list=DB::table('link_list')->where([['is_active','true'],['is_del',0]])->get();
        $root=0;
        return view('user/pages/promotions',['bet_data'=>$bet_data,'sports_list'=>$sports_list,'link_list'=>$link_list,'root'=>$root]);
    }
    public function my_first_api(){
        $data=[
            'name'=>'asdf',
            'mobile'=>'123123'
        ];
        return response()->json($data);
    }
    public function cricket_page(){
        $senddata=DB::table('InPlay')
            ->where([['sport_id','4']])
            ->join('Odds','InPlay.id','Odds.event_id')
            ->orderBy('state','asc')
            ->get();
        //$senddata=DB::table('InPlay')->where([['sport_id','4']])->orderBy('state','asc')->get();
        return view('pages.cricket',['data'=> $senddata]);
    }
    public function soccer_page(){
        $senddata=DB::table('InPlay')
            ->where([['sport_id','1']])
            ->join('Odds','InPlay.id','Odds.event_id')
            ->orderBy('state','asc')
            ->get();
        //$senddata=DB::table('InPlay')->where([['sport_id','1']])->orderBy('state','asc')->get();
        return view('pages.soccer',['data'=> $senddata]);
    }
    public function tennis_page(){
        $senddata=DB::table('InPlay')
            ->where([['sport_id','2']])
            ->join('Odds','InPlay.id','Odds.event_id')
            ->orderBy('state','asc')
            ->get();
        return view('pages.tennis',['data'=> $senddata]);
    }
    public function eventDetail_page($fixtureid){
        $api=new ApiController();
        $senddata=$api->event_view($fixtureid);
        if (count($senddata->markets)==0){
            return redirect('/');
        }
        $senddata1=DB::table('InPlay')
            ->where('id',$fixtureid)
            ->join('Odds','InPlay.id','Odds.event_id')
            ->get()->first();
        return view('pages.eventdetail',['apidata'=>$senddata,'item'=>json_decode(json_encode($senddata1),true)]);
    }
    public function multiMarkets_page(){
        $events=DB::table('InPlay')
            ->join('market','InPlay.id','market.event_id')
            ->where([['market.user_id',Auth::user()->id]])
            ->join('Odds','InPlay.id','Odds.event_id')
            ->get();
        /*$upcoming_events=DB::table('InPlay')
            ->join('market','InPlay.id','market.event_id')
            ->where([['market.user_id',Auth::user()->id],['time_status','0']])
            ->get();*/
        return view('pages/multiMarkets',['events'=>$events]);
    }
    public function in_play_page(){
        $cricket=DB::table('InPlay')
            ->where([['time_status','1'],['sport_id','4']])
            ->join('Odds','InPlay.id','Odds.event_id')
            ->get();
        $football=DB::table('InPlay')
            ->where([['time_status','1'],['sport_id','1']])
            ->join('Odds','InPlay.id','Odds.event_id')
            ->get();
        $tennis=DB::table('InPlay')
            ->where([['time_status','1'],['sport_id','2']])
            ->join('Odds','InPlay.id','Odds.event_id')
            ->get();
        return view('pages/in_play',['football'=>$football,'cricket'=>$cricket,'tennis'=>$tennis]);
    }
    public function profile_page(){
        $account=DB::table('users')->where('id', Auth::user()->id)->first();
        return view('user/pages/account/myprofile',['account'=>json_encode($account),'root'=>0]);
    }
    public function summary_page(){
        $this->middleware('auth');
        $pament_info=DB::table('payment_info')->where('user_id', Auth::user()->id)->get()->toArray();
        $wallet=DB::table('users')->where('id', Auth::user()->id)->value('wallet');
        $wallet_info=DB::table('wallet_history')->where([['user_id', Auth::user()->id],])->get();
        //////////////////////
        if (!isset(Auth::user()->id)){
            $matched_bet=array();
            $unmatched_bet=array();
        }
        else{
            $matched_bet=DB::table('InPlay')
                ->where([['state','progress'],['bet.user_id',Auth::user()->id],['result',null]])
                ->join('bet','InPlay.id','bet.eventId')
                ->join('sports','sports.id','InPlay.sport_id')
                ->orderBy('bet.eventId','asc')
                ->orderBy('bet.bet_date','asc')
                ->get();
            $unmatched_bet=DB::table('InPlay')
                ->where([['state','<>','progress'],['bet.user_id',Auth::user()->id],['result',null]])
                ->join('bet','InPlay.id','bet.eventId')
                ->join('sports','sports.id','InPlay.sport_id')
                ->orderBy('bet.eventId','asc')
                ->orderBy('bet.bet_date','asc')
                ->get();
        }
        $bet_data['matched_bet']=$matched_bet;
        $bet_data['unmatched_bet']=$unmatched_bet;
        return view('user/pages/account/summary',['pament_info'=>$pament_info,'wallet'=>$wallet,'wallet_info'=>$wallet_info,'bet_data'=>$bet_data]);
    }
    public function transferredLog_page(){
        $this->middleware('auth');

        $wallet_info=DB::table('wallet_history')->where([['user_id', Auth::user()->id],])->get();
        //////////////////////
        if (!isset(Auth::user()->id)){
            $matched_bet=array();
            $unmatched_bet=array();
        }
        else{
            $matched_bet=DB::table('InPlay')
                ->where([['state','progress'],['bet.user_id',Auth::user()->id],['result',null]])
                ->join('bet','InPlay.id','bet.eventId')
                ->join('sports','sports.id','InPlay.sport_id')
                ->orderBy('bet.eventId','asc')
                ->orderBy('bet.bet_date','asc')
                ->get();
            $unmatched_bet=DB::table('InPlay')
                ->where([['state','<>','progress'],['bet.user_id',Auth::user()->id],['result',null]])
                ->join('bet','InPlay.id','bet.eventId')
                ->join('sports','sports.id','InPlay.sport_id')
                ->orderBy('bet.eventId','asc')
                ->orderBy('bet.bet_date','asc')
                ->get();
        }
        $bet_data['matched_bet']=$matched_bet;
        $bet_data['unmatched_bet']=$unmatched_bet;
        return view('user/pages/account/transferredLog',['bet_data'=>$bet_data,'wallet_info'=>$wallet_info]);
    }
    public function current_bets_page(){
        $this->middleware('auth');
        $current_bet=DB::table('bet')->where([['user_id', Auth::user()->id],['remarks','none']])->get()->toArray();
        $past_bets=DB::table('bet')->where([['user_id', Auth::user()->id],['remarks','<>','none']])->get()->toArray();
        $cancel_bets=DB::table('bet')->where([['user_id', Auth::user()->id],['remarks','cancel']])->get()->toArray();

        //////////////////////
        if (!isset(Auth::user()->id)){
            $matched_bet=array();
            $unmatched_bet=array();
        }
        else{
            $matched_bet=DB::table('InPlay')
                ->where([['state','progress'],['bet.user_id',Auth::user()->id],['result',null]])
                ->join('bet','InPlay.id','bet.eventId')
                ->join('sports','sports.id','InPlay.sport_id')
                ->orderBy('bet.eventId','asc')
                ->orderBy('bet.bet_date','asc')
                ->get();
            $unmatched_bet=DB::table('InPlay')
                ->where([['state','<>','progress'],['bet.user_id',Auth::user()->id],['result',null]])
                ->join('bet','InPlay.id','bet.eventId')
                ->join('sports','sports.id','InPlay.sport_id')
                ->orderBy('bet.eventId','asc')
                ->orderBy('bet.bet_date','asc')
                ->get();
        }
        $bet_data['matched_bet']=$matched_bet;
        $bet_data['unmatched_bet']=$unmatched_bet;
        return view('user/pages/account/current_bets',['past_bets'=>$past_bets,'cancel_bets'=>$cancel_bets,'bet_data'=>$bet_data]);
    }
    public function bet_history_page(){
        $old_bet=DB::table('betslip')->where([['user_id', Auth::user()->id],['state',2]])->get()->toArray();
        return view('user/pages/account/bet_history',['old_bet'=>$old_bet,'root'=>0]);
    }
    public function profit_loss_page(){
        $this->middleware('auth');
        $wallet=DB::table('users')->where('id', Auth::user()->id)->value('wallet');
        $stake=DB::table('bet')->where([['user_id', Auth::user()->id],['remarks','profit']])->sum('stake');
        $price=DB::table('bet')->where([['user_id', Auth::user()->id],['remarks','profit']])->sum('price');
        $profit=$price-$stake;
        $loss=DB::table('bet')->where([['user_id', Auth::user()->id],['remarks','loss']])->sum('stake');
        $deposit=DB::table('payment_history')->where([['user_id', Auth::user()->id]])->sum('amount');
        $withdraw=DB::table('withdraw_history')->where([['user_id', Auth::user()->id],['remark','success']])->sum('amount');
        //////////////////////
        if (!isset(Auth::user()->id)){
            $matched_bet=array();
            $unmatched_bet=array();
        }
        else{
            $matched_bet=DB::table('InPlay')
                ->where([['state','progress'],['bet.user_id',Auth::user()->id],['result',null]])
                ->join('bet','InPlay.id','bet.eventId')
                ->join('sports','sports.id','InPlay.sport_id')
                ->orderBy('bet.eventId','asc')
                ->orderBy('bet.bet_date','asc')
                ->get();
            $unmatched_bet=DB::table('InPlay')
                ->where([['state','<>','progress'],['bet.user_id',Auth::user()->id],['result',null]])
                ->join('bet','InPlay.id','bet.eventId')
                ->join('sports','sports.id','InPlay.sport_id')
                ->orderBy('bet.eventId','asc')
                ->orderBy('bet.bet_date','asc')
                ->get();
        }
        $bet_data['matched_bet']=$matched_bet;
        $bet_data['unmatched_bet']=$unmatched_bet;
        /////////////////////////////
        $past_bets=DB::table('bet')->where([['user_id', Auth::user()->id]])->whereIn('remarks',['profit','lose'])->get()->toArray();
        return view('user/pages/account/profit_loss',['wallet'=>$wallet,'profit'=>$profit,'loss'=>$loss,'deposit'=>$deposit,'withdraw'=>$withdraw,'bet_data'=>$bet_data,'past_bets'=>$past_bets]);
    }
    public function withdraw_page($type){
        $this->middleware('auth');
        $wallet=DB::table('users')->where('id', Auth::user()->id)->value('wallet');
        $request_amount=DB::table('withdraw_history')->where('user_id',Auth::user()->id)->pluck('amount');
        $available_amount=0;
        foreach ($request_amount as $item){
            $available_amount+=$item;
        }
        return view('pages/payment/withdraw',['type'=>$type,'wallet'=>$wallet-$available_amount]);
    }
    public function withdraw_post($type){
        $data=Input::all();
        $account_info=$data['account_info'];
        $ammount=$data['amount'];
        $description=$data['description'];
        $wallet=DB::table('users')->where('id', Auth::user()->id)->value('wallet');
        $request_amount=DB::table('withdraw_history')->where('user_id',Auth::user()->id)->pluck('amount');
        $available_amount=0;
        foreach ($request_amount as $item){
            $available_amount+=$item;
        }

        if ($wallet-$available_amount<$ammount){
            $wallet=DB::table('users')->where('id', Auth::user()->id)->value('wallet');
            $request_amount=DB::table('withdraw_history')->where('user_id',Auth::user()->id)->pluck('amount');
            $available_amount=0;
            foreach ($request_amount as $item){
                $available_amount+=$item;
            }
            return view('pages/payment/withdraw',['type'=>$type,'wallet'=>$wallet-$available_amount,'message'=>'Amount is not available']);
        }
        $inserarr=[
            'user_id'=>Auth::user()->id,
            'amount'=>$ammount,
            'getway'=>$type,
            'account_info'=>$account_info,
            'description'=>$description
        ];
        DB::table('withdraw_history')->insert($inserarr);
        return redirect('account/summary');
    }
    public function withdraw_edit(){
        $data=Input::all();
        $account_info=$data['account_info'];
        $description=$data['description'];
        $type=$data['getway'];
        $no=$data['w_id'];
        //$ammount=$data['amount'];
        //$wallet=DB::table('users')->where('id', Auth::user()->id)->value('wallet');
        //$request_amount=DB::table('withdraw_history')->where('user_id',Auth::user()->id)->pluck('amount');
        /*$available_amount=0;
        foreach ($request_amount as $item){
            $available_amount+=$item;
        }*/

        /*if ($wallet-$available_amount<$ammount){
            $wallet=DB::table('users')->where('id', Auth::user()->id)->value('wallet');
            $request_amount=DB::table('withdraw_history')->where('user_id',Auth::user()->id)->pluck('amount');
            $available_amount=0;
            foreach ($request_amount as $item){
                $available_amount+=$item;
            }
            return view('pages/payment/withdraw',['type'=>$type,'wallet'=>$wallet-$available_amount,'message'=>'Amount is not available']);
        }*/
        $inserarr=[
            'getway'=>$type,
            'account_info'=>$account_info,
            'description'=>$description
        ];
        DB::table('withdraw_history')->where('no',$no)->update($inserarr);
        return redirect('account/summary');
    }

}
