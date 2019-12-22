<?php

namespace App\Http\Controllers;

use App\AccountState;
use App\Admin;
use App\Event;
use App\League;
use App\Market;
use App\Report;
use App\Runner;
use App\Settlement;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use Whoops\Run;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $username;
    private $password;
    private $packageID;
    private $baseurl1;
    private $baseurl2;
    private $prematch = 'http://prematch.lsports.eu';
    private $baseurl = 'https://api.betsapi.com/';
    private $sports = [1, 2, 4];
    private $token;
    private $firebase;
    public function __construct()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        if (version_compare(phpversion(), '7.1', '>=')) {
            ini_set( 'serialize_precision', -1 );
        }
        $this->firebase=new FirebaseController();
        $this->username = 'info@softbroke.com ';
        $this->packageID = '1766';
        $this->password = 'sadWSWW2458';
        $this->baseurl1 = 'http://prematch.lsports.eu/';
        $this->baseurl2 = 'http://178.79.131.131/api/v1/';
        $general_setting = array();
        $data = DB::table('general_setting')->get();
        foreach ($data as $item) {
            $general_setting[$item->name] = $item->value;
        }
        $this->token = $general_setting['api_token'];
    }

    public function updateOdd()
    {

        $data= json_decode(json_encode(\request('runners')));
        $matchedBet=array();
        $res = array();
        foreach ($data as $a_runner) {
            $runner = Runner::find($a_runner->id);
            //$runner->market_id = $market_id;
            //$runner->runnerId = $a_runner->selectionId;
            if ($runner->availableToBack != json_encode(($a_runner->availableToBack))) {
                $runner->availableToBack = json_encode(($a_runner->availableToBack));
                $runner->save();

                $item['id'] = $runner->id;
                $item['type'] = 'availableToBack';
                $s_runner = Runner::find($runner->id);
                $item['availableToBack'] = json_decode($s_runner->availableToBack);
                //$item['runner'] = $item;
                $res[] = $item;
                $temp=$this->checkUnMatchedBet($runner->id, 'availableToBack',$runner);
                $matchedBet=array_merge($matchedBet,$temp);

            }
            if ($runner->availableToLay != json_encode(($a_runner->availableToLay))) {
                $runner->availableToLay = json_encode(($a_runner->availableToLay));
                $runner->save();
                $item['id'] = $runner->id;
                $item['type'] = 'availableToLay';
                $s_runner = Runner::find($runner->id);
                $item['availableToLay'] = json_decode($s_runner->availableToLay);
                $res[] = $item;

                $temp=$this->checkUnMatchedBet($runner->id, 'availableToLay',$runner);
                $matchedBet=array_merge($matchedBet,$temp);
            }
        }
        return \response(json_encode(['message'=>'Success updated','note'=>['link' => $res, 'message' => 'update odd', 'type' => 'update odd', 'user_type' => 'users'],'matchedBet'=>$matchedBet]));
        /*if (count($res) > 0) {
            $this->firebase->SendNotification('runners', ['link' => $res, 'message' => 'update odd', 'type' => 'update odd', 'user_type' => 'users']);
        }*/

    }
    public function insertRunner($market_id, $data)
    {
        $res = array();
        $matchedBet=array();
        foreach ($data as $a_runner) {
            $isCheck = Runner::where([['market_id', $market_id], ['runnerId', $a_runner->selectionId]])->value('id');
            if (!isset($isCheck))continue;
            $runner = Runner::find($isCheck);
            if (isset($a_runner->name)) {
                $runner->runnerName = $a_runner->name;
            }
            if ($runner->availableToBack == json_encode(($a_runner->ex->availableToBack)) and $runner->availableToLay == json_encode(($a_runner->ex->availableToLay))) continue;
            if ($runner->availableToBack != json_encode(($a_runner->ex->availableToBack))) {
                $runner->back = json_encode($a_runner->ex->availableToBack);
                for ($i = 0; $i <=count($a_runner->ex->availableToBack); $i++) {
                    if (!isset($a_runner->ex->availableToBack[$i]->size)) continue;
                    $vol=1;
                    if (isset(json_decode($runner->availableToBackVol)[$i])){$vol=json_decode
                    ($runner->availableToBackVol)[$i];}
                    $a_runner->ex->availableToBack[$i]->size *= $vol;
                    $a_runner->ex->availableToBack[$i]->size=round($a_runner->ex->availableToBack[$i]->size,0);
                    $a_runner->ex->availableToBack[$i]->price=round($a_runner->ex->availableToBack[$i]->price,2);
                }

                $runner->availableToBack = json_encode($a_runner->ex->availableToBack);
                $runner->save();

                $item['id'] = $runner->id;
                $item['type'] = 'availableToBack';
                $s_runner = Runner::find($runner->id);
                $item['availableToBack'] = json_decode($s_runner->availableToBack);
                //$item['runner'] = $item;
                $res[] = $item;
                $temp=$this->checkUnMatchedBet($runner->id, 'availableToBack',$runner);
                $matchedBet=array_merge($matchedBet,$temp);

            }
            if ($runner->availableToLay != json_encode(($a_runner->ex->availableToLay))) {
                $runner->lay = json_encode(($a_runner->ex->availableToLay));
                for ($i = 0; $i <= 2; $i++) {
                    if (!isset($a_runner->ex->availableToLay[$i]->size)) continue;
                    $a_runner->ex->availableToLay[$i]->size *= json_decode($runner->availableToLayVol)[$i];
                    $a_runner->ex->availableToLay[$i]->size=round($a_runner->ex->availableToLay[$i]->size,0);
                    $a_runner->ex->availableToLay[$i]->price=round($a_runner->ex->availableToLay[$i]->price,2);
                }
                $runner->availableToLay = json_encode(($a_runner->ex->availableToLay));
                $runner->save();
                $item['id'] = $runner->id;
                $item['type'] = 'availableToLay';
                $s_runner = Runner::find($runner->id);
                $item['availableToLay'] = json_decode($s_runner->availableToLay);
                $res[] = $item;
                $temp=$this->checkUnMatchedBet($runner->id, 'availableToLay',$runner);
                $matchedBet=array_merge($matchedBet,$temp);
            }
        }
        return ['runners'=>$res,'matchedBet'=>$matchedBet];
    }

    private function checkUnMatchedBet($runner_id, $betType,$runner)
    {
        //
        //$runner = Runner::find($runner_id);
        $umMatchedBet = DB::table('betslip')->where([['runner_id', $runner_id], ['is_matched', 'false'],['state',1], ['bet_type', $betType],['is_work',1]])->get();
        if (count($umMatchedBet)==0) return [];

        //$firebase = new FirebaseController();
        $market_id = Runner::where('id', $runner_id)->value('market_id');
        $res=array();
        foreach ($umMatchedBet as $item) {
            $isMarketsWorks=DB::table('user_markets')->where([['market_id',$market_id],['user_id',$item->user_id]])->first();
            if (!isset($isMarketsWorks)){
                //DB::table('user_markets')->insert(['market_id'=>$market_id,'user_id'=>$user_id,'is_work'=>1]);
                continue;
            }
            if ($isMarketsWorks->is_work==1){
                continue;
            }
            DB::table('user_markets')->where([['market_id',$market_id],['user_id',$item->user_id]])->update(['is_work'=>1,'action'=>'when update odd']);

            DB::table('betslip')->where([['id', $item->id]])->update(['is_work'=>2]);
            //$user = User::find($item->user_id);
            //$old_liability = $this->getLiabilityOfMarket($market_id, $user->id);
            if ($betType == 'availableToBack') {
                $odds = json_decode($runner->availableToBack);
                if ($item->odd>$odds[0]->price){
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$item->user_id]])->update(['is_work'=>0]);
                    continue;
                }
                //DB::table('betslip')->where([['id', $item->id]])->update(['volume' => json_encode($odds[0])]);
                $pass_vol = 0;
                if ($item->volume != 'none') {
                    $last_odd = json_decode($item->volume);
                    if ($last_odd->price == $odds[0]->price && $last_odd->size >= $odds[0]->size) {
                        DB::table('user_markets')->where([['market_id',$market_id],['user_id',$item->user_id]])->update(['is_work'=>0]);
                        continue;
                    }
                    if ($last_odd->price == $odds[0]->price && $last_odd->size < $odds[0]->size){
                        $pass_vol = $odds[0]->size-$last_odd->size;
                    }else{
                        foreach ($odds as $odd) {
                            if ($odd->price >= $item->odd) {
                                $pass_vol += $odd->size;
                            }
                        }
                    }
                }else{
                    foreach ($odds as $odd) {
                        if ($odd->price >= $item->odd) {
                            $pass_vol += $odd->size;
                        }
                    }
                }
                if ($pass_vol == 0) {
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$item->user_id]])->update(['is_work'=>0]);
                    continue;
                }

                $is_possible=DB::table('betslip')->where([['runner_id',$item->runner_id],['odd','<',$item->odd],['user_id',$item->user_id],['is_matched','false'],['state',1],['bet_type',$item->bet_type]])->get();
                if (count($is_possible)>0){
                    DB::table('betslip')->where([['runner_id',$item->runner_id],['id','<',$item->id],['user_id',$item->user_id],['is_matched','false'],['state',1]])->update(['volume' => json_encode($odds[0])]);
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$item->user_id]])->update(['is_work'=>0]);
                    continue;
                }
                $is_possible=DB::table('betslip')->where([['runner_id',$item->runner_id],['odd','=',$item->odd],['id','<',$item->id],['user_id',$item->user_id],['is_matched','false'],['state',1],['bet_type',$item->bet_type]])->get();
                if (count($is_possible)>0){
                    DB::table('betslip')->where('id',$item->id)->update(['volume' => json_encode($odds[0]),'is_work'=>1]);
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$item->user_id]])->update(['is_work'=>0]);
                    continue;
                }
                if ($pass_vol >= $item->stake) {
                    $user = DB::table('users')->where('id', $item->user_id)->first();
                    $old_liability = $this->getLiabilityOfMarket($market_id, $item->user_id);
                    //
                    DB::table('betslip')->where([['id', $item->id]])->update(['is_matched' => 'true']);
                    //
                    $total_liability = $this->getLiabilityOfMarket($market_id, $item->user_id);
                    $f_wallet = $user->wallet - $old_liability + $total_liability;
                    DB::table('users')->where('id', $item->user_id)->update(['wallet' => $f_wallet]);
                    $old_exposure=$user->exposure;
                    $user->exposure = $user->exposure - $old_liability + $total_liability;
                    if ($user->exposure>0)$user->exposure=0;
                    DB::table('users')->where('id', $item->user_id)->update(['exposure' => $user->exposure]);
                    DB::table('liability_log')->insert(['user_id'=>$user->id,'wallet'=>$user->wallet,'exposure'=>$user->exposure,'old_liability'=>$old_liability,'n_liability'=>$total_liability,'old_exposure'=>$old_exposure,'t_id'=>$item->id,'action'=>'check unmatched1']);
                    $msg1 = 'Matched:' . $user->email . ' runner:' . $this->getRunnerName($item->runner_id) . ' BetType' . $item->bet_type . ', Odds:' . $item->odd . ', Stake:' . $item->stake;
                    $res[]=['bet_item' => $item, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($item->user_id), 'market_id' => $market_id, 'user' => $item->user_id,'userRunnerPosition'=>$this->getRunnerPosition($market_id,$item->user_id),'adminRunnerPosition'=>$this->getRunnerPositionAdmins($market_id,$item->user_id),'openBets'=>$this->getOpenBet($item->user_id,0),'adminOpenBet'=>$this->getOpenBetAdmins(0,$item->user_id)];
                } else {

                    $user = DB::table('users')->where('id', $item->user_id)->first();
                    $old_liability = $this->getLiabilityOfMarket($market_id, $item->user_id);
                    //
                    $profit = ($pass_vol) * $item->odd - ($pass_vol);
                    $exposure = -($pass_vol);
                    $id = DB::table('betslip')
                        ->insertGetId(['runner_id' => $item->runner_id, 'user_id' => $item->user_id, 'odd' => $item->odd, 'bet_type' => 'availableToBack', 'stake' => ($pass_vol), 'volume' => json_encode($odds[0]), 'state' => 1, 'is_matched' => 'true', 'profit_amount' => $profit, 'exposure' => $exposure
                        ]);

                    $profit = ($item->stake - ($pass_vol)) * $item->odd - ($item->stake - ($pass_vol));
                    $exposure = -($item->stake - ($pass_vol));
                    DB::table('betslip')->where([['id', $item->id]])->update([ 'stake' => ($item->stake - ($pass_vol)), 'profit_amount' => $profit, 'exposure' => $exposure,'volume' => json_encode($odds[0])]);
                    //
                    $total_liability = $this->getLiabilityOfMarket($market_id, $item->user_id);
                    $f_wallet = $user->wallet - $old_liability + $total_liability;
                    DB::table('users')->where('id', $item->user_id)->update(['wallet' => $f_wallet]);
                    $old_exposure=$user->exposure;
                    $user->exposure = $user->exposure - $old_liability + $total_liability;
                    if ($user->exposure>0)$user->exposure=0;
                    DB::table('users')->where('id', $item->user_id)->update(['exposure' => $user->exposure]);
                    DB::table('liability_log')->insert(['user_id'=>$user->id,'wallet'=>$user->wallet,'exposure'=>$user->exposure,'old_liability'=>$old_liability,'n_liability'=>$total_liability,'old_exposure'=>$old_exposure,'t_id'=>$item->id,'action'=>'check unmatched2']);
                    $msg1 = 'Matched:' . $user->email . ' runner:' . $this->getRunnerName($item->runner_id) . 'BetType' . $item->bet_type . ', Odds:' . $item->odd . ', Stake:' . $pass_vol;
                    $res[]=['bet_item' => $item, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($item->user_id), 'market_id' => $market_id, 'user' => $item->user_id,'userRunnerPosition'=>$this->getRunnerPosition($market_id,$item->user_id),'adminRunnerPosition'=>$this->getRunnerPositionAdmins($market_id,$item->user_id),'openBets'=>$this->getOpenBet($item->user_id,0),'adminOpenBet'=>$this->getOpenBetAdmins(0,$item->user_id)];
                }
            }
            else {//$betType=='availableToLay'
                $odds = json_decode($runner->availableToLay);
                if ($item->odd<$odds[0]->price){
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$item->user_id]])->update(['is_work'=>0]);
                    continue;
                }
                //DB::table('betslip')->where([['id', $item->id]])->update(['volume' => json_encode($odds[0])]);
                $pass_vol = 0;
                if ($item->volume != 'none') {
                    $last_odd = json_decode($item->volume);
                    if ($last_odd->price == $odds[0]->price && $last_odd->size >= $odds[0]->size) {
                        DB::table('user_markets')->where([['market_id',$market_id],['user_id',$item->user_id]])->update(['is_work'=>0]);
                        continue;
                    }
                    if ($last_odd->price == $odds[0]->price && $last_odd->size < $odds[0]->size){
                        $pass_vol = $odds[0]->size-$last_odd->size;
                    }else{
                        foreach ($odds as $odd) {
                            if ($odd->price <= $item->odd) {
                                $pass_vol += $odd->size;
                            }
                        }
                    }
                }
                else{
                    foreach ($odds as $odd) {
                        if ($odd->price <= $item->odd) {
                            $pass_vol += $odd->size;
                        }
                    }
                }

                if ($pass_vol == 0) {
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$item->user_id]])->update(['is_work'=>0]);
                    continue;
                }
                $is_possible=DB::table('betslip')->where([['runner_id',$item->runner_id],['odd','>',$item->odd],['user_id',$item->user_id],['is_matched','false'],['state',1],['bet_type',$item->bet_type]])->get();
                if (count($is_possible)>0){
                    DB::table('betslip')->where([['runner_id',$item->runner_id],['id','<',$item->id],['user_id',$item->user_id],['is_matched','false'],['state',1]])->update(['volume' => json_encode($odds[0])]);
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$item->user_id]])->update(['is_work'=>0]);
                    continue;
                }
                $is_possible=DB::table('betslip')->where([['runner_id',$item->runner_id],['odd','=',$item->odd],['id','<',$item->id],['user_id',$item->user_id],['is_matched','false'],['state',1],['bet_type',$item->bet_type]])->get();
                if (count($is_possible)>0){
                    DB::table('betslip')->where([['runner_id',$item->runner_id],['id','<',$item->id],['user_id',$item->user_id],['is_matched','false'],['state',1]])->update(['volume' => json_encode($odds[0])]);
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$item->user_id]])->update(['is_work'=>0]);
                    continue;
                }

                if ($item->stake <= $pass_vol) {
                    $user = DB::table('users')->where('id', $item->user_id)->first();
                    $old_liability = $this->getLiabilityOfMarket($market_id, $item->user_id);
                    //
                    DB::table('betslip')->where([['id', $item->id]])->update(['is_matched' => 'true']);
                    //
                    $total_liability = $this->getLiabilityOfMarket($market_id, $item->user_id);
                    $f_wallet = $user->wallet - $old_liability + $total_liability;
                    DB::table('users')->where('id', $item->user_id)->update(['wallet' => $f_wallet]);
                    $old_exposure=$user->exposure;
                    $user->exposure = $user->exposure - $old_liability + $total_liability;
                    if ($user->exposure>0)$user->exposure=0;
                    DB::table('users')->where('id', $item->user_id)->update(['exposure' => $user->exposure]);
                    DB::table('liability_log')->insert(['user_id'=>$user->id,'wallet'=>$user->wallet,'exposure'=>$user->exposure,'old_liability'=>$old_liability,'n_liability'=>$total_liability,'old_exposure'=>$old_exposure,'t_id'=>$item->id,'action'=>'check unmatched3']);
                    $msg1 = 'Matched:' . $user->email . ' runner:' . $this->getRunnerName($item->runner_id) . ' BetType' . $item->bet_type . ', Odds:' . $item->odd . ', Stake:' . $item->stake;
                    $res[]=['bet_item' => $item, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($item->user_id), 'market_id' => $market_id, 'user' => $user->id,'userRunnerPosition'=>$this->getRunnerPosition($market_id,$item->user_id),'adminRunnerPosition'=>$this->getRunnerPositionAdmins($market_id,$item->user_id),'openBets'=>$this->getOpenBet($item->user_id,0),'adminOpenBet'=>$this->getOpenBetAdmins(0,$item->user_id)];
                } else {
                    $user = DB::table('users')->where('id', $item->user_id)->first();
                    $old_liability = $this->getLiabilityOfMarket($market_id, $item->user_id);
                    //
                    $exposure = -(($pass_vol) * $item->odd - ($pass_vol));
                    $profit = ($pass_vol);

                    $id = DB::table('betslip')
                        ->insertGetId(['runner_id' => $item->runner_id, 'user_id' => $item->user_id, 'odd' => $item->odd, 'bet_type' => 'availableToLay', 'stake' => $pass_vol, 'volume' => json_encode($odds[0]), 'state' => 1, 'is_matched' => 'true', 'profit_amount' => $profit, 'exposure' => $exposure
                        ]);
                    $exposure = -(($item->stake - ($pass_vol)) * $item->odd - ($item->stake - ($pass_vol)));
                    $profit = ($item->stake - ($pass_vol));
                    DB::table('betslip')->where([['id', $item->id]])->update(['stake' => ($item->stake - ($pass_vol)), 'profit_amount' => $profit, 'exposure' => $exposure,'volume' => json_encode($odds[0])]);
                    //
                    $total_liability = $this->getLiabilityOfMarket($market_id, $item->user_id);
                    $f_wallet = $user->wallet - $old_liability + $total_liability;
                    DB::table('users')->where('id', $item->user_id)->update(['wallet' => $f_wallet]);
                    $old_exposure=$user->exposure;
                    $user->exposure = $user->exposure - $old_liability + $total_liability;
                    if ($user->exposure>0)$user->exposure=0;
                    DB::table('users')->where('id', $item->user_id)->update(['exposure' => $user->exposure]);
                    DB::table('liability_log')->insert(['user_id'=>$user->id,'wallet'=>$user->wallet,'exposure'=>$user->exposure,'old_liability'=>$old_liability,'n_liability'=>$total_liability,'t_id'=>$item->id,'action'=>'check unmatched4']);
                    $msg1 = 'Matched:' . $user->email . ' runner:' . $this->getRunnerName($item->runner_id) . ' BetType' . $item->bet_type . ', Odds:' . $item->odd . ', Stake:' . $pass_vol;
                    DB::table('betslip')->where('id', $id)->update(['is_work'=>1]);
                    $res[]=['bet_item' => $item, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($item->user_id), 'market_id' => $market_id, 'user' => $item->user_id,'userRunnerPosition'=>$this->getRunnerPosition($market_id,$item->user_id),'adminRunnerPosition'=>$this->getRunnerPositionAdmins($market_id,$item->user_id),'openBets'=>$this->getOpenBet($item->user_id,0),'adminOpenBet'=>$this->getOpenBetAdmins(0,$item->user_id)];
                }
            }
            DB::table('user_markets')->where([['market_id',$market_id],['user_id',$item->user_id]])->update(['is_work'=>0]);

        }
        DB::table('betslip')->where([['runner_id', $runner_id], ['is_matched', 'false'],['state',1], ['bet_type', $betType],['is_work',2]])->update(['is_work'=>1]);
        return $res;

    }
    public function getMarketOfStatus(){
        $marketStatus=\request('marketStatus');
        $userType=\request('userType');
        $res=array();
        $fancyRes=array();
        $user_id=\request('userId');
        if ($marketStatus=="OPEN"){
            $admin_ids = Admin::where('parent_id', $user_id)->pluck('parent_id');
            $admin_ids[] = $user_id;
            $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
            $admin_ids[] = $user_id;
            $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
            $admin_ids[] = $user_id;
            $user_ids = User::whereIn('parent_id', $admin_ids)->pluck('id')->unique();
            //return json_encode($user_ids);
            $res = DB::table('markets')
                ->join('runners', 'runners.market_id', 'markets.id')
                ->join('events','markets.event_id','events.id')
                ->join('betslip', 'betslip.runner_id', 'runners.id')
                ->whereIn('betslip.user_id', $user_ids)
                ->where([['markets.marketStatus','OPEN']])
                ->select('markets.*','events.name as eventName','events.sport_id')
                ->distinct()->get();
            $fancyRes = DB::table('runners')
                ->join('markets', 'runners.market_id', 'markets.id')
                ->join('events','markets.event_id','events.id')
                ->join('betslip', 'betslip.runner_id', 'runners.id')
                ->whereIn('betslip.user_id', $user_ids)
                ->where([['runners.runnerStatus',''],['marketType','fancy']])
                ->select('runners.*','events.name as eventName','events.sport_id')
                ->distinct()->get();

        }
        else if($marketStatus=="CLOSED"){
            $markets=DB::table('markets')->join('events','markets.event_id','events.id')->where([['markets.marketStatus',$marketStatus]])->select('markets.*','events.name as eventName','events.sport_id')->get();
            foreach ($markets as $market){
                $pAndL=DB::table('settlement')->where([['admin_id',$user_id],['market_id',$market->id],['user_type',$userType],['runner_id',-1]])->value('pAndL');
                if (empty($pAndL))continue;
                $market->pAndL=$pAndL;
                $res[]=$market;
            }
            $runners = DB::table('runners')
                ->join('markets', 'runners.market_id', 'markets.id')
                ->join('events','markets.event_id','events.id')
                ->where([['runners.runnerStatus','CLOSED'],['markets.marketType','fancy']])
                ->select('runners.*','events.name as eventName','events.sport_id')
                ->distinct()->get();
            foreach ($runners as $runner){
                $pAndL=DB::table('settlement')->where([['admin_id',$user_id],['user_type',$userType],['runner_id',$runner->id]])->value('pAndL');
                if (empty($pAndL))continue;
                $runner->pAndL=$pAndL;
                $fancyRes[]=$runner;
            }
        }else{
            $res=DB::table('markets')->join('events','markets.event_id','events.id')->where([['markets.marketStatus',$marketStatus]])->select('markets.*','events.name as eventName','events.sport_id')->get();
            $fancyRes = DB::table('runners')
                ->join('markets', 'runners.market_id', 'markets.id')
                ->join('events','markets.event_id','events.id')
                ->join('betslip', 'betslip.runner_id', 'runners.id')
                ->where([['runners.runnerStatus',$marketStatus],['marketType','fancy']])
                ->select('runners.*','events.name as eventName','events.sport_id')
                ->distinct()->get();
        }

        return $this->response(0,'Get Market of marketStatus',['markets'=>$res,'fancyMarkets'=>$fancyRes]);
    }

    /**
     * Show the application dashboard.
     *6046:Football,
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('home');
    }
    private function setMatchedBetslip($runner_id)
    {
        ///$this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header
        //('authentication'));
        $res = 'true';
        $runner = DB::table('runners')->where('id', $runner_id)->first();
        if (!isset($runner->bet_typ)) return json_encode($runner);
        if ($runner->bet_type == 'availableToBack') {
            $values = json_decode($runner->availableToBack);
            $odds = array();
            foreach ($values as $value) {
                $odds[] = $value->price;
            }
            DB::table('betslip')->where([['bet_type', 'availableToBack'], ['is_matched', 'false'], ['odd' < max($odds)]])->update(['is_matched' => 'true']);

        } else {
            $values = json_decode($runner->availableToLay);
            $odds = array();
            foreach ($values as $value) {
                $odds[] = $value->price;
            }
            DB::table('betslip')->where([['bet_type', 'availableToLay'], ['is_matched', 'false'], ['odd' > min($odds)]])->update(['is_matched' => 'true']);
        }
    }

    public function insert_runner($market_id)
    {
        //$this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header
        //('authentication'));
        $runners = json_decode(DB::table('markets')->where('id', $market_id)->value('runners'));
        $send_data = array();
        foreach ($runners as $runner) {
            $array = [
                'market_id' => $market_id,
                'runnerId' => $runner->selectionId,
                'runnerName' => $runner->description->runnerName,
                'status' => $runner->state->status,
            ];
            $db_runner = DB::table('runners')->where([['market_id', $market_id], ['runnerId', $runner->selectionId]])->first();
            if (isset($runner->exchange->availableToBack)) {
                $array['availableToBack'] = json_encode($runner->exchange->availableToBack);
                DB::table('runners')->updateOrInsert(['market_id' => $market_id, 'runnerId' => $runner->selectionId], $array);
                $sent_runner = DB::table('runners')->where([['market_id', $market_id], ['runnerId', $runner->selectionId]])->first();
                $sent_runner->availableToBack = empty($sent_runner->availableToBack) ? array() : json_decode($sent_runner->availableToBack);
                $sent_runner->availableToLay = empty($sent_runner->availableToLay) ? array() : json_decode($sent_runner->availableToLay);
                if (!empty($db_runner)) {
                    if ($array['availableToBack'] !== $db_runner->availableToBack) {
                        $item['id'] = $db_runner->id;
                        $item['type'] = 'availableToBack';
                        $item['runner'] = $sent_runner;
                        $send_data[] = $item;
                        $this->setMatchedBetslip($db_runner->id);
                    }
                }
            }
            if (isset($runner->exchange->availableToLay)) {
                $array['availableToLay'] = json_encode($runner->exchange->availableToLay);
                DB::table('runners')->updateOrInsert(['market_id' => $market_id, 'runnerId' => $runner->selectionId], $array);
                if (!empty($db_runner)) {
                    if ($array['availableToLay'] !== $db_runner->availableToLay) {
                        $item['id'] = $db_runner->id;
                        $item['type'] = 'availableToLay';
                        $item['runner'] = $sent_runner;
                        $send_data[] = $item;
                        $this->setMatchedBetslip($db_runner->id);
                    }
                }
            }

        }
        $admin = Admin::where('id', 2)->first();
        $user = User::where('id', 3)->first();
        $notification_data = array();
        $notification_data['type'] = 'update odd';
        $notification_data['message'] = 'updated odd ' . $market_id;
        $notification_data['link'] = $send_data;
        $notification_data['user_type'] = 'users';
        if (count($send_data) > 0) {
            $fireBase = new FirebaseController();
            $fireBase->runnerUpdate($notification_data);
        }

        //$user->notify(new RepliedToThread($admin,$notification_data));
        return json_encode('success');
    }

    public function getMyMarkets($id, $userType)
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $markets = DB::table('markets')
            ->join('market', 'markets.id', 'market.market_id')
            ->where([['market.user_id', $id], ['markets.is_active', 1], ['market.user_type', $userType],['markets.marketStatus','OPEN']])
            ->orderby('market.id','ASC')
            ->select('markets.*')->get();
        $send_data['markets'] = $markets;
        return $this->response(1, 'Success get Markets in event', $send_data);
    }
    public function getFancyMarkets($is_super=-1)
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        if ($is_super==0){
            $markets = DB::table('markets')
                ->where([ ['markets.marketType','fancy']])
                //->orderby('market.id','ASC')
                ->select('markets.*')->get();
            $f_markets=array();
        }
        else{
            $markets = DB::table('markets')
                ->where([ ['markets.is_active', 1],['markets.marketType','fancy']])
                //->orderby('market.id','ASC')
                ->select('markets.*')->get();
            $f_markets=array();
        }
        foreach ($markets as $item){
            $temp=DB::table('markets')->where([['marketId',$item->marketId],['marketName','Match Odds']])->first();
            if (!isset($temp))continue;
            if ($temp->is_active!=1)continue;
            if ($temp->marketStatus=='CLOSED' or $temp->marketStatus=='CANCELED' )continue;
            $f_markets[]=$item;
        }
        $send_data['markets'] = $f_markets;
        return $this->response(1, 'Success get Markets in event', $send_data);
    }
    public function getMyMarketsOfBetting($user_id)
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $markets = DB::table('markets')
            ->join('runners', 'runners.market_id', 'markets.id')
            ->join('betslip', 'betslip.runner_id', 'runners.id')
            ->where([['betslip.user_id', $user_id], ['betslip.state', 1],['markets.marketStatus','OPEN']])->select('markets.*')

            ->distinct()->get();
        $send_data = $markets;
        return $this->response(1, 'Success get Markets in event', $send_data);
    }

    public function getMyAccountMarketsOfBetting($user_id)
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $admin_ids = Admin::where('parent_id', $user_id)->pluck('id');
        $admin_ids[] = $user_id;
        $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
        $admin_ids[] = $user_id;
        $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
        $admin_ids[] = $user_id;
        $user_ids = User::whereIn('parent_id', $admin_ids)->pluck('id')->unique();
        //return json_encode($user_ids);
        $markets = DB::table('markets')
            ->join('runners', 'runners.market_id', 'markets.id')
            ->join('betslip', 'betslip.runner_id', 'runners.id')
            ->whereIn('betslip.user_id', $user_ids)
            ->where([['betslip.state', 1],['markets.marketStatus','OPEN']])->select('markets.*')
            ->orderByRaw("FIELD(marketName , 'Match Odds','Fancy Markets') DESC")
            ->distinct()->get();
        $send_data = $markets;
        return $this->response(1, 'Success get Markets in event', $send_data);
    }
    public function getAdminIdsOfDownline($admin_id,$is_super){
        $admin=Admin::find($admin_id);
        $adminIds[]=$admin->id;
        if ($admin->is_super>$is_super)return [];
        if ($admin->is_super==$is_super)return $adminIds;

        for ($i=$admin->is_super;$i<$is_super;$i++){
            $temp = Admin::whereIn('parent_id', $adminIds)->where('is_super',$i)->pluck('id')->toArray();
            if (empty($temp))continue;
            $adminIds=array_merge($adminIds,$temp);
        }
        return $adminIds;
    }
    public function getAdmins()
    {
        $admin = DB::table('admins')->where('id', \request('parent_id'))->first();
        $adminIds=$this->getAdminIdsOfDownline(\request('parent_id'),\request('is_super'));
        $myAccount=0;
        if (!empty(\request('getType'))){
            $myAccount=1;
        }
        if (\request('is_super') == 4) {
            if ($myAccount==0) {
                $users = DB::table('users')->whereIn('parent_id',$adminIds)->get();
            } else {
                $users = DB::table('users')->where([['parent_id', \request('parent_id')]])->get();
            }
            $admins = array();
            foreach ($users as $user) {
                $parentId = $user->parent_id;
                $userName = '';
                while (true) {
                    $rootAdmin = DB::table('admins')->where('id', $parentId)->first();
                    if ($parentId == 0) break;
                    switch ($rootAdmin->is_super) {
                        case 1:
                            $user->admin = $rootAdmin->email;
                            break;
                        case 2:
                            $user->super_master = $rootAdmin->email;
                            break;
                        case 3:
                            $user->master = $rootAdmin->email;
                            break;
                    }
                    $parentId = $rootAdmin->parent_id;


                    //$userName=$rootAdmin->email.'/'.$userName;
                }
                //$userName=$userName.$user->email;
                //$user->email=$userName;
                $admins[] = $user;
            }
            return $admins;
        } else {
            if ($myAccount==0) {
                $admins = DB::table('admins')->whereIn('parent_id',$adminIds)->where([['is_super', \request('is_super')]])->get();
            } else {
                $admins = DB::table('admins')->where([['parent_id', \request('parent_id')], ['is_super', \request('is_super')]])->get();
            }
            $admins_f = array();
            foreach ($admins as $user) {
                $parentId = $user->parent_id;
                $userName = '';
                while (true) {
                    $rootAdmin = DB::table('admins')->where('id', $parentId)->first();
                    $parentId = $rootAdmin->parent_id;
                    if ($parentId == 0) break;
                    switch ($rootAdmin->is_super) {
                        case 1:
                            $user->admin = $rootAdmin->email;
                            break;
                        case 2:
                            $user->super_master = $rootAdmin->email;
                            break;
                        case 3:
                            $user->master = $rootAdmin->email;
                            break;
                    }
                    //$userName=$rootAdmin->email.'/'.$userName;
                }
                $userName = $userName . $user->email;
                $user->email = $userName;
                $admins_f[] = $user;
            }
            return $admins_f;
        }

    }

    public function depositToChildUser()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $admin = Admin::find(\request('user_id'));
        $c_user = \request('user_type') == 'admins' ? Admin::find(\request('child_id')) : User::find(\request('child_id'));
        if (empty($c_user)) return json_encode(['state' => 0, 'message' => 'Unable data', 'data' => \request('child_id')]);
        if (\request('amount')==0) return json_encode(['state' => 0, 'message' => 'Unable data', 'data' => \request('amount')]);


        $admin->wallet = $admin->wallet - \request('amount');
        if ($admin->wallet < 0) {
            return json_encode(['state' => 0, 'message' => 'Unable amount', 'data' => $c_user]);
        }

        $c_user->wallet = $c_user->wallet + \request('amount');
        $c_user->credit_limit = $c_user->credit_limit + \request('amount');
        if ($c_user->wallet < 0) {
            return json_encode(['state' => 0, 'message' => 'Unable amount', 'data' => $c_user]);
        }
        $parentReport=new Report();
        $parentReport->user_id=$admin->id;
        $parentReport->user_type='admins';
        $parentReport->t_id=$c_user->id;
        $parentReport->amount=-\request('amount');
        $parentReport->credit=\request('amount')<0?-\request('amount'):0;
        $parentReport->debit=\request('amount')>0?\request('amount'):0;
        $parentReport->total=$admin->wallet;
        $parentReport->narration=\request('amount') > 0?'Credit Out to '.$c_user->email:'CREDIT IN FROM '.$c_user->email;
        $parentReport->remark=\request('remark');
        $parentReport->date=Carbon::now();
        $parentReport->type='wallet';
        $parentReport->save();
        //total_wallet
        $parentReport=new Report();
        $parentReport->user_id=$admin->id;
        $parentReport->user_type='admins';
        $parentReport->t_id=$c_user->id;
        $parentReport->amount=-\request('amount');
        $parentReport->credit=\request('amount')<0?-\request('amount'):0;
        $parentReport->debit=\request('amount')>0?\request('amount'):0;
        $parentReport->total=$admin->wallet+$admin->cash+$admin->pAndL+$admin->comAmount;
        $parentReport->narration=\request('amount') > 0?'Credit Out to '.$c_user->email:'CREDIT IN FROM '.$c_user->email;
        $parentReport->remark=\request('remark');
        $parentReport->date=Carbon::now();
        $parentReport->type='total_wallet';
        $parentReport->save();


        $childReport=new Report();
        $childReport->user_id=$c_user->id;
        $childReport->user_type=\request('user_type');
        $childReport->t_id=$admin->id;
        $childReport->amount=\request('amount');
        $childReport->credit=\request('amount')>0?\request('amount'):0;
        $childReport->debit=\request('amount')<0?-\request('amount'):0;
        $childReport->total=$c_user->wallet;
        $childReport->narration=\request('amount') > 0?'Credit In from '.$admin->email:'Credit out to '.$admin->email;
        $childReport->remark=\request('remark');
        $childReport->date=Carbon::now();
        $childReport->type='wallet';
        $childReport->save();
        //total_wallet
        $childReport=new Report();
        $childReport->user_id=$c_user->id;
        $childReport->user_type=\request('user_type');
        $childReport->t_id=$admin->id;
        $childReport->amount=\request('amount');
        $childReport->credit=\request('amount')>0?\request('amount'):0;
        $childReport->debit=\request('amount')<0?-\request('amount'):0;
        $childReport->total=$c_user->wallet+$c_user->cash+$c_user->pAndL+$c_user->comAmount;
        $childReport->narration=\request('amount') > 0?'Credit In from '.$admin->email:'Credit out to '.$admin->email;
        $childReport->remark=\request('remark');
        $childReport->date=Carbon::now();
        $childReport->type='total_wallet';
        $childReport->save();


        $admin->save();
        $c_user->save();
        $msg = \request('amount') > 0 ? 'Deposit successfully' : 'Withdraw successfully';
        $note[\request('user_type')][$c_user->id]=['userType'=>\request('user_type'),'data'=>$childReport];
        $note['admins'][$admin->id]=['userType'=>'admins','data'=>$parentReport];
        return json_encode(['state' => 1, 'message' => $msg, 'data' => $c_user,'note'=>$note]);
    }

    public function getAdmin()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        //$admin=DB::table('admins')->where('id',\request('parent_id'))->first();
        $admin = DB::table('admins')->where([['id', \request('user_id')]])->first();
        return $this->response(100, 'Get Admin', $admin);
    }

    public function updateBalanceOfAdmin()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $r_data = Input::all();
        $user_id = $r_data['user_id'];
        $user = Admin::where('id', $user_id)->first();
        $send_data['wallet'] = $user->wallet;
        $send_data['liability'] = $user->exposure;
        $send_data['name'] = $user->email;
        //$send_data['winnings'] = $user->profit_loss_amount;
        return $this->response(100, 'Get balance', $user);
    }

    public function getEventDetail($id,$is_active='')
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $current_sport = DB::table('sport_names')
            ->join('events', 'sport_names.import_id', 'events.sport_id')
            ->where('events.id', $id)->select('sport_names.*')->first();
        $event=DB::table('events')->where('id',$id)->first();
        if ($is_active=='admin'){
            $markets = DB::table('markets')->where([['event_id', $id]/*,['markets.marketStatus','<>','CLOSED']*//*['marketType','MATCH_ODDS']*/])
                ->orderByRaw("FIELD(marketName , 'Match Odds') DESC")
                ->get();
        }else{
            $markets = DB::table('markets')->where([['event_id', $id],['markets.marketStatus','<>','CLOSED']/*['marketType','MATCH_ODDS']*/, ['is_active', 1]])
                ->orderByRaw("FIELD(marketName , 'Match Odds') DESC")
                ->get();
        }
        $send_data = array();
        $send_data['markets'] = $markets;
        $send_data['sports'] = $current_sport;
        $send_data['event'] = $event;
        return $this->response(1, 'Success get event in detail', $send_data);
    }

    public function getProfitAdmin1($runner_id, $user_id)
    {
        $market_id = DB::table('runners')->where('id', $runner_id)->value('market_id');
        //$user_id=\request('user_id');
        $admin_ids = Admin::where('parent_id', $user_id)->pluck('id');
        $admin_ids[] = $user_id;
        $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
        $admin_ids[] = $user_id;
        $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
        $admin_ids[] = $user_id;
        $user_ids = User::whereIn('parent_id', $admin_ids)->pluck('id')->unique();
        $profit = 0;
        foreach ($user_ids as $userId) {
            $item = DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', $runner_id], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('profit_amount')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', $runner_id], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', $runner_id], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', $runner_id], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('profit_amount');
            $profit += $item * $this->getPartnerShip($user_id, $userId);
        }

        return -$profit;
    }
    public function getFancyMarkets1(){//app
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $temp_markets = DB::table('markets')
            ->where([ ['markets.is_active', 1],['markets.marketType','fancy']])
            //->orderby('market.id','ASC')
            ->select('markets.*')->get();
        $markets=array();
        $send_data=array();
        foreach ($temp_markets as $item){
            $temp=DB::table('markets')->where([['marketId',$item->marketId],['marketName','Match Odds']])->first();
            if ($temp->is_active!=1)continue;
            if ($temp->marketStatus=='CLOSED' or $temp->marketStatus=='CANCELED' )continue;
            $markets[]=$item;
        }
        $user_id=\request('user_id');
//        $markets = DB::table('markets')
//            ->join('market', 'markets.id', 'market.market_id')
//            ->where([['market.user_id', $user_id], ['markets.is_active', 1], ['market.user_type', 'users'],['markets.marketStatus','OPEN']])
//            ->orderby('market.id','ASC')
//            ->select('markets.*')->get();
        foreach ($markets as $item1){
            $runners1 = DB::table('runners')
                ->join('markets', 'runners.market_id', 'markets.id')
                ->where([['markets.id', $item1->id], ['runners.is_active', 'true']])
                ->select('runners.*','markets.marketType')
                ->get();
            $runners = array();
            foreach ($runners1 as $item) {
                if (empty($item->availableToBack)) {
                    $item->availableToBack = array();
                } else {
                    $item->availableToBack = json_decode($item->availableToBack);
                }
                if (empty($item->availableToLay)) {
                    $item->availableToLay = array();
                } else {
                    $item->availableToLay = json_decode($item->availableToLay);
                }
                $s_id = $this->getSportOfRunner($item->id);
                $s_manage = DB::table('sport_management')->where([['sport_id', $s_id], ['admin_id', $user_id], ['userType', 'users']])->first();
                if ($item1->marketType=='fancy'){
                    $item->profit = $this->getLiabilityOfSession($item->id, $user_id);
                    $item->delaySec = $s_manage->f_delaySec;
                }else{
                    $item->profit = $this->getProfitOfRunner($item->id, $user_id);
                    $item->delaySec = $s_manage->delaySec;
                }

                $runners[] = $item;
            }
            $event = DB::table('events')
                ->join('markets', 'markets.event_id', 'events.id')
                ->join('sport_names', 'sport_names.import_id', 'events.sport_id')
                ->where('markets.id', $item1->id)
                ->select('events.*', 'sport_names.name as sportName')->first();
            $market = DB::table('markets')->where([['id', $item1->id], ['is_active', 1]])->first();
            $send_item = array();
            $is_multi = DB::table('market')->where([['market_id', $item1->id], ['user_id', $user_id], ['user_type', 'users']])->value('id');
            if (isset($is_multi)) {
                $send_item['multi'] = 'active_market';
            } else {
                $send_item['multi'] = 'deactive_market';
            }


            $send_item['event'] = $event;
            $send_item['runners'] = $runners;
            $send_item['market'] = $market;

            $send_data['markets'][] = $send_item;
        }

        return $this->response(1, 'Success get Markets in event', $send_data);
    }
    public function getMarketsOfBetslip(){//app
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $user_id=\request('user_id');
        $markets = DB::table('markets')
            ->join('runners', 'runners.market_id', 'markets.id')
            ->join('betslip', 'betslip.runner_id', 'runners.id')
            ->where([['betslip.user_id', $user_id], ['betslip.state', 1],['markets.marketStatus','OPEN']])->select('markets.*')
            ->distinct()->get();
        $send_data=array();
        foreach ($markets as $item1){
            $runners1 = DB::table('runners')
                ->join('markets', 'runners.market_id', 'markets.id')
                ->where([['markets.id', $item1->id], ['runners.is_active', 'true']])
                ->select('runners.*','markets.marketType')
                ->get();
            $runners = array();
            foreach ($runners1 as $item) {
                if (empty($item->availableToBack)) {
                    $item->availableToBack = array();
                } else {
                    $item->availableToBack = json_decode($item->availableToBack);
                }
                if (empty($item->availableToLay)) {
                    $item->availableToLay = array();
                } else {
                    $item->availableToLay = json_decode($item->availableToLay);
                }
                $s_id = $this->getSportOfRunner($item->id);
                $s_manage = DB::table('sport_management')->where([['sport_id', $s_id], ['admin_id', $user_id], ['userType', 'users']])->first();
                if ($item1->marketType=='fancy'){
                    $item->profit = $this->getLiabilityOfSession($item->id, $user_id);
                    $item->delaySec = $s_manage->f_delaySec;
                }else{
                    $item->profit = $this->getProfitOfRunner($item->id, $user_id);
                    $item->delaySec = $s_manage->delaySec;
                }

                $runners[] = $item;
            }
            $event = DB::table('events')
                ->join('markets', 'markets.event_id', 'events.id')
                ->join('sport_names', 'sport_names.import_id', 'events.sport_id')
                ->where('markets.id', $item1->id)
                ->select('events.*', 'sport_names.name as sportName')->first();
            $market = DB::table('markets')->where([['id', $item1->id], ['is_active', 1]])->first();
            $send_item = array();
            $is_multi = DB::table('market')->where([['market_id', $item1->id], ['user_id', $user_id], ['user_type', 'users']])->value('id');
            if (isset($is_multi)) {
                $send_item['multi'] = 'active_market';
            } else {
                $send_item['multi'] = 'deactive_market';
            }


            $send_item['event'] = $event;
            $send_item['runners'] = $runners;
            $send_item['market'] = $market;

            $send_data['markets'][] = $send_item;
        }

        return $this->response(1, 'Success get Markets in event', $send_data);
    }
    public function getMultiMarkets(){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $user_id=\request('user_id');
        $markets = DB::table('markets')
            ->join('market', 'markets.id', 'market.market_id')
            ->where([['market.user_id', $user_id], ['markets.is_active', 1], ['market.user_type', 'users'],['markets.marketStatus','OPEN']])
            ->orderby('market.id','ASC')
            ->select('markets.*')->get();
        $send_data=array();
        foreach ($markets as $item1){
            $runners1 = DB::table('runners')
                ->join('markets', 'runners.market_id', 'markets.id')
                ->where([['markets.id', $item1->id], ['runners.is_active', 'true']])
                ->select('runners.*','markets.marketType')
                ->get();
            $runners = array();
            foreach ($runners1 as $item) {
                if (empty($item->availableToBack)) {
                    $item->availableToBack = array();
                } else {
                    $item->availableToBack = json_decode($item->availableToBack);
                }
                if (empty($item->availableToLay)) {
                    $item->availableToLay = array();
                } else {
                    $item->availableToLay = json_decode($item->availableToLay);
                }
                $s_id = $this->getSportOfRunner($item->id);
                $s_manage = DB::table('sport_management')->where([['sport_id', $s_id], ['admin_id', $user_id], ['userType', 'users']])->first();
                if ($item1->marketType=='fancy'){
                    $item->profit = $this->getLiabilityOfSession($item->id, $user_id);
                    $item->delaySec = $s_manage->f_delaySec;
                }else{
                    $item->profit = $this->getProfitOfRunner($item->id, $user_id);
                    $item->delaySec = $s_manage->delaySec;
                }

                $runners[] = $item;
            }
            $event = DB::table('events')
                ->join('markets', 'markets.event_id', 'events.id')
                ->join('sport_names', 'sport_names.import_id', 'events.sport_id')
                ->where('markets.id', $item1->id)
                ->select('events.*', 'sport_names.name as sportName')->first();
            $market = DB::table('markets')->where([['id', $item1->id], ['is_active', 1]])->first();
            $send_item = array();
            $is_multi = DB::table('market')->where([['market_id', $item1->id], ['user_id', $user_id], ['user_type', 'users']])->value('id');
            if (isset($is_multi)) {
                $send_item['multi'] = 'active_market';
            } else {
                $send_item['multi'] = 'deactive_market';
            }


            $send_item['event'] = $event;
            $send_item['runners'] = $runners;
            $send_item['market'] = $market;

            $send_data['markets'][] = $send_item;
        }

        return $this->response(1, 'Success get Markets in event', $send_data);
    }
    public function getMarketsOfEvent(){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $event_id=\request('event_id');
        $user_id=\request('user_id');
        $current_sport = DB::table('sport_names')
            ->join('events', 'sport_names.import_id', 'events.sport_id')
            ->where('events.id', $event_id)->select('sport_names.*')->first();
        $event=DB::table('events')->where('id',$event_id)->first();
        $markets = DB::table('markets')->where([['event_id', $event_id], ['is_active', 1]])->get();
        $send_data['current_sport'] = $current_sport;
        $send_data['current_event'] = $event;
        foreach ($markets as $item1){
            $runners1 = DB::table('runners')
                ->join('markets', 'runners.market_id', 'markets.id')
                ->where([['markets.id', $item1->id], ['runners.is_active', 'true']])
                ->select('runners.*','markets.marketType')
                ->get();
            $runners = array();
            foreach ($runners1 as $item) {
                if (empty($item->availableToBack)) {
                    $item->availableToBack = array();
                } else {
                    $item->availableToBack = json_decode($item->availableToBack);
                }
                if (empty($item->availableToLay)) {
                    $item->availableToLay = array();
                } else {
                    $item->availableToLay = json_decode($item->availableToLay);
                }
                $s_id = $this->getSportOfRunner($item->id);
                $s_manage = DB::table('sport_management')->where([['sport_id', $s_id], ['admin_id', $user_id], ['userType', 'users']])->first();
                if ($item1->marketType=='fancy'){
                    $item->profit = $this->getLiabilityOfSession($item->id, $user_id);
                    $item->delaySec = $s_manage->f_delaySec;
                }else{
                    $item->profit = $this->getProfitOfRunner($item->id, $user_id);
                    $item->delaySec = $s_manage->delaySec;
                }

                $runners[] = $item;
            }
            $event = DB::table('events')
                ->join('markets', 'markets.event_id', 'events.id')
                ->join('sport_names', 'sport_names.import_id', 'events.sport_id')
                ->where('markets.id', $item1->id)
                ->select('events.*', 'sport_names.name as sportName')->first();
            $market = DB::table('markets')->where([['id', $item1->id], ['is_active', 1]])->first();
            $send_item = array();
            $is_multi = DB::table('market')->where([['market_id', $item1->id], ['user_id', $user_id], ['user_type', 'users']])->value('id');
            if (isset($is_multi)) {
                $send_item['multi'] = 'active_market';
            } else {
                $send_item['multi'] = 'deactive_market';
            }


            $send_item['event'] = $event;
            $send_item['runners'] = $runners;
            $send_item['market'] = $market;

            $send_data['markets'][] = $send_item;
        }

        return $this->response(1, 'Success get Markets in event', $send_data);
    }
    public function getRunnersOfMarketAdmin($id, $user_id)
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $market = DB::table('markets')->where([['id', $id], /*['is_active', 1]*/])->first();
        if ($market->marketType=='fancy'){
            $runners1 = DB::table('runners')
                ->join('markets', 'runners.market_id', 'markets.id')
                ->where([['markets.id', $id], ['runners.is_active', 'true']])
                ->orderBy('runners.runnerName','ASC')
                ->select('runners.*')
                ->get();
        }else{
            $runners1 = DB::table('runners')
                ->join('markets', 'runners.market_id', 'markets.id')
                ->where([['markets.id', $id], ['runners.is_active', 'true']])
                ->select('runners.*')
                ->get();
        }
        $runners1=$runners1->values()->all();
        $runners = array();
        foreach ($runners1 as $item) {
            if (empty($item->availableToBack)) {
                $item->availableToBack = array();
            } else {
                $item->availableToBack = json_decode($item->availableToBack);
            }
            if (empty($item->availableToLay)) {
                $item->availableToLay = array();
            } else {
                $item->availableToLay = json_decode($item->availableToLay);
            }
            $item->availableToBackVol = json_decode($item->availableToBackVol);
            $item->availableToLayVol = json_decode($item->availableToLayVol);
            if ($market->marketType=='fancy'){
                $item->profit = $this->maxLiabilityOfSession($item->id, $user_id,'admins');
            }else{
                $item->profit = $this->getProfitAdmin1($item->id, $user_id);
            }

            $runners[] = $item;
        }
        $event = DB::table('events')
            ->join('markets', 'markets.event_id', 'events.id')
            ->join('sport_names', 'sport_names.import_id', 'events.sport_id')
            ->where('markets.id', $id)
            ->select('events.*', 'sport_names.name as sportName')->first();

        $market_management = DB::table('market_management')->where([['market_id', $market->id], ['user_id', $user_id], ['user_type', 'admins']])->first();
        if (!isset($market_management)) {
            $sport_management = DB::table('sport_management')->where([['admin_id', $user_id], ['userType', 'admins'], ['sport_id', $event->sport_id]])->first();
            //return json_encode($sport_management);
            if ($market->marketType=='fancy'){
                $id = DB::table('market_management')->insertGetId([
                    'market_id' => $market->id,
                    'user_id' => $user_id,
                    'user_type' => 'admins',
                    'minStake' => $sport_management->f_minStake,
                    'maxStake' => $sport_management->f_maxStake,
                    'maxProfit' => $sport_management->f_profit,
                    'preInplayProfit' => $sport_management->preInplayProfit,
                    'preInplayStake' => $sport_management->preInplayStake,
                    'commission' => $sport_management->f_commission,
                    'delaySec' => $sport_management->f_delaySec,
                    'unMatched' => $sport_management->f_unMatched,
                    'lockBet' => $sport_management->f_lockBet,
                ]);
            }else{
                $id = DB::table('market_management')->insertGetId([
                    'market_id' => $market->id,
                    'user_id' => $user_id,
                    'user_type' => 'admins',
                    'minStake' => $sport_management->minStake,
                    'maxStake' => $sport_management->maxStake,
                    'maxProfit' => $sport_management->maxProfit,
                    'preInplayProfit' => $sport_management->preInplayProfit,
                    'preInplayStake' => $sport_management->preInplayStake,
                    'commission' => $sport_management->commission,
                    'delaySec' => $sport_management->delaySec,
                    'unMatched' => $sport_management->unMatched,
                    'lockBet' => $sport_management->lockBet,
                ]);
            }

            $market_management = DB::table('market_management')->where([['id', $id]])->first();
        }

        $send_data = array();
        $is_check=DB::table('market')->where([['user_id',$user_id],['user_type','admins'],['market_id',$market->id]])->first();
        if (empty($is_check)){
            $send_data['multi_market'] = 'deactive_market';
        }else{
            $send_data['multi_market'] = 'active_market';
        }
        $send_data['event'] = $event;
        $send_data['runners'] = $runners;
        $send_data['market'] = $market;
        $send_data['market_management'] = $market_management;
        return json_encode($send_data);
    }

    public function setMarketManage()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $admin = Admin::find(\request('user_id'));
        if ($admin->is_supper != 0) {
            return $this->response(0, 'You can not set this option because of your permission.', '');
        }
        $market_management = json_decode(json_encode(request('market_management')));
        //echo($market_management->minStake);
        DB::table('market_management')
            ->where('market_id', $market_management->market_id)
            ->update([
                'minStake' => $market_management->minStake,
                'maxStake' => $market_management->maxStake,
                'maxProfit' => $market_management->maxProfit,
                'preInplayProfit' => $market_management->preInplayProfit,
                'preInplayStake' => $market_management->preInplayStake,
                'commission' => $market_management->commission,
                'delaySec' => $market_management->delaySec,
                'unMatched' => $market_management->unMatched,
                'lockBet' => $market_management->lockBet,
            ]);
        return $this->response(0, 'Updated successfully', '');
    }
    public function setMarketResultFromApi($marketId,$market_result)
    {
        //$event_id=DB::table('markets')->where('id',$marketId)->value('event_id');
        //$market_ids = DB::table('markets')->where('event_id',$event_id)->pluck('id');
        $market_ids[]=$marketId;
        foreach ($market_ids as $market_id){
            //$market_result = \request('market_result');
            if ($market_result == '--Suspend--') {
                DB::table('markets')->where('id', $market_id)->update(['market_result' => 'done', 'marketStatus' => 'SUSPENDED']);
            } else if ($market_result == '--Abandon--') {
                DB::table('markets')->where('id', $market_id)->update(['market_result' => 'done', 'marketStatus' => 'CANCELED', 'winnerName' => '--Abandon--','isUpdate'=>0]);
            } else {
                DB::table('markets')->where('id', $market_id)->update(['market_result' => 'done', 'marketStatus' => 'CLOSED', 'winnerName' => $market_result,'isUpdate'=>0]);
                DB::table('runners')->where([['market_id', $market_id], ['runnerName', $market_result]])->update(['status' => 'WINNER']);
                DB::table('runners')->where([['market_id', $market_id], ['runnerName', '<>', $market_result]])->update(['status' => 'LOSER']);
            }
            $temp = $this->betResult($market_id);
        }
        //return $this->response(0, 'Updated successfully/' . json_encode($temp), $market_ids);
    }
    public function setMarketResult()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $admin = Admin::find(\request('user_id'));
        if ($admin->is_supper != 0) {
            return $this->response(0, 'You can not set this option because of your permission.', '');
        }
        //$event_id=DB::table('markets')->where('id',\request('market_id'))->value('event_id');
        //$market_ids = DB::table('markets')->where('event_id',$event_id)->pluck('id');
        $market_id=\request('market_id');
        $market_result = \request('market_result');
            if ($market_result == '--Suspend--') {
                DB::table('markets')->where('id', $market_id)->update(['market_result' => 'done', 'marketStatus' => 'SUSPENDED','isUpdate'=>0]);
            } else if ($market_result == '--Abandon--') {
                DB::table('markets')->where('id', $market_id)->update(['market_result' => 'done', 'marketStatus' => 'CANCELED', 'winnerName' => '--Abandon--','isUpdate'=>0]);
            } else {
                DB::table('markets')->where('id', $market_id)->update(['market_result' => 'done', 'marketStatus' => 'CLOSED', 'winnerName' => $market_result,'isUpdate'=>0]);
                DB::table('runners')->where([['market_id', $market_id], ['runnerName', $market_result]])->update(['status' => 'WINNER']);
                DB::table('runners')->where([['market_id', $market_id], ['runnerName', '<>', $market_result]])->update(['status' => 'LOSER']);
            }
            $temp = $this->betResult($market_id);
        return $this->response(0, 'Updated successfully/' . json_encode($temp), Market::find($market_id));
    }
    public function updateShowRunner(){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $runner = json_decode(json_encode(\request('runner')));
        Runner::where('id', $runner->id)->update(['is_show'=>$runner->is_show]);
        return $this->response(0,''.$runner->id,'');
    }
    public function setResultOfSession()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $runner = json_decode(json_encode(\request('runner')));
        $db_runner=Runner::where('id', $runner->id)->first();

        if ($runner->runnerStatus == 'CLOSED') {
            Runner::where('id', $runner->id)->update(['runnerStatus' => $runner->runnerStatus, 'score' => $runner->score,'is_show'=>$runner->is_show,'state'=>1]);
            if ($db_runner->runnerStatus=='CLOSED')return $this->response(0,'CLOSED already'.$runner->id,'');
            $res=$this->sessionResult($runner->id);
            return $this->response(0,'CLOSED'.$runner->id,$res);
        } else if ($runner->runnerStatus == 'CANCELED') {
            Runner::where('id', $runner->id)->update(['runnerStatus' => $runner->runnerStatus, 'score' => $runner->score,'is_show'=>$runner->is_show,'state'=>1]);
            $res=$this->sessionResult($runner->id);
            return $this->response(0,'CANCELED',$res);
        } else if ($runner->runnerStatus == 'SUSPENDED') {
            Runner::where('id', $runner->id)->update(['runnerStatus' => $runner->runnerStatus, 'score' => $runner->score,'is_show'=>$runner->is_show,'state'=>1]);
            $res=$this->sessionResult($runner->id);
            return $this->response(0,$runner->id.':'.$runner->runnerStatus,$res);
        } else {
            $res=$this->sessionUnDeclare($runner->id);
            return $this->response(0,'Undeclared successfully',$res);
        }
    }
    public function sessionResult($runner_id){
        $runner = DB::table('runners')->where([['id', $runner_id],/*['marketStatus','DONE']*/])->first();
        if (!isset($runner)) return;
        $market=DB::table('markets')->where('id',$runner->market_id)->first();
        $event=DB::table('events')->where('id',$market->event_id)->first();
        $sport=DB::table('sport_names')->where('id',$event->sport_id)->first();
        $user_ids = DB::table('betslip')->join('runners', 'runners.id', 'betslip.runner_id')->where([['runners.id', $runner->id], ['is_active', 'true']])->pluck('user_id')->unique();
        //return $user_ids;
        $n_adminIds=[];
        if (empty($user_ids)) return;
        foreach ($user_ids as $user_id) {
            $liability = $this->getLiabilityOfSession($runner->id, $user_id);
            $user = User::find($user_id);
            if ($runner->runnerStatus == 'CANCELED') {////refund Bet
                $user->wallet -= $liability;
                $user->exposure -= $liability;
                if ($user->exposure>0)$user->exposure=0;
                $user->save();
                DB::table('betslip')->where([['user_id', $user_id], ['runner_id', $runner->id]])->update(['state' => 2, 'profit' => 'refunded']);
            }
            elseif ($runner->runnerStatus == 'CLOSED')
            {
                ////DONE Bet
                $user->wallet -= $liability;
                $user->exposure -= $liability;
                if ($user->exposure>0)$user->exposure=0;
                //getProfitOfRunner
                $profit = $this->getProfitOfScore($runner->id,$user_id,$runner->score);

                if ($profit > 0) {
                    $com = $this->getSessionCom($runner->market_id, $user_id);
                    $comUpAmount=$profit*$com;
                    $r_profit=$profit;
                    $user->pAndL+=$r_profit;
                    $user->comAmount-=$comUpAmount;
                    $user->comUp-=$comUpAmount;
                    $user->comUp1-=$comUpAmount;
                    $user->bUp+=$r_profit;
                    $user->bUp1+=$r_profit;
                    $bUpAmount=$r_profit;
                    //settlement
                    $child_id=DB::table('settlement')->insertGetId([
                        'admin_id'=>$user_id,
                        'user_type'=>'users',
                        'child_id'=>0,
                        'market_id'=>$runner->market_id,
                        'runner_id'=>$runner->id,
                        'pAndL'=>$r_profit,
                        'bUp'=>$r_profit,
                        'bDown'=>0,
                        'comAmount'=>-$comUpAmount,
                        'comUp'=>-$comUpAmount,
                        'comDown'=>0,
                        'date'=>Carbon::now(),
                    ]);

                    //profit and loss report
                    $userReport=new Report();
                    $userReport->user_id=$user->id;
                    $userReport->user_type='users';
                    $userReport->t_id=$runner_id;
                    $userReport->amount=$r_profit/*-$comUpAmount*/;
                    $userReport->credit=$r_profit/*-$comUpAmount*/;
                    $userReport->debit=0;
                    $userReport->total=$user->pAndL;
                    $userReport->narration=$sport->name.'-'.$event->name.'-'.$runner->score;
                    $userReport->remark='P|L';
                    $userReport->type='P|L';
                    $userReport->t_type='runners';
                    $userReport->date=Carbon::now();
                    $userReport->save();
                    //commission
                    $userReport=new Report();
                    $userReport->user_id=$user->id;
                    $userReport->user_type='users';
                    $userReport->t_id=$runner->id;
                    $userReport->amount=-$comUpAmount;
                    $userReport->credit=0;
                    $userReport->debit=$comUpAmount;
                    $userReport->total=$user->comAmount;
                    $userReport->narration=$sport->name.'-'.$event->name.'-'.$runner->score;
                    $userReport->remark='Commission';
                    $userReport->type='Commission';
                    $userReport->t_type='runners';
                    $userReport->date=Carbon::now();
                    $userReport->save();
                    /////total wallet report
                    //total_wallet profit and loss report
                    $userReport=new Report();
                    $userReport->user_id=$user->id;
                    $userReport->user_type='users';
                    $userReport->t_id=$runner->id;
                    $userReport->amount=$r_profit/*-$comUpAmount*/;
                    $userReport->credit=$r_profit/*-$comUpAmount*/;
                    $userReport->debit=0;
                    $userReport->total=$user->wallet+$user->cash+$user->pAndL/*+$user->comAmount*/;
                    $userReport->narration=$sport->name.'-'.$event->name.'-'.$runner->score;
                    $userReport->remark='P|L';
                    $userReport->type='total_wallet';
                    $userReport->t_type='runners';
                    $userReport->date=Carbon::now();
                    $userReport->save();
                    //total_wallet commission
                    $userReport=new Report();
                    $userReport->user_id=$user->id;
                    $userReport->user_type='users';
                    $userReport->t_id=$runner->id;
                    $userReport->amount=-$comUpAmount;
                    $userReport->credit=0;
                    $userReport->debit=$comUpAmount;
                    $userReport->total=$user->wallet+$user->cash+$user->pAndL+$user->comAmount;
                    $userReport->narration=$sport->name.'-'.$event->name.'-'.$runner->score;
                    $userReport->remark='Commission';
                    $userReport->type='total_wallet';
                    $userReport->t_type='runners';
                    $userReport->date=Carbon::now();
                    $userReport->save();
                    /////////////////////////////////////////
                    $admin_ids = $this->getUpLineAdminIds($user_id);
                    foreach ($admin_ids as $admin_id) {
                        $admin = Admin::find($admin_id);
                        $amount = $r_profit * $this->getPartnerShip($admin->id, $user_id);
                        $adminComAmount = $this->getPartnerShip($admin->id, $user_id) * $r_profit*$com;

                        $admin->pAndL -= $amount;
                        $admin->comAmount += $adminComAmount;
                        $admin->bUp += $bUpAmount-$amount;
                        $admin->bUp1 += $bUpAmount-$amount;
                        $admin->comUp -= $comUpAmount-$adminComAmount;
                        $admin->comUp1 -= $comUpAmount-$adminComAmount;
                        $admin->bDown -= $bUpAmount;
                        $admin->bDown1 -= $bUpAmount;
                        $admin->comDown += $comUpAmount;
                        $admin->comDown1 += $comUpAmount;
                        $child_id=DB::table('settlement')->insertGetId([
                            'child_id'=>$child_id,
                            'admin_id'=>$admin_id,
                            'user_type'=>'admins',
                            'market_id'=>$market->id,
                            'runner_id'=>$runner_id,
                            'pAndL'=>-$amount,
                            'bUp'=>$bUpAmount-$amount,
                            'bDown'=>-$bUpAmount,
                            'comAmount'=>$adminComAmount,
                            'comUp'=>-($comUpAmount-$adminComAmount),
                            'comDown'=>$comUpAmount,
                            'date'=>Carbon::now(),
                        ]);
                        $admin->save();
                        $bUpAmount=$bUpAmount-$amount;
                        $comUpAmount=$comUpAmount-$adminComAmount;
                    }
                } else {
                    $r_profit=$profit;
                    $user->pAndL+=$r_profit;
                    $user->bUp+=$r_profit;
                    $user->bUp1+=$r_profit;
                    $bUpAmount=$r_profit;
                    $child_id=DB::table('settlement')->insertGetId([
                        'admin_id'=>$user_id,
                        'user_type'=>'users',
                        'child_id'=>0,
                        'market_id'=>$market->id,
                        'runner_id'=>$runner_id,
                        'pAndL'=>$r_profit,
                        'bUp'=>$r_profit,
                        'bDown'=>0,
                        'date'=>Carbon::now(),
                    ]);

                    //profit and loss report
                    $userReport=new Report();
                    $userReport->user_id=$user->id;
                    $userReport->user_type='users';
                    $userReport->t_id=$runner->id;
                    $userReport->amount=$r_profit;
                    $userReport->credit=0;
                    $userReport->debit=-$r_profit;
                    $userReport->total=$user->pAndL;
                    $userReport->narration=$sport->name.'-'.$event->name.'-'.$runner->score;
                    $userReport->remark='P|L';
                    $userReport->type='P|L';
                    $userReport->t_type='runners';
                    $userReport->date=Carbon::now();
                    $userReport->save();
                    //total wallet
                    //total_wallet profit and loss report
                    $userReport=new Report();
                    $userReport->user_id=$user->id;
                    $userReport->user_type='users';
                    $userReport->t_id=$runner->id;
                    $userReport->amount=$r_profit;
                    $userReport->credit=0;
                    $userReport->debit=-$r_profit;
                    $userReport->total=$user->wallet+$user->cash+$user->pAndL+$user->comAmount;
                    $userReport->narration=$sport->name.'-'.$event->name.'-'.$runner->score;
                    $userReport->remark='P|L';
                    $userReport->type='total_wallet';
                    $userReport->t_type='runners';
                    $userReport->date=Carbon::now();
                    $userReport->save();
                    $admin_ids = $this->getUpLineAdminIds($user_id);
                    foreach ($admin_ids as $admin_id) {
                        $admin = Admin::find($admin_id);
                        $amount = $profit * $this->getPartnerShip($admin->id, $user_id);
                        $admin->pAndL -= $amount;
                        $admin->bUp += $bUpAmount-$amount;
                        $admin->bUp1 += $bUpAmount-$amount;
                        $admin->bDown -= $bUpAmount;
                        $admin->bDown1 -= $bUpAmount;

                        //$admin->wallet += $amount;
                        $admin->save();
                        $child_id=DB::table('settlement')->insertGetId([
                            'admin_id'=>$admin_id,
                            'user_type'=>'admins',
                            'child_id'=>$child_id,
                            'market_id'=>$market->id,
                            'runner_id'=>$runner_id,
                            'pAndL'=>-$amount,
                            'bUp'=>$bUpAmount-$amount,
                            'bDown'=>-$bUpAmount,
                            'date'=>Carbon::now(),
                        ]);
                        $bUpAmount=$bUpAmount-$amount;
                        //return $admin->wallet;
                    }
                }
                DB::table('betslip')->where([['user_id', $user_id], ['runner_id', $runner->id],['rate',$runner->score]])->update(['state' => 2, 'profit' => 'profit']);
                DB::table('betslip')->where([['user_id', $user_id], ['runner_id', $runner->id],['rate','<>',$runner->score]])->update(['state' => 2, 'profit' => 'loss']);

                $user->save();
            }

        }
        $admins=DB::table('admins')->get();
        foreach ($admins as $admin){
            $profit=DB::table('settlement')->where([['admin_id',$admin->id],['user_type','admins'],['runner_id',$runner_id]])->sum('pAndL');
            $comAmount=DB::table('settlement')->where([['admin_id',$admin->id],['user_type','admins'],['runner_id',$runner_id]])->sum('comAmount');
            $comUp=DB::table('settlement')->where([['admin_id',$admin->id],['user_type','admins'],['runner_id',$runner_id]])->sum('comUp');
            $comDown=DB::table('settlement')->where([['admin_id',$admin->id],['user_type','admins'],['runner_id',$runner_id]])->sum('comDown');
            $bUp=DB::table('settlement')->where([['admin_id',$admin->id],['user_type','admins'],['runner_id',$runner_id]])->sum('bUp');
            $bDown=DB::table('settlement')->where([['admin_id',$admin->id],['user_type','admins'],['runner_id',$runner_id]])->sum('bDown');
            if ($profit==0)continue;
            if ($profit>0){
                if ($bDown!=0){
                    //profit
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$runner->id;
                    $report->amount=$bDown;
                    $report->credit=$bDown;
                    $report->debit=0;
                    $report->total=$admin->pAndL;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$runner->score;
                    $report->remark='P|L';
                    $report->type='P|L';
                    $report->t_type='runners';
                    $report->date=Carbon::now();
                    $report->save();
                    //total wallet of profit
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$runner->id;
                    $report->amount=$bDown;
                    $report->credit=$bDown;
                    $report->debit=0;
                    $report->total=$admin->wallet+$admin->cash+$admin->pAndL+$admin->comAmount-$bUp;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$runner->score;
                    $report->remark='P|L';
                    $report->type='total_wallet';
                    $report->t_type='runners';
                    $report->date=Carbon::now();
                    $report->save();
                }
                if ($bUp!=0){
                    //profit report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$runner->id;
                    $report->amount=$bUp;
                    $report->credit=0;
                    $report->debit=-$bUp;
                    $report->total=$admin->pAndL;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$runner->score.' Parent';
                    $report->remark='P|L';
                    $report->type='P|L';
                    $report->t_type='runners';
                    $report->date=Carbon::now();
                    $report->save();
                    //total_wallet profit report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$runner->id;
                    $report->amount=$bUp;
                    $report->credit=0;
                    $report->debit=-$bUp;
                    $report->total=$admin->wallet+$admin->cash+$admin->pAndL+$admin->comAmount;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$runner->score.' Parent';
                    $report->remark='P|L';
                    $report->type='total_wallet';
                    $report->t_type='runners';
                    $report->date=Carbon::now();
                    $report->save();
                }
            }
            else
            {
                //commission
                if ($comDown!=0)
                {
                    //commission report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$runner->id;
                    $report->amount=$comDown;
                    $report->credit=$comDown;
                    $report->debit=0;
                    $report->total=$admin->comAmount-$comUp;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$runner->score;
                    $report->remark='Commission';
                    $report->type='Commission';
                    $report->t_type='runners';
                    $report->date=Carbon::now();
                    $report->save();
                    //total_wallet commission report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$runner->id;
                    $report->amount=$comDown;
                    $report->credit=$comDown;
                    $report->debit=0;
                    $report->total=$admin->wallet+$admin->cash+$admin->comAmount-$comUp;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$runner->score;
                    $report->remark='Commission';
                    $report->type='total_wallet';
                    $report->t_type='runners';
                    $report->date=Carbon::now();
                    $report->save();
                }

                if ($comUp!=0)
                {
                    //commission report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$runner->id;
                    $report->amount=$comUp;
                    $report->credit=0;
                    $report->debit=-$comUp;
                    $report->total=$admin->comAmount;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$runner->score.' Parent';
                    $report->remark='Commission';
                    $report->type='Commission';
                    $report->t_type='runners';
                    $report->date=Carbon::now();
                    $report->save();
                    //wallet commission report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$runner->id;
                    $report->amount=$comUp;
                    $report->credit=0;
                    $report->debit=-$comUp;
                    $report->total=$admin->wallet+$admin->cash+$admin->comAmount;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$runner->score.' Parent';
                    $report->remark='Commission';
                    $report->type='total_wallet';
                    $report->t_type='runners';
                    $report->date=Carbon::now();
                    $report->save();
                }

                //
                if ($bDown+$comDown!=0)
                {
                    //profit report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$runner->id;
                    $report->amount=$bDown/*+$comDown*/;
                    $report->credit=0;
                    $report->debit=-$bDown/*+$comDown*/;
                    $report->total=$admin->pAndL-($bUp/*+$comUp*/);
                    $report->narration=$sport->name.'-'.$event->name.'-'.$runner->score;
                    $report->remark='P|L';
                    $report->type='P|L';
                    $report->t_type='runners';
                    $report->date=Carbon::now();
                    $report->save();
                    //wallet profit report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$runner->id;
                    $report->amount=$bDown/*+$comDown*/;
                    $report->credit=0;
                    $report->debit=-$bDown/*+$comDown*/;
                    $report->total=$admin->wallet+$admin->cash+$admin->pAndL+$admin->comAmount-($bUp/*+$comUp*/);
                    $report->narration=$sport->name.'-'.$event->name.'-'.$runner->score;
                    $report->remark='P|L';
                    $report->type='total_wallet';
                    $report->t_type='runners';
                    $report->date=Carbon::now();
                    $report->save();
                }
                if ($bUp+$comUp!=0){
                    //profit report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$runner->id;
                    $report->amount=$bUp/*+$comUp*/;
                    $report->credit=$bUp/*+$comUp*/;
                    $report->debit=0;
                    $report->total=$admin->pAndL/*+$admin->comAmount*/;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$runner->score.' Parent';
                    $report->remark='P|L';
                    $report->type='P|L';
                    $report->t_type='runners';
                    $report->date=Carbon::now();
                    $report->save();
                    //total_wallet profit report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$runner->id;
                    $report->amount=$bUp/*+$comUp*/;
                    $report->credit=$bUp/*+$comUp*/;
                    $report->debit=0;
                    $report->total=$admin->wallet+$admin->cash+$admin->pAndL+$admin->comAmount/*+$admin->comAmount*/;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$runner->score.' Parent';
                    $report->remark='P|L';
                    $report->type='total_wallet';
                    $report->t_type='runners';
                    $report->date=Carbon::now();
                    $report->save();
                }
            }
        }
        $fireBase = new FirebaseController();
        $event=DB::table('events')->where('id',$market->event_id)->first();
        $msg='super admin done declare result of '.$event->name.' fancy market:'.$runner->runnerName.' Score:'.$runner->score.' Status'.$runner->runnerStatus;
        //$fireBase->SendNotification('Declare', ['link' => '', 'message' => $msg, 'userIds' => $user_ids,'market'=>$market]);
        return ['link' => '', 'message' => $msg, 'userIds' => $user_ids,'market'=>$market];
    }
    public function sessionUnDeclare($runner_id){
        $runner = DB::table('runners')->where([['id', $runner_id],/*['marketStatus','CLOSED']*/])->first();
        $market=DB::table('markets')->where([['id', $runner->market_id],/*['marketStatus','CLOSED']*/])->first();
        //if ($runner->is_active==0) return $this->response(0, 'Invalid Action '.$runner->id, '');

        DB::table('betslip')->join('runners', 'runners.id', 'betslip.runner_id')->where([['runners.id', $runner_id]])->update(['betslip.state' => 1]);
        ///////////////

        $user_ids = DB::table('betslip')->join('runners', 'runners.id', 'betslip.runner_id')->where([['runners.id', $runner_id]])->pluck('user_id')->unique();
        //return $user_ids;
        if (empty($user_ids)) return;
        foreach ($user_ids as $user_id) {
            $liability = $this->getLiabilityOfSession($runner_id, $user_id);
            $user = User::find($user_id);
            if ($runner->runnerStatus == 'CANCELED') {////refund Bet
                $user->wallet += $liability;
                $user->exposure += $liability;
                if ($user->exposure>0)$user->exposure=0;
                $user->save();
                DB::table('betslip')->where([['user_id', $user_id], ['runner_id', $runner->id]])->update(['state' => 1, 'profit' => 'none']);
            } elseif ($runner->runnerStatus == 'CLOSED') {////DONE Bet
                $user->wallet += $liability;
                $user->exposure += $liability;
                if ($user->exposure>0)$user->exposure=0;
                //getProfitOfRunner
                $profit = $this->getProfitOfScore($runner_id,$user_id,$runner->score);

                if ($profit > 0) {
                    $com = $this->getSessionCom($market->id, $user_id);
                    $comUpAmount=$profit*$com;
                    $r_profit=$profit;

                    //$user->wallet += ($profit * (1 - $com));
                    $user->pAndL-=$r_profit;
                    $user->comAmount+=$comUpAmount;
                    $user->comUp+=$comUpAmount;
                    $user->comUp1+=$comUpAmount;
                    $user->bUp-=$r_profit;
                    $user->bUp1-=$r_profit;
                    $bUpAmount=$r_profit;
                    $admin_ids = $this->getUpLineAdminIds($user_id);
                    foreach ($admin_ids as $admin_id) {
                        $admin = Admin::find($admin_id);
                        $amount = $r_profit * $this->getPartnerShip($admin->id, $user_id);
                        $adminComAmount = $this->getPartnerShip($admin->id, $user_id) * $r_profit*$com;
                        $admin->pAndL += $amount;
                        $admin->comAmount -= $adminComAmount;
                        $admin->bUp -= $bUpAmount-$amount;
                        $admin->bUp1 -= $bUpAmount-$amount;
                        $admin->comUp += $comUpAmount-$adminComAmount;
                        $admin->comUp1 += $comUpAmount-$adminComAmount;
                        $admin->bDown += $bUpAmount;
                        $admin->bDown1 += $bUpAmount;
                        $admin->comDown -= $comUpAmount;
                        $admin->comDown1 -= $comUpAmount;
                        $admin->save();
                        $bUpAmount=$bUpAmount-$amount;
                        $comUpAmount=$comUpAmount-$adminComAmount;
                    }
                } else {
                    //$user->wallet += ($profit);
                    $r_profit=$profit;
                    $user->pAndL-=$r_profit;
                    $user->bUp-=$r_profit;
                    $user->bUp1-=$r_profit;
                    $bUpAmount=$r_profit;
                    $admin_ids = $this->getUpLineAdminIds($user_id);
                    foreach ($admin_ids as $admin_id) {
                        $admin = Admin::find($admin_id);
                        $amount = $profit * $this->getPartnerShip($admin->id, $user_id);
                        $admin->pAndL += $amount;
                        $admin->bUp -= $bUpAmount-$amount;
                        $admin->bUp1 -= $bUpAmount-$amount;
                        $admin->bDown += $bUpAmount;
                        $admin->bDown1 += $bUpAmount;

                        //$admin->wallet += $amount;
                        $admin->save();
                        $bUpAmount=$bUpAmount-$amount;
                    }
                }
                $user->save();
            }

        }
        /////
        DB::table('settlement')->where('runner_id',$runner_id)->delete();
        DB::table('markets')->where('id', $market->id)->update(['market_result' => 'none', 'marketStatus' => 'OPEN', 'winnerName' => 'none','isUpdate'=>1]);
        DB::table('runners')->where([['id', $runner_id]])->update(['status' => 'none','runnerStatus'=>'','state'=>0]);
        DB::table('betslip')->join('runners', 'runners.id', 'betslip.runner_id')->where([['runners.market_id', $market->id]])->update(['betslip.profit' => 'none']);
        $fireBase = new FirebaseController();
        $event=DB::table('events')->where('id',$market->event_id)->first();
        $msg='super admin did undeclared result of '.$event->name.' fancy:'.$runner->runnerName.' Winner:'.$market->winnerName;
        //$fireBase->SendNotification('Declare', ['link' => '', 'message' => $msg, 'userIds' => $user_ids,'market'=>$market]);
        Report::where('t_type','runners')->where('t_id',$runner_id)->delete();
        return ['link' => '', 'message' => $msg, 'userIds' => $user_ids,'market'=>$market];
    }
    public function unDeclare()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $admin = Admin::find(\request('user_id'));
        if ($admin->is_supper != 0) {
            return $this->response(0, 'You can not set this option because of your permission.', '');
        }
        $market = DB::table('markets')->where([['id', \request('market_id')],/*['marketStatus','CLOSED']*/])->first();
        if (!isset($market)) return;
        if ($market->is_active==0) return $this->response(0, 'Invalid Action '.$market->id, '');

        $event_id=DB::table('markets')->where('id',\request('market_id'))->value('event_id');
        $market_id = \request('market_id');
        //$market_id = \request('market_id');
        DB::table('betslip')->join('runners', 'runners.id', 'betslip.runner_id')->where([['runners.market_id', $market_id]])->update(['betslip.state' => 1]);
        ///////////////

        $runners = DB::table('runners')->where('market_id', $market_id)->get();
        $user_ids = DB::table('betslip')->join('runners', 'runners.id', 'betslip.runner_id')->where([['runners.market_id', $market_id]])->pluck('user_id')->unique();
        //return $user_ids;
        if (empty($user_ids)) return;
        foreach ($user_ids as $user_id) {
            $liability = $this->getLiabilityOfMarket($market->id, $user_id);
            $user = User::find($user_id);
            if ($market->marketStatus == 'CANCELED') {////refund Bet
                $user->wallet += $liability;
                $user->exposure += $liability;
                if ($user->exposure>0)$user->exposure=0;
                $user->save();
                foreach ($runners as $runner) {
                    DB::table('betslip')->where([['user_id', $user_id], ['runner_id', $runner->id]])->update(['state' => 1, 'profit' => 'none']);
                }
            } elseif ($market->marketStatus == 'CLOSED') {////DONE Bet
                $user->wallet += $liability;
                $user->exposure += $liability;
                if ($user->exposure>0)$user->exposure=0;
                //getProfitOfRunner
                $profit = 0;
                foreach ($runners as $runner) {
                    if ($runner->status == 'WINNER') {
                        $profit = $this->getProfitOfRunner($runner->id, $user_id);
                    }
                }
                if ($profit > 0) {
                    $com = $this->getMarketCom($market->id, $user_id);
                    $comUpAmount=$profit*$com;
                    $r_profit=$profit;
                    DB::table('wallet_history')->insert(['change_amount' => $r_profit, 'user_id' => $user->id, 'before_amount' => $user->wallet, 'after_amount' => $user->wallet + $r_profit, 'datetime' => Carbon::now(), 't_id' => $market_id, 'user_type' => 'users', 'type' => 'profitAndLoss'
                    ]);
                    //$user->wallet += ($profit * (1 - $com));
                    $user->pAndL-=$r_profit;
                    $user->comAmount+=$comUpAmount;
                    $user->comUp+=$comUpAmount;
                    $user->comUp1+=$comUpAmount;
                    $user->bUp-=$r_profit;
                    $user->bUp1-=$r_profit;
                    $bUpAmount=$r_profit;
                    $admin_ids = $this->getUpLineAdminIds($user_id);
                    foreach ($admin_ids as $admin_id) {
                        $admin = Admin::find($admin_id);
                        $amount = $r_profit * $this->getPartnerShip($admin->id, $user_id);
                        $adminComAmount = $this->getPartnerShip($admin->id, $user_id) * $r_profit*$com;
                        $admin->pAndL += $amount;
                        $admin->comAmount -= $adminComAmount;
                        $admin->bUp -= $bUpAmount-$amount;
                        $admin->bUp1 -= $bUpAmount-$amount;
                        $admin->comUp += $comUpAmount-$adminComAmount;
                        $admin->comUp1 += $comUpAmount-$adminComAmount;
                        $admin->bDown += $bUpAmount;
                        $admin->bDown1 += $bUpAmount;
                        $admin->comDown -= $comUpAmount;
                        $admin->comDown1 -= $comUpAmount;
                        $admin->save();
                        $bUpAmount=$bUpAmount-$amount;
                        $comUpAmount=$comUpAmount-$adminComAmount;
                    }
                } else {
                    //$user->wallet += ($profit);
                    $r_profit=$profit;
                    $user->pAndL-=$r_profit;
                    $user->bUp-=$r_profit;
                    $user->bUp1-=$r_profit;
                    $bUpAmount=$r_profit;
                    $admin_ids = $this->getUpLineAdminIds($user_id);
                    foreach ($admin_ids as $admin_id) {
                        $admin = Admin::find($admin_id);
                        $amount = $profit * $this->getPartnerShip($admin->id, $user_id);
                        $admin->pAndL += $amount;
                        $admin->bUp -= $bUpAmount-$amount;
                        $admin->bUp1 -= $bUpAmount-$amount;
                        $admin->bDown += $bUpAmount;
                        $admin->bDown1 += $bUpAmount;

                        //$admin->wallet += $amount;
                        $admin->save();
                        $bUpAmount=$bUpAmount-$amount;
                    }
                }
                $user->save();
            }

        }
        /////
        DB::table('settlement')->where('market_id',$market_id)->delete();
        DB::table('markets')->where('id', $market_id)->update(['market_result' => 'none', 'marketStatus' => 'OPEN', 'winnerName' => 'none','isUpdate'=>1]);
        DB::table('runners')->where([['market_id', $market_id]])->update(['status' => 'none']);
        DB::table('betslip')->join('runners', 'runners.id', 'betslip.runner_id')->where([['runners.market_id', $market_id]])->update(['betslip.profit' => 'none']);
        $market = DB::table('markets')->where([['id', \request('market_id')],/*['marketStatus','CLOSED']*/])->first();
        $fireBase = new FirebaseController();
        $event=DB::table('events')->where('id',$market->event_id)->first();
        $msg='super admin did undeclared result of '.$event->name.' market:'.$market->marketName.' Winner:'.$market->winnerName;
        $fireBase->SendNotification('Declare', ['link' => '', 'message' => $msg, 'userIds' => $user_ids,'market'=>$market]);
        Report::where('t_type','markets')->where('t_id',$market_id)->delete();
        return $this->response(0, 'Updated successfully/', $market);
    }

    public function betResult($market_id)
    {
        $market = DB::table('markets')->where([['id', $market_id],/*['marketStatus','DONE']*/])->first();
        if (!isset($market)) return;
        $runners = DB::table('runners')->where('market_id', $market_id)->get();
        $event=DB::table('events')->where('id',$market->event_id)->first();
        $sport=DB::table('sport_names')->where('id',$event->sport_id)->first();
        $user_ids = DB::table('betslip')->join('runners', 'runners.id', 'betslip.runner_id')->where([['runners.market_id', $market_id], ['is_active', 'true']])->pluck('user_id')->unique();
        //return $user_ids;
        $n_adminIds=[];
        if (empty($user_ids)) return;
        foreach ($user_ids as $user_id) {
            $liability = $this->getLiabilityOfMarket($market->id, $user_id);
            $user = User::find($user_id);
            if ($market->marketStatus == 'CANCELED') {////refund Bet
                $user->wallet -= $liability;
                $user->exposure -= $liability;
                if ($user->exposure>0)$user->exposure=0;
                $user->save();
                foreach ($runners as $runner) {
                    DB::table('betslip')->where([['user_id', $user_id], ['runner_id', $runner->id]])->update(['state' => 2, 'profit' => 'refunded']);
                }
            } elseif ($market->marketStatus == 'CLOSED') {////DONE Bet
                $user->wallet -= $liability;
                $user->exposure -= $liability;
                if ($user->exposure>0)$user->exposure=0;
                //getProfitOfRunner
                $profit = 0;
                foreach ($runners as $runner) {
                    if ($runner->status == 'WINNER') {
                        $profit = $this->getProfitOfRunner($runner->id, $user_id);
                    }
                }
                if ($profit > 0) {
                    $com = $this->getMarketCom($market->id, $user_id);
                    $comUpAmount=$profit*$com;
                    $r_profit=$profit;
                    $user->pAndL+=$r_profit;
                    $user->comAmount-=$comUpAmount;
                    $user->comUp-=$comUpAmount;
                    $user->comUp1-=$comUpAmount;
                    $user->bUp+=$r_profit;
                    $user->bUp1+=$r_profit;
                    $bUpAmount=$r_profit;
                    //settlement
                    $child_id=DB::table('settlement')->insertGetId([
                        'admin_id'=>$user_id,
                        'user_type'=>'users',
                        'child_id'=>0,
                        'market_id'=>$market_id,
                        'pAndL'=>$r_profit,
                        'bUp'=>$r_profit,
                        'bDown'=>0,
                        'comAmount'=>-$comUpAmount,
                        'comUp'=>-$comUpAmount,
                        'comDown'=>0,
                        'date'=>Carbon::now(),
                    ]);

                    //profit and loss report
                    $userReport=new Report();
                    $userReport->user_id=$user->id;
                    $userReport->user_type='users';
                    $userReport->t_id=$market->id;
                    $userReport->amount=$r_profit/*-$comUpAmount*/;
                    $userReport->credit=$r_profit/*-$comUpAmount*/;
                    $userReport->debit=0;
                    $userReport->total=$user->pAndL;
                    $userReport->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName;
                    $userReport->remark='P|L';
                    $userReport->type='P|L';
                    $userReport->t_type='markets';
                    $userReport->date=Carbon::now();
                    $userReport->save();
                    //commission
                    $userReport=new Report();
                    $userReport->user_id=$user->id;
                    $userReport->user_type='users';
                    $userReport->t_id=$market->id;
                    $userReport->amount=-$comUpAmount;
                    $userReport->credit=0;
                    $userReport->debit=$comUpAmount;
                    $userReport->total=$user->comAmount;
                    $userReport->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName;
                    $userReport->remark='Commission';
                    $userReport->type='Commission';
                    $userReport->t_type='markets';
                    $userReport->date=Carbon::now();
                    $userReport->save();
                    /////total wallet report
                    //total_wallet profit and loss report
                    $userReport=new Report();
                    $userReport->user_id=$user->id;
                    $userReport->user_type='users';
                    $userReport->t_id=$market->id;
                    $userReport->amount=$r_profit/*-$comUpAmount*/;
                    $userReport->credit=$r_profit/*-$comUpAmount*/;
                    $userReport->debit=0;
                    $userReport->total=$user->wallet-$user->exposure+$user->cash+$user->pAndL/*+$user->comAmount*/;
                    $userReport->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName;
                    $userReport->remark='P|L';
                    $userReport->type='total_wallet';
                    $userReport->t_type='markets';
                    $userReport->date=Carbon::now();
                    $userReport->save();
                    //total_wallet commission
                    $userReport=new Report();
                    $userReport->user_id=$user->id;
                    $userReport->user_type='users';
                    $userReport->t_id=$market->id;
                    $userReport->amount=-$comUpAmount;
                    $userReport->credit=0;
                    $userReport->debit=$comUpAmount;
                    $userReport->total=$user->wallet-$user->exposure+$user->cash+$user->pAndL+$user->comAmount;
                    $userReport->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName;
                    $userReport->remark='Commission';
                    $userReport->type='total_wallet';
                    $userReport->t_type='markets';
                    $userReport->date=Carbon::now();
                    $userReport->save();
                    /////////////////////////////////////////
                    $admin_ids = $this->getUpLineAdminIds($user_id);
                    foreach ($admin_ids as $admin_id) {
                        $admin = Admin::find($admin_id);
                        $amount = $r_profit * $this->getPartnerShip($admin->id, $user_id);
                        $adminComAmount = $this->getPartnerShip($admin->id, $user_id) * $r_profit*$com;
                        DB::table('wallet_history')->insert(['change_amount' => -$amount, 'user_id' => $admin->id, 'before_amount' => $admin->wallet, 'after_amount' => $admin->wallet - $amount, 'datetime' => Carbon::now(), 't_id' => $market_id, 'user_type' => 'admins', 'type' => 'profitAndLoss']);
                        $admin->pAndL -= $amount;
                        $admin->comAmount += $adminComAmount;
                        $admin->bUp += $bUpAmount-$amount;
                        $admin->bUp1 += $bUpAmount-$amount;
                        $admin->comUp -= $comUpAmount-$adminComAmount;
                        $admin->comUp1 -= $comUpAmount-$adminComAmount;
                        $admin->bDown -= $bUpAmount;
                        $admin->bDown1 -= $bUpAmount;
                        $admin->comDown += $comUpAmount;
                        $admin->comDown1 += $comUpAmount;
                        $child_id=DB::table('settlement')->insertGetId([
                            'child_id'=>$child_id,
                            'admin_id'=>$admin_id,
                            'user_type'=>'admins',
                            'market_id'=>$market_id,
                            'pAndL'=>-$amount,
                            'bUp'=>$bUpAmount-$amount,
                            'bDown'=>-$bUpAmount,
                            'comAmount'=>$adminComAmount,
                            'comUp'=>-($comUpAmount-$adminComAmount),
                            'comDown'=>$comUpAmount,
                            'date'=>Carbon::now(),
                        ]);
                        $admin->save();
                        $bUpAmount=$bUpAmount-$amount;
                        $comUpAmount=$comUpAmount-$adminComAmount;
                    }
                } else {
                    $r_profit=$profit;
                    $user->pAndL+=$r_profit;
                    $user->bUp+=$r_profit;
                    $user->bUp1+=$r_profit;
                    $bUpAmount=$r_profit;
                    $child_id=DB::table('settlement')->insertGetId([
                        'admin_id'=>$user_id,
                        'user_type'=>'users',
                        'child_id'=>0,
                        'market_id'=>$market_id,
                        'pAndL'=>$r_profit,
                        'bUp'=>$r_profit,
                        'bDown'=>0,
                        'date'=>Carbon::now(),
                    ]);

                    //profit and loss report
                    $userReport=new Report();
                    $userReport->user_id=$user->id;
                    $userReport->user_type='users';
                    $userReport->t_id=$market->id;
                    $userReport->amount=$r_profit;
                    $userReport->credit=0;
                    $userReport->debit=-$r_profit;
                    $userReport->total=$user->pAndL;
                    $userReport->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName;
                    $userReport->remark='P|L';
                    $userReport->type='P|L';
                    $userReport->t_type='markets';
                    $userReport->date=Carbon::now();
                    $userReport->save();
                    //total wallet
                    //total_wallet profit and loss report
                    $userReport=new Report();
                    $userReport->user_id=$user->id;
                    $userReport->user_type='users';
                    $userReport->t_id=$market->id;
                    $userReport->amount=$r_profit;
                    $userReport->credit=0;
                    $userReport->debit=-$r_profit;
                    $userReport->total=$user->wallet-$user->exposure+$user->cash+$user->pAndL+$user->comAmount;
                    $userReport->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName;
                    $userReport->remark='P|L';
                    $userReport->type='total_wallet';
                    $userReport->t_type='markets';
                    $userReport->date=Carbon::now();
                    $userReport->save();
                    $admin_ids = $this->getUpLineAdminIds($user_id);
                    foreach ($admin_ids as $admin_id) {
                        $admin = Admin::find($admin_id);
                        $amount = $profit * $this->getPartnerShip($admin->id, $user_id);
                        $admin->pAndL -= $amount;
                        $admin->bUp += $bUpAmount-$amount;
                        $admin->bUp1 += $bUpAmount-$amount;
                        $admin->bDown -= $bUpAmount;
                        $admin->bDown1 -= $bUpAmount;

                        //$admin->wallet += $amount;
                        $admin->save();
                        $child_id=DB::table('settlement')->insertGetId([
                            'admin_id'=>$admin_id,
                            'user_type'=>'admins',
                            'child_id'=>$child_id,
                            'market_id'=>$market_id,
                            'pAndL'=>-$amount,
                            'bUp'=>$bUpAmount-$amount,
                            'bDown'=>-$bUpAmount,
                            'date'=>Carbon::now(),
                        ]);
                        $bUpAmount=$bUpAmount-$amount;
                        //return $admin->wallet;
                    }
                }
                foreach ($runners as $runner) {
                    if ($runner->status == 'WINNER') {
                        DB::table('betslip')->where([['user_id', $user_id], ['runner_id', $runner->id],['is_matched','true'],['bet_type','availableToBack']])->update(['state' => 2, 'profit' => 'profit']);
                        DB::table('betslip')->where([['user_id', $user_id], ['runner_id', $runner->id],['is_matched','true'],['bet_type','availableToLay']])->update(['state' => 2, 'profit' => 'loss']);
                    } elseif ($runner->status == 'LOSER') {
                        DB::table('betslip')->where([['user_id', $user_id], ['runner_id', $runner->id],['is_matched','true'],['bet_type','availableToBack']])->update(['state' => 2, 'profit' => 'loss']);
                        DB::table('betslip')->where([['user_id', $user_id], ['runner_id', $runner->id],['is_matched','true'],['bet_type','availableToLay']])->update(['state' => 2, 'profit' => 'profit']);
                    }
                    DB::table('betslip')->where([['user_id', $user_id], ['runner_id', $runner->id],['is_matched','false']])->update(['state' => 2, 'profit' => 'canceled']);
                }
                $user->save();
            }

        }
        $admins=DB::table('admins')->get();
        foreach ($admins as $admin){
            $profit=DB::table('settlement')->where([['admin_id',$admin->id],['user_type','admins'],['market_id',$market->id]])->sum('pAndL');
            $comAmount=DB::table('settlement')->where([['admin_id',$admin->id],['user_type','admins'],['market_id',$market->id]])->sum('comAmount');
            $comUp=DB::table('settlement')->where([['admin_id',$admin->id],['user_type','admins'],['market_id',$market->id]])->sum('comUp');
            $comDown=DB::table('settlement')->where([['admin_id',$admin->id],['user_type','admins'],['market_id',$market->id]])->sum('comDown');
            $bUp=DB::table('settlement')->where([['admin_id',$admin->id],['user_type','admins'],['market_id',$market->id]])->sum('bUp');
            $bDown=DB::table('settlement')->where([['admin_id',$admin->id],['user_type','admins'],['market_id',$market->id]])->sum('bDown');
            if ($profit==0)continue;
            if ($profit>0){
                if ($bDown!=0){
                    //profit
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$market->id;
                    $report->amount=$bDown;
                    $report->credit=$bDown;
                    $report->debit=0;
                    $report->total=$admin->pAndL;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName;
                    $report->remark='P|L';
                    $report->type='P|L';
                    $report->t_type='markets';
                    $report->date=Carbon::now();
                    $report->save();
                    //total wallet of profit
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$market->id;
                    $report->amount=$bDown;
                    $report->credit=$bDown;
                    $report->debit=0;
                    $report->total=$admin->wallet+$admin->cash+$admin->pAndL+$admin->comAmount-$bUp;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName;
                    $report->remark='P|L';
                    $report->type='total_wallet';
                    $report->t_type='markets';
                    $report->date=Carbon::now();
                    $report->save();
                }
                if ($bUp!=0){
                    //profit report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$market->id;
                    $report->amount=$bUp;
                    $report->credit=0;
                    $report->debit=-$bUp;
                    $report->total=$admin->pAndL;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName.' Parent';
                    $report->remark='P|L';
                    $report->type='P|L';
                    $report->t_type='markets';
                    $report->date=Carbon::now();
                    $report->save();
                    //total_wallet profit report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$market->id;
                    $report->amount=$bUp;
                    $report->credit=0;
                    $report->debit=-$bUp;
                    $report->total=$admin->wallet+$admin->cash+$admin->pAndL+$admin->comAmount;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName.' Parent';
                    $report->remark='P|L';
                    $report->type='total_wallet';
                    $report->t_type='markets';
                    $report->date=Carbon::now();
                    $report->save();
                }
            }else{
                //commission
                if ($comDown!=0){
                    //commission report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$market->id;
                    $report->amount=$comDown;
                    $report->credit=$comDown;
                    $report->debit=0;
                    $report->total=$admin->comAmount-$comUp;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName;
                    $report->remark='Commission';
                    $report->type='Commission';
                    $report->t_type='markets';
                    $report->date=Carbon::now();
                    $report->save();
                    //total_wallet commission report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$market->id;
                    $report->amount=$comDown;
                    $report->credit=$comDown;
                    $report->debit=0;
                    $report->total=$admin->wallet+$admin->cash+$admin->comAmount-$comUp;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName;
                    $report->remark='Commission';
                    $report->type='total_wallet';
                    $report->t_type='markets';
                    $report->date=Carbon::now();
                    $report->save();
                }

                if ($comUp!=0){
                    //commission report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$market->id;
                    $report->amount=$comUp;
                    $report->credit=0;
                    $report->debit=-$comUp;
                    $report->total=$admin->comAmount;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName.' Parent';
                    $report->remark='Commission';
                    $report->type='Commission';
                    $report->t_type='markets';
                    $report->date=Carbon::now();
                    $report->save();
                    //wallet commission report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$market->id;
                    $report->amount=$comUp;
                    $report->credit=0;
                    $report->debit=-$comUp;
                    $report->total=$admin->wallet+$admin->cash+$admin->comAmount;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName.' Parent';
                    $report->remark='Commission';
                    $report->type='total_wallet';
                    $report->t_type='markets';
                    $report->date=Carbon::now();
                    $report->save();
                }

                //
                if ($bDown+$comDown!=0){
                    //profit report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$market->id;
                    $report->amount=$bDown/*+$comDown*/;
                    $report->credit=0;
                    $report->debit=-$bDown/*+$comDown*/;
                    $report->total=$admin->pAndL-($bUp/*+$comUp*/);
                    $report->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName;
                    $report->remark='P|L';
                    $report->type='P|L';
                    $report->t_type='markets';
                    $report->date=Carbon::now();
                    $report->save();
                    //wallet profit report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$market->id;
                    $report->amount=$bDown/*+$comDown*/;
                    $report->credit=0;
                    $report->debit=-$bDown/*+$comDown*/;
                    $report->total=$admin->wallet+$admin->cash+$admin->pAndL+$admin->comAmount-($bUp/*+$comUp*/);
                    $report->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName;
                    $report->remark='P|L';
                    $report->type='total_wallet';
                    $report->t_type='markets';
                    $report->date=Carbon::now();
                    $report->save();
                }
                if ($bUp+$comUp!=0){
                    //profit report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$market->id;
                    $report->amount=$bUp/*+$comUp*/;
                    $report->credit=$bUp/*+$comUp*/;
                    $report->debit=0;
                    $report->total=$admin->pAndL/*+$admin->comAmount*/;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName.' Parent';
                    $report->remark='P|L';
                    $report->type='P|L';
                    $report->t_type='markets';
                    $report->date=Carbon::now();
                    $report->save();
                    //total_wallet profit report
                    $report=new Report();
                    $report->user_id=$admin->id;
                    $report->user_type='admins';
                    $report->t_id=$market->id;
                    $report->amount=$bUp/*+$comUp*/;
                    $report->credit=$bUp/*+$comUp*/;
                    $report->debit=0;
                    $report->total=$admin->wallet+$admin->cash+$admin->pAndL+$admin->comAmount/*+$admin->comAmount*/;
                    $report->narration=$sport->name.'-'.$event->name.'-'.$market->winnerName.' Parent';
                    $report->remark='P|L';
                    $report->type='total_wallet';
                    $report->t_type='markets';
                    $report->date=Carbon::now();
                    $report->save();
                }
            }
        }
        //$fireBase = new FirebaseController();
        //$event=DB::table('events')->where('id',$market->event_id)->first();
        //$msg='super admin did declare result of '.$event->name.' market:'.$market->marketName.' Winner:'.$market->winnerName;
        //$fireBase->SendNotification('Declare', ['link' => '', 'message' => $msg, 'userIds' => $user_ids,'market'=>$market]);
    }
    public function getReport(){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $filter=[];
        $filter[]=['user_id',\request('user_id')];
        $filter[]=['user_type',\request('user_type')];
        if (!empty(\request('reportType'))){
            $filter[]=['reports.type',\request('reportType')];
        }
        if (!empty(\request('start_date'))) {
            $filter[] = ['reports.date', '>=', \request('start_date')];
        }
        if (!empty(\request('end_date'))) {
            $filter[] = ['reports.date', '<=', \request('end_date')];
        }
        $res=Report::where($filter)->orderBy('reports.id','DESC')->get();
        return $this->response(0,'Get Report',$res);
    }
    public function getUpLinePartnerShipOfAdmin($admin_id,$user_type)
    {
        //$admin=\request('userType')=='admins'?Admin::find(\request('child_id')):User::find(\request('child_id'));
        $admin = DB::table($user_type)->where([['id', $admin_id]])->first();
        $parentId = $admin->parent_id;
        $partnerShip=$admin->partnerShip;
        while (true) {
            if ($parentId == 0) break;
            $rootAdmin = DB::table('admins')->where('id', $parentId)->first();
            $partnerShip+= $rootAdmin->partnerShip;
            $parentId = $rootAdmin->parent_id;
        }
        return $partnerShip/100;
    }
    public function setSettlement(){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $child_user=\request('userType')=='admins'?Admin::find(\request('child_id')):User::find(\request('child_id'));
        $parent_user=Admin::find($child_user->parent_id);
        $amount=\request('amount');


        if ($child_user->bUp+$child_user->comUp<0){
            if (abs($child_user->bUp+$child_user->comUp)<abs($amount) || $amount<0){
                return $this->response(1,'Invalid Amount0 '.$amount,'');
            }
        }
        if ($child_user->bUp+$child_user->comUp>0){
            if (abs($child_user->bUp+$child_user->comUp)<abs($amount) || $amount>0){
                return $this->response(1,'Invalid Amount1','');
            }
        }
        if ($parent_user->is_super!=0){
            if($child_user->bUp+$child_user->comUp<0 && $parent_user->bUp+$parent_user->comUp<0){
                $user_ids=array();
                if (\request('userType')=='users'){
                    $user_ids[]=$child_user->id;
                }else{
                    $user_ids=$this->getUsersOfAdmin($child_user->id);
                }

                $p_bUp1=0;
                $c_bUp1=0;
                foreach ($user_ids as $user_id){
                    $user=User::find($user_id);
                    $p_bUp1+=($user->bUp+$user->comUp)*$this->getUpLinePartnerShipOfAdmin($parent_user->id,'admins');
                    $c_bUp1+=($user->bUp+$user->comUp)*$this->getUpLinePartnerShipOfAdmin($child_user->id,\request('userType'));
                }
                $user_ids=$this->getUsersOfAdmin($parent_user->id);
                $p_bUp2=0;
                foreach ($user_ids as $user_id){
                    $user=User::find($user_id);
                    $p_bUp2+=($user->bUp+$user->comUp)*$this->getUpLinePartnerShipOfAdmin($parent_user->id,'admins');
                }
                if ($p_bUp1!=0){
                    //return $this->response(1,'Invalid Amount2 :'. ($p_bUp2),'');
                    $available_amount=($p_bUp2-$parent_user->bUp)/$p_bUp1*$c_bUp1-($c_bUp1-$child_user->bUp);
                    //return $this->response(1,'Invalid Amount0 :'. ($available_amount+$amount),'');
                    if ($available_amount+$amount>0){
                        return $this->response(1,'Invalid Amount0 :'. (-$available_amount),'');
                    }
                }

            }
        }

        //return $this->response(1,'You can not settle any amount now. because available amount is ','');

        /*if ($parent_user->is_super!=0){
            $limit_amount=($parent_user->credit_limit*$parent_user->partnerShip/100+$parent_user->bUp+$parent_user->comUp)/$parent_user->partnerShip*100;
            if ($amount>0){
                if ($limit_amount-$amount<0){
                    return $this->response(1,'Invalid Amount2, you can settle of '.$limit_amount,'');
                }
            }
        }*/

        //return $this->response(1,$amount.'Invalid Amount, you can settle of '.$limit_amount,'');
        /*if (abs($parent_user->bDown)<abs($amount)){
            return $this->response(1,'Invalid Amount','');
        }*/
        $child_user->cash+=$amount;
        $child_user->bUp+=$amount;

        $parent_user->cash-=$amount;
        $parent_user->bDown-=$amount;

        if ($child_user->bUp+$child_user->comUp==0){
            $child_user->bUp=0;
            $child_user->comUp=0;
        }
        if ($child_user->bDown+$child_user->comDown==0){
            $child_user->bDown=0;
            $child_user->comDown=0;
        }
        if ($parent_user->bUp+$parent_user->comUp==0){
            $parent_user->bUp=0;
            $parent_user->comUp=0;
        }
        if ($parent_user->bDown+$parent_user->comDown==0){
            $parent_user->bDown=0;
            $parent_user->comDown=0;
        }

        $child_user->save();
        $parent_user->save();

        $report=new Report();
        $report->user_id=$child_user->id;
        $report->user_type=\request('userType');
        $report->t_id=$parent_user->id;
        $report->amount=$amount;
        $report->credit=$amount>0?$amount:0;
        $report->debit=$amount<0?$amount:0;
        $report->total=$child_user->cash;
        $report->narration=$amount>0?"Cash paid to ".$parent_user->email:"Cash received from ".$parent_user->email;
        $report->remark='Settlement';
        $report->type='Settlement';
        $report->date=Carbon::now();
        $report->save();
        //total_wallet
        $report=new Report();
        $report->user_id=$child_user->id;
        $report->user_type=\request('userType');
        $report->t_id=$parent_user->id;
        $report->amount=$amount;
        $report->credit=$amount>0?$amount:0;
        $report->debit=$amount<0?$amount:0;
        $report->total=$child_user->wallet+$child_user->cash+$child_user->pAndL+$child_user->comAmount;
        $report->narration=$amount>0?"Cash paid to ".$parent_user->email:"Cash received from ".$parent_user->email;
        $report->remark='Settlement';
        $report->type='total_wallet';
        $report->date=Carbon::now();
        $report->save();
//////////////////////////$parent_user/////////////////
        $report=new Report();
        $report->user_id=$parent_user->id;
        $report->user_type='admins';
        $report->t_id=$child_user->id;
        $report->amount=-$amount;
        $report->credit=$amount<0?-$amount:0;
        $report->debit=$amount>0?-$amount:0;
        $report->total=$parent_user->cash;
        $report->narration=$amount<0?"Cash paid to ".$child_user->email:"Cash received from ".$child_user->email;
        $report->remark='Settlement';
        $report->type='Settlement';
        $report->date=Carbon::now();
        $report->save();
        //total_wallet
        $report=new Report();
        $report->user_id=$parent_user->id;
        $report->user_type='admins';
        $report->t_id=$child_user->id;
        $report->amount=-$amount;
        $report->credit=$amount<0?-$amount:0;
        $report->debit=$amount>0?-$amount:0;
        $report->total=$parent_user->wallet+$parent_user->cash+$parent_user->pAndL+$parent_user->comAmount;
        $report->narration=$amount<0?"Cash paid to ".$child_user->email:"Cash received from ".$child_user->email;
        $report->remark='Settlement';
        $report->type='total_wallet';
        $report->date=Carbon::now();
        $report->save();

        $msg1 =$parent_user->email.' did settlement for you.';
        $firebase = new FirebaseController();
        $firebase->SendNotification('Settlement/'.\request('userType').'/'.$child_user->id, ['message'=>$msg1,'user'=>$child_user]);
        DB::table('markets')->where('market_result','done')->update(['is_active'=>0,'isUpdate'=>0]);
        return $this->response(0,'Done settlement for '.$amount,'');
    }
    public function getUPAR($user_id){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $user_ids = $this->getUsersOfAdmin($user_id);
        $runners_f = array();
        $userPosition = array();
        $childAdminAccount = Admin::where('parent_id', $user_id)->get();
        $childUserAccount = User::where('parent_id', $user_id)->get();
        $up_item = array();
        foreach ($childAdminAccount as $admin) {
            $account = ['name' => $admin->email, 'id' => $admin->id, 'type' => 'admins'];
            if ($admin->bUp==0)continue;
            $up_item[] = ['account' => $account, 'profits' => $admin,'minus_account'=>$admin->bUp+$admin->comUp];
        }
        foreach ($childUserAccount as $admin) {
            $account = ['name' => $admin->email, 'id' => $admin->id, 'type' => 'users'];
            $profits = $admin;
            if ($admin->bUp==0)continue;
            $up_item[] = ['account' => $account, 'profits' =>$admin,'minus_account'=>$admin->bUp+$admin->comUp];
        }
        $own = Admin::where('id', $user_id)->first();
        if ($own->cash!=0){
            $own = Admin::where('id', $user_id)->first();
            $account = ['name' => 'Cash', 'id' => 0, 'type' => 'users'];
            $up_item[] = ['account' => $account, 'profits' => $own,'minus_account'=>$own->cash];
        }
        if ($own->pAndL!=0 and $own->bDown==0){
            $account = ['name' => "Own(".$own->email.')', 'id' => $user_id, 'type' => 'users'];
            $up_item[] = ['account' => $account, 'profits' => $own,'minus_account'=>$own->pAndL];
        }
        if ($own->pAndL!=0 and $own->bDown!=0){
            $account = ['name' => "Own(".$own->email.')', 'id' => $user_id, 'type' => 'users'];
            $up_item[] = ['account' => $account, 'profits' => $own,'minus_account'=>$own->pAndL];
        }
        $account = ['name' => "Own(Com)", 'id' => $user_id, 'type' => 'users'];
        $up_item[] = ['account' => $account, 'profits' => $own,'minus_account'=>$own->comDown];
        //$admin=Admin::find('')
        $account = ['name' => "Parent", 'id' => $user_id, 'type' => 'users'];
        if ($own->bUp!=0){
            $up_item[] = ['account' => $account, 'profits' => $own,'minus_account'=>-($own->bUp+$own->comUp)];
        }
        $account = ['name' => "Parent Com", 'id' => $user_id, 'type' => 'users'];
        if ($own->comUp!=0){
            $up_item[] = ['account' => $account, 'profits' => $own,'minus_account'=>$own->comUp];
        }
        $profits1=0;
        $profits2=0;
        //return json_encode($up_item);
        foreach ($up_item as $pos_item) {
            if ($pos_item['minus_account']>=0){
                $profits1+=$pos_item['minus_account'];
            }else{
                $profits2+=$pos_item['minus_account'];
            }
        }
        $profits1 = round($profits1, 2);
        $profits2 = round($profits2, 2);
        $account = ['name' => "Total", 'id' => $user_id, 'type' => 'users'];
        if ($profits1!=0){
            $up_item[] = ['account' => $account, 'profits' => 0,'minus_account'=>$profits1];
        }

        if ($profits2!=0){
            $up_item[] = ['account' => $account, 'profits' => 0,'minus_account'=>$profits2];
        }
        $userPosition = $up_item;
        $c_admin=Admin::find($user_id);
        return $this->response(1, 'Get UserPosition', ['userPosition' => $userPosition,'c_admin'=>$c_admin]);
    }
    public function getProfitUPAR(){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $user_id=\request('admin_id');
        $filter=[];
        if (!empty(\request('market_id'))){
            $market_id=\request('market_id');
            $filter[]=['market_id',$market_id];
        }else{
            $runner_id=\request('runner_id');
            $filter[]=['runner_id',$runner_id];
        }


        $childAdminAccount = Admin::where('parent_id', $user_id)->get();
        $childUserAccount = User::where('parent_id', $user_id)->get();
        $up_item = array();
        foreach ($childAdminAccount as $admin) {
            $account = ['name' => $admin->email, 'id' => $admin->id, 'type' => 'admins'];
            $pAndL=DB::table('settlement')->where([['user_type','admins'],['admin_id',$admin->id]])->where($filter)->sum('pAndL');
            if ($pAndL==0)continue;
            $up_item[] = ['account' => $account, 'profits' => $admin,'minus_account'=>$pAndL];
        }
        foreach ($childUserAccount as $admin) {
            $account = ['name' => $admin->email, 'id' => $admin->id, 'type' => 'users'];
            $pAndL=DB::table('settlement')->where([['user_type','users'],['admin_id',$admin->id]])->where($filter)->sum('pAndL');
            if ($pAndL==0)continue;
            $up_item[] = ['account' => $account, 'profits' =>$admin,'minus_account'=>$pAndL];
        }
        $own = Admin::where('id', $user_id)->first();
        $pAndL=DB::table('settlement')->where([['user_type','admins'],['admin_id',$own->id]])->where($filter)->sum('pAndL');
        if ($pAndL!=0){
            $own = Admin::where('id', $user_id)->first();
            $account = ['name' => 'Own', 'id' => 0, 'type' => 'users'];
            $up_item[] = ['account' => $account, 'profits' => $own,'minus_account'=>$pAndL];
        }

        //$admin=Admin::find('')
        $account = ['name' => "Parent", 'id' => $user_id, 'type' => 'users'];
        $pAndL=DB::table('settlement')->where([['user_type','admins'],['admin_id',$own->id]])->where($filter)->sum('bUp');
        if ($pAndL!=0){
            $up_item[] = ['account' => $account, 'profits' => $own,'minus_account'=>-($pAndL)];
        }

        $profits1=0;
        //return json_encode($up_item);
        foreach ($up_item as $pos_item) {
            $profits1+=$pos_item['minus_account'];
        }
        $profits1 = round($profits1, 2);
        $account = ['name' => "Total", 'id' => $user_id, 'type' => 'users'];
        if ($profits1!=0){
            $up_item[] = ['account' => $account, 'profits' => 0,'minus_account'=>$profits1];
        }

        $userPosition = $up_item;
        $c_admin=Admin::find($user_id);
        return $this->response(1, 'Get UserPosition', ['userPosition' => $userPosition,'c_admin'=>$c_admin]);
    }
    public function getSettlementOfAdmin($user_id,$userType){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $res=DB::table($userType)->where([['id',$user_id]])->first();
        return $this->response(1,'get settlement of one admin',$res);
    }
    private function getDevice($user_agent){

        $bname = json_encode($user_agent);
        $platform = json_encode($user_agent);

        //First get the platform?
        if (preg_match('/linux/i', $user_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $user_agent)) {
            $platform = 'windows';
        }

        //echo $platform;

        //echo "<br>";


        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$user_agent) && !preg_match('/Opera/i',$user_agent))
        {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }
        elseif(preg_match('/Firefox/i',$user_agent))
        {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        }
        elseif(preg_match('/Chrome/i',$user_agent))
        {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        }
        elseif(preg_match('/Safari/i',$user_agent))
        {
            $bname = 'Apple Safari';
            $ub = "Safari";
        }
        elseif(preg_match('/Opera/i',$user_agent))
        {
            $bname = 'Opera';
            $ub = "Opera";
        }
        elseif(preg_match('/Netscape/i',$user_agent))
        {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        return $bname.' of '.$platform;
    }
    private function authorization($auth_type,$token,$authentication){
        $account_id=explode('-',$auth_type)[1];
        if (empty(explode('-',$auth_type)[2])){
            exit('We detected that you are might hacker1.');
        }
        $user_type='wrong';
        if (explode('-',$auth_type)[0]=='tf1'){
            $user_type='users';
        }elseif (explode('-',$auth_type)[0]=='tf2'){
            $user_type='admins';
        }
        if ($user_type=='wrong') exit('We detect wrong action from you.2');
        $device=$this->getDevice(\request()->header('User-Agent'));
        $log_dev=DB::table($user_type)->where('id',$account_id)->value('device');
        if ($log_dev=='none'){
            exit('We detect You are Hacker.3');
        }
        if ($device!=$log_dev)exit('We detect You are Hacker.4');

        $session=DB::table($user_type)->where('id',$account_id)->value('login_session');
        if ($session=='0') {exit('We detected that you are might hacker.');}
        $auth_token=md5($auth_type.$session.'tcgtchkmk1014');
        if ($auth_token!=$authentication) exit('We detected that you are might hacker.');
        //DB::table('token_list')->delete('created_at','<',Carbon::now()->subMonth(1));
        $is_token=DB::table('token_list')->where('token',$auth_type.$token.$authentication)->value('token');
        if (isset($is_token)){ exit('We detected that you are might hacker or robot.');}
        DB::table('token_list')->insert(['token'=>$auth_type.$token.$authentication]);
    }
    public function setStake(){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        //return $this->response(1,'Updated your stake successfully1',\request()->header('authtype'));
        //
        $user=User::find(\request('user_id'));
        $user->stake=json_encode(\request('stake')) ;
        $user->save();
        return $this->response(1,'Updated your stake successfully',$user);
    }
    public function getSettlement(){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $filter = [];
        if (!empty(\request('start_date'))) {
            $filter[] = ['betslip.at_update', '>=', \request('start_date')];
        }
        if (!empty(\request('end_date'))) {
            $filter[] = ['betslip.at_update', '<=', \request('end_date')];
        }
        if (\request('userType')=='admins'){
            $uplineAdminIds=$this->getUpLineAdminIdsOfAdmin(\request('user_id'));
            $admin = Admin::find(\request('user_id'));
            if ($admin->is_supper != 0) {
                return $this->response(0, 'You can not set this option because of your permission.', '');
            }
            if ($admin->isSuper==0){
                $res=DB::table('settlement')->join('markets','markets.id','settlement.market_id')->join('events','events.id','markets.event_id')/*->where([['settlement.user_type',\request('userType')]])*/->where($filter)->whereNotIn('settlement.admin_id',$uplineAdminIds)->select('settlement.*','events.name as eventName','markets.marketName')->orderBy('settlement.id','DESC')->get();
                $res_f=array();
                foreach ($res as $item){
                    $item->adminName=DB::table($item->user_type)->where('id',$item->admin_id)->value('email');
                    $res_f[]=$item;
                }
                return $this->response(0,'success get settlement',$res_f);
            }else{
                $res=DB::table('settlement')->join('markets','markets.id','settlement.market_id')->join('events','events.id','markets.event_id')->where([['settlement.admin_id',\request('user_id')],/*['settlement.user_type',\request('userType')]*/])->where($filter)->whereNotIn('settlement.admin_id',$uplineAdminIds)->select('settlement.*','events.name as eventName','markets.marketName')->get();
                $res_f=array();
                foreach ($res as $item){
                    $item->adminName=DB::table($item->user_type)->where('id',$item->admin_id)->value('email');
                    $res_f[]=$item;
                }
                return $this->response(0,'success get settlement',$res_f);
            }

        }
        else{
            $res=DB::table('settlement')->join('markets','markets.id','settlement.market_id')->join('events','events.id','markets.event_id')->where([['settlement.admin_id',\request('user_id')],['settlement.user_type',\request('userType')]])->where($filter)->select('settlement.*','events.name as eventName','markets.marketName')->get();
            $res_f=array();
            foreach ($res as $item){
                $item->adminName=DB::table($item->user_type)->where('id',$item->admin_id)->value('email');
                $res_f[]=$item;
            }
            return $this->response(0,'success get settlement',$res_f);
        }
    }
    private function getMarketCom($market_id, $user_id)
    {
        $com = DB::table('market_management')->where('market_id')->value('commission');
        if (!isset($com)) {
            $sport_id = DB::table('markets')->join('events', 'events.id', 'markets.event_id')->join('sport_names', 'sport_names.import_id', 'events.sport_id')->where('markets.id', $market_id)->value('sport_names.id');
            $com = DB::table('sport_management')->where([['sport_id', $sport_id], ['admin_id', $user_id], ['userType', 'users']])->value('commission');
        }
        return $com / 100;
    }
    private function getSessionCom($market_id, $user_id)
    {
        $com = DB::table('market_management')->where('market_id')->value('commission');
        if (!isset($com)) {
            $sport_id = DB::table('markets')->join('events', 'events.id', 'markets.event_id')->join('sport_names', 'sport_names.import_id', 'events.sport_id')->where('markets.id', $market_id)->value('sport_names.id');
            $com = DB::table('sport_management')->where([['sport_id', $sport_id], ['admin_id', $user_id], ['userType', 'users']])->value('f_commission');
        }
        return $com / 100;
    }
    public function setRunnersVol()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $admin = Admin::find(\request('user_id'));
        if ($admin->is_supper != 0) {
            return $this->response(0, 'You can not set this option because of your permission.', '');
        }
        $runners = json_decode(json_encode(request('runners')));
        $res = array();
        $matchedBet=array();
        foreach ($runners as $runner) {
            $s_runner = DB::table('runners')->where('id', $runner->id)->first();
            if ($s_runner->availableToBackVol != json_encode($runner->availableToBackVol)) {
                $back = json_decode($s_runner->back);
                $availableToBack = json_decode($s_runner->availableToBack);
                for ($i = 0; $i <= 2; $i++) {
                    if (!isset($back[$i])) continue;
                    $availableToBack[$i]->size = round($back[$i]->size * $runner->availableToBackVol[$i],0);
                }
                $item['id'] = $runner->id;
                $item['type'] = 'availableToBack';
                $item['availableToBack'] = $availableToBack;
                DB::table('runners')->where('id', $runner->id)->update([
                    'availableToBackVol' => json_encode($runner->availableToBackVol),
                    'availableToBack' => json_encode($availableToBack),
                ]);
                $res[] = $item;
                $runner_t=Runner::find($runner->id);
                $temp=$this->checkUnMatchedBet($runner->id,'availableToBack',$runner_t);
                $matchedBet=array_merge($matchedBet,$temp);
            }

            if ($s_runner->availableToLayVol != json_encode($runner->availableToLayVol)) {
                $lay = json_decode($s_runner->lay);
                $availableToLay = json_decode($s_runner->availableToLay);
                for ($i = 0; $i <= 2; $i++) {
                    if (!isset($lay[$i])) continue;
                    $availableToLay[$i]->size = round($lay[$i]->size * $runner->availableToLayVol[$i],0);
                }
                $item['id'] = $runner->id;
                $item['type'] = 'availableToLay';
                $item['availableToLay'] = $availableToLay;
                DB::table('runners')->where('id', $runner->id)->update([
                    'availableToLayVol' => json_encode($runner->availableToLayVol),
                    'availableToLay' => json_encode($availableToLay),
                ]);
                $res[] = $item;
                $runner_t=Runner::find($runner->id);
                $temp=$this->checkUnMatchedBet($runner->id,'availableToLay',$runner_t);
                $matchedBet=array_merge($matchedBet,$temp);
            }
            //$item['runner'] = $item;

        }
        $u_runners=array();
        if (count($res) > 0) {
            $fireBase = new FirebaseController();
            $u_runners=['link' => $res, 'message' => 'update odd', 'type' => 'update odd', 'user_type' => 'users'];
            //$fireBase->SendNotification('runners', ['link' => $res, 'message' => 'update odd', 'type' => 'update odd', 'user_type' => 'users']);
        }
        return $this->response(0, 'Updated successfully', ['runners'=>$u_runners,'matchedBet'=>$matchedBet]);
    }

    public function getRunnersOfMarket($id, $user_id)
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $market = DB::table('markets')->where([['id', $id]/*, ['is_active', 1]*/])->first();
        if ($market->marketType=='fancy'){
            $runners1 = DB::table('runners')
                ->join('markets', 'runners.market_id', 'markets.id')
                ->where([['markets.id', $id], ['runners.is_active', 'true']])
                ->orderBy('runners.runnerName','ASC')
                ->select('runners.*')
                ->get();
        }else{
            $runners1 = DB::table('runners')
                ->join('markets', 'runners.market_id', 'markets.id')
                ->where([['markets.id', $id], ['runners.is_active', 'true']])
                ->select('runners.*')
                ->get();
        }
        $runners1=$runners1->values()->all();
        /*$runners1 = DB::table('runners')
            ->join('markets', 'runners.market_id', 'markets.id')
            ->where([['markets.id', $id], ['runners.is_active', 'true']])
            ->select('runners.*')
            ->get();*/
        $runners = array();

        if (!isset($market)) return 'Can not found market '.$id;
        foreach ($runners1 as $item) {
            if (empty($item->availableToBack)) {
                $item->availableToBack = array();
            } else {
                $item->availableToBack = json_decode($item->availableToBack);
            }
            if (empty($item->availableToLay)) {
                $item->availableToLay = array();
            } else {
                $item->availableToLay = json_decode($item->availableToLay);
            }
            $market_management=DB::table('market_management')->where('market_id',$item->market_id)->first();

            $s_id = $this->getSportOfRunner($item->id);
            $s_manage = DB::table('sport_management')->where([['sport_id', $s_id], ['admin_id', $user_id], ['userType', 'users']])->first();
            if ($market->marketType=='fancy'){
                $item->profit = $this->getLiabilityOfSession($item->id, $user_id);
                if (isset($market_management)){
                    $item->delaySec = $market_management->delaySec;
                    $market->delaySec = $market_management->delaySec;
                }else{
                    $item->delaySec = $s_manage->delaySec;
                    $market->delaySec = $s_manage->delaySec;
                }
            }else{
                $item->profit = $this->getProfitOfRunner($item->id, $user_id);
                if (isset($market_management)){
                    $item->delaySec = $market_management->delaySec;
                    $market->delaySec = $market_management->delaySec;
                }else{
                    $item->delaySec = $s_manage->delaySec;
                    $market->delaySec = $s_manage->delaySec;
                }

            }
            $runners[] = $item;
        }
        $event = DB::table('events')
            ->join('markets', 'markets.event_id', 'events.id')
            ->join('sport_names', 'sport_names.import_id', 'events.sport_id')
            ->where('markets.id', $id)
            ->select('events.*', 'sport_names.name as sportName')->first();

        $is_check=DB::table('market')->where([['user_id',$user_id],['user_type','users'],['market_id',$market->id]])->first();
        $send_data = array();
        if (empty($is_check)){
            $send_data['multi_market'] = 'deactive_market';
        }else{
            $send_data['multi_market'] = 'active_market';
        }
        $send_data['event'] = $event;
        $send_data['runners'] = $runners;
        $send_data['market'] = $market;
        return json_encode($send_data);
    }

    public function getEventOfSports()
    {
        //return 'test';
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $id=\request('id');
        $user_id=\request('user_id');
        $userType=\request('user_type');
        $inPlay=\request('inPlay');
        $fitter = array();
        if ($userType == 'users') {
            $fitter[] = ['markets.is_active', 1];
            $fitter[] = ['markets.marketStatus','<>', 'CLOSED'];
            $fitter[] = ['markets.marketStatus','<>', 'CANCELED'];
        }
        else{
            $admin=Admin::find($user_id);
            if ($admin->is_super>0){
                $fitter[] = ['markets.is_active', 1];
            }
            if (!empty(\request('active'))) {
                $fitter[] = ['markets.is_active', request('active')];
            }
            $fitter[] = ['markets.marketStatus','<>', 'CLOSED'];
            $fitter[] = ['markets.marketStatus','<>', 'CANCELED'];
        }
        if ($inPlay!='all'){
            $fitter[] = ['markets.inPlay', $inPlay];
        }
        $events = DB::table('events')
            ->join('sport_names', 'sport_names.import_id', 'events.sport_id')
            ->where([['sport_names.id', $id], ['events.is_active', 'true'], ['events.time', '>', Carbon::now()->subHour(24)], ['events.time', '<', Carbon::now()->addHour(72)] /*['events.state', $state]*/])
            //->whereIn('events.time_status', ['0', '1'])
            ->join('markets', 'markets.event_id', 'events.id')
            ->where($fitter)
            ->where([['markets.marketName', 'Match Odds']])
            //->join('runners', 'runners.market_id', 'markets.id')
            //->where([['runners.is_active', 'true'], ['runners.availableToBack', '<>', '[]'], ['runners.availableToLay', '<>', '[]'], ['runners.availableToBack', '<>', '[{"size":"--","price":"--"},{"size":"--","price":"--"},{"size":"--","price":"--"}]'], ['runners.availableToLay', '<>', '[{"size":"--","price":"--"},{"size":"--","price":"--"},{"size":"--","price":"--"}]']])
            ->select('events.*', 'markets.id as market_id', 'marketName', 'markets.is_active as marketActive','markets.isUpdate as marketUpdate','markets.marketStatus','markets.inPlay')
            ->distinct()
            //->orderBy('events.time_status', 'dec')
            ->orderBy('events.time', 'asc')
            ->get();
        $events_f = array();
        foreach ($events as $event) {
            $runners = DB::table('runners')
                ->where([['market_id', $event->market_id]])
                ->get();
            $gtm=new Carbon($event->time);
            $event->time=$event->time.'(GTM)/'.$gtm->addHour(5)->addMinute(30).'(IST)';
            $item['event'] = $event;
            $item['runners'] = $runners;
            $is_multi = DB::table('market')->where([['market_id', $event->market_id], ['user_id', $user_id], ['user_type', $userType]])->value('id');
            if (isset($is_multi)) {
                $item['multi'] = 'active_market';
            } else {
                $item['multi'] = 'deactive_market';
            }

            if (count($runners) == 0) continue;
            $events_f[] = $item;
        }
        return json_encode($events_f);
    }

    public function setMarketActive()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $admin = Admin::find(\request('user_id'));
        if ($admin->is_supper != 0) {
            return $this->response(0, 'You can not set this option because of your permission.', '');
        }
        DB::table('markets')->where('id', \request('market_id'))->update(['is_active' => \request('is_active')/*,'isUpdate' => \request('is_active')*/]);
        return $this->response(0, 'Set successfully', DB::table('markets')->where('id', \request('market_id'))->first());
    }
    public function setMarketUpdate()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $admin = Admin::find(\request('user_id'));
        if ($admin->is_supper != 0) {
            return $this->response(0, 'You can not set this option because of your permission.', '');
        }
        DB::table('markets')->where('id', \request('market_id'))->update(['isUpdate' => \request('isUpdate')]);
        $api1=new Api1Controller();
        $market=DB::table('markets')->where('id', \request('market_id'))->first();
        $event=Event::find($market->event_id);
        $msg=$api1->activeMarket($market->marketId);
        //$msg1=$api1->market_book_list($market->marketId);
        switch ($event->sport_id){
            case 1:
                $api1->under_over_goal_market_list($event->import_id);
                break;
            case 2:
                break;
            case 4:
                //$api1->line_market_list($event->import_id);
                $api1->cricket_extra_market_list($event->import_id);

                break;
        }
        return $this->response(0, json_encode($msg), $event);
    }
    public function setMarketPlay()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $admin = Admin::find(\request('user_id'));
        if ($admin->is_supper != 0) {
            return $this->response(0, 'You can not set this option because of your permission.', '');
        }
        DB::table('markets')->where('id', \request('market_id'))->update(['isPlay' => \request('isPlay')]);

        return $this->response(0, 'Success set', \request('market_id'));
    }
    public function getEventOfLeague()
    {
        //return 'test';
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $id=\request('id');
        $user_id=\request('user_id');
        $userType=\request('user_type');
        $inPlay=\request('inPlay');
        $fitter = array();
        if ($userType == 'users') {
            $fitter[] = ['markets.is_active', 1];
            $fitter[] = ['markets.marketStatus','<>', 'CLOSED'];
        }
        else{
            $admin=Admin::find($user_id);
            if ($admin->is_super>0){
                //$fitter[] = ['markets.is_active', 1];
            }
            if (!empty(\request('active'))) {
                //$fitter[] = ['markets.is_active', request('active')];
            }
            //$fitter[] = ['markets.marketStatus','<>', 'CLOSED'];
        }
        if ($inPlay!='all'){
            //$fitter[] = ['markets.inPlay', $inPlay];
        }
        $events = DB::table('events')
            ->join('sport_names', 'sport_names.import_id', 'events.sport_id')
            ->where([['events.league_id', $id], ['events.is_active', 'true']])
            //->whereIn('events.time_status', ['0', '1'])
            ->join('markets', 'markets.event_id', 'events.id')
            //->where($fitter)
            ->where([['markets.marketName', 'Match Odds']])
            //->join('runners', 'runners.market_id', 'markets.id')
            //->where([['runners.is_active', 'true'], ['runners.availableToBack', '<>', '[]'], ['runners.availableToLay', '<>', '[]'], ['runners.availableToBack', '<>', '[{"size":"--","price":"--"},{"size":"--","price":"--"},{"size":"--","price":"--"}]'], ['runners.availableToLay', '<>', '[{"size":"--","price":"--"},{"size":"--","price":"--"},{"size":"--","price":"--"}]']])
            ->select('events.*', 'markets.id as market_id', 'marketName', 'markets.is_active as marketActive','markets.isUpdate as marketUpdate','markets.marketStatus','markets.inPlay')
            ->distinct()
            //->orderBy('events.time_status', 'dec')
            ->orderBy('events.time', 'asc')
            ->get();
        $events_f = array();
        foreach ($events as $event) {
            $runners = DB::table('runners')
                ->where([['market_id', $event->market_id]])
                ->get();
            $gtm=new Carbon($event->time);
            $event->time=$event->time.'(GTM)/'.$gtm->addHour(5)->addMinute(30).'(IST)';
            $item['event'] = $event;
            $item['runners'] = $runners;
            $is_multi = DB::table('market')->where([['market_id', $event->market_id], ['user_id', $user_id], ['user_type', $userType]])->value('id');
            if (isset($is_multi)) {
                $item['multi'] = 'active_market';
            } else {
                $item['multi'] = 'deactive_market';
            }

            if (count($runners) == 0) continue;
            $events_f[] = $item;
        }
        return json_encode($events_f);

    }

    public function getRunnerOfMatch($event_id)
    {
        $runners = DB::table('runners')
            ->join('markets', 'runners.market_id', 'markets.id')
            ->where([['markets.event_id', $event_id], ['markets.marketType', 'MATCH_ODDS']])
            ->select('runners.*')
            ->get();
        return json_encode($runners);
    }

    public function createBetSlip(Request $request)
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $isBet=$this->isBet($request->user_id);
        if ($isBet==1){
            return $this->response(1, 'You cannot place bets, as your betting is locked', null);
        }
        if ((float)$request->odd == 0) {
            return $this->response(1, 'You can not bet. Invalid odd', null);
        } else {
            DB::table('betslip')->where([['user_id',$request->user_id],['state',0]])->delete();
            $market_id = DB::table('runners')->where('id', $request->runner_id)->value('market_id');
            $marketType = DB::table('markets')->where('id', $market_id)->value('marketType');
            if ($marketType=='fancy'){
                $odd=json_decode(Runner::where('id',$request->runner_id)->value($request->bet_type))[0]->size/100+1;
                $rate=json_decode(Runner::where('id',$request->runner_id)->value($request->bet_type))[0]->price;
                $insert_data = [
                    'user_id' => $request->user_id,
                    'runner_id' => $request->runner_id,
                    'bet_type' => $request->bet_type,
                    'odd' => (float)$odd,
                    'rate' => (float)$rate,
                ];
            }else{
                $insert_data = [
                    'user_id' => $request->user_id,
                    'runner_id' => $request->runner_id,
                    'bet_type' => $request->bet_type,
                    'odd' => (float)$request->odd,
                ];
            }

            $id = DB::table('betslip')->insertGetId($insert_data);
            $betSlip = DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->join('markets', 'markets.id', 'runners.market_id')
                ->join('events', 'markets.event_id', 'events.id')
                ->where('betslip.id', $id)
                ->select('betslip.*', 'markets.marketName', 'markets.id as market_id', 'events.name as eventName', 'runners.runnerName', 'events.id as event_id','markets.marketType')
                ->first();
            $s_id = $this->getSportOfRunner($betSlip->runner_id);
            $s_manage = DB::table('sport_management')->where([['sport_id', $s_id], ['admin_id', $betSlip->user_id], ['userType', 'users']])->first();
            $betSlip->delaySec = $s_manage->delaySec;
            $betSlip->f_delaySec = $s_manage->f_delaySec;




            $isDownMarket=DB::table('markets')->where('id',$market_id)->value('marketStatus');
            if ($isDownMarket=='CLOSED'){
                DB::table('betslip')->where([['betslip.id', $betSlip->id]])->delete();
                return $this->response(1, 'Market Closed Already '.$market_id, $s_manage);
            }

            $liability = $this->getLiabilityOfMarket($market_id, $request->user_id);
            if ($liability > 0) {
                $liability = 0;
            }
            $user = DB::table('users')->where('id', $request->user_id)->first();
            $wallet = $user->wallet - $liability;
            $send_data['wallet'] = $wallet;
            $send_data['betItem'] = $betSlip;
            $send_data['profit'] = $this->getLiabilityOfMarket1($request->runner_id, $request->user_id);
            return $this->response(0, 'Added To Bet Slip' . $betSlip->id, $send_data);
        }
    }

    public function getLiabilityOfMarket1($runner_id, $user_id)
    {
        $market_id = DB::table('runners')->where('id', $runner_id)->value('market_id');
        $runners = DB::table('runners')->where('market_id', $market_id)->get();

        foreach ($runners as $item) {
            $li_item = DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', $item->id], ['betslip.user_id', $user_id], ['betslip.state', 1], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('profit_amount')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', $item->id], ['betslip.user_id', $user_id], ['betslip.state', 1], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', $item->id], ['betslip.user_id', $user_id], ['betslip.state', 1], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', $item->id], ['betslip.user_id', $user_id], ['betslip.state', 1], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('profit_amount');
            /*DB::table('user_profit')->updateOrInsert(['market_id' => $market_id,'runner_id'=>$item->id,'user_id'=>$user_id], ['market_id' => $market_id,'runner_id'=>$item->id,'liability'=>$li_item,'user_id'=>$user_id]);*/
            $liability[] = ['amount' => $li_item, 'runner_id' => $item->id];
        }
        //$liability=min($liability);
        return $liability;
    }

    public function getProfitOfRunner($runner_id, $user_id)
    {
        $market_id = DB::table('runners')->where('id', $runner_id)->value('market_id');
        $liability = array();
        $profit = DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->where([['betslip.runner_id', $runner_id], ['betslip.user_id', $user_id], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                ->sum('profit_amount')
            + DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->where([['betslip.runner_id', '<>', $runner_id], ['betslip.user_id', $user_id], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                ->sum('exposure')
            + DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->where([['betslip.runner_id', $runner_id], ['betslip.user_id', $user_id], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                ->sum('exposure')
            + DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->where([['betslip.runner_id', '<>', $runner_id], ['betslip.user_id', $user_id], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                ->sum('profit_amount');
        return round($profit, 2);
    }

    public function getBetSlips($user_id)
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $betSlips = DB::table('betslip')
            ->join('runners', 'runners.id', 'betslip.runner_id')
            ->join('markets', 'markets.id', 'runners.market_id')
            ->join('events', 'markets.event_id', 'events.id')
            ->where([['betslip.state', 0], ['betslip.user_id', $user_id],['markets.marketStatus','OPEN']])
            ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id')
            ->get();
        $betSlips_f = array();
        foreach ($betSlips as $item) {
            $s_id = $this->getSportOfRunner($item->runner_id);
            $s_manage = DB::table('sport_management')->where([['sport_id', $s_id], ['admin_id', $item->user_id], ['userType', 'users']])->first();
            $item->delaySec = $s_manage->delaySec;
            $betSlips_f[] = $item;
        }
        return response(json_encode($betSlips_f), Response::HTTP_OK);
    }

    public function setActiveMarket()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        DB::table('markets')->where('id', \request('market_id'))->update(['is_active' => \request('state')]);
        return json_encode(\request('state'));
    }
    public function getOpenBet($user_id,$market_id){
        $fancyBets = DB::table('betslip')
            ->join('runners', 'runners.id', 'betslip.runner_id')
            ->join('markets', 'markets.id', 'runners.market_id')
            ->join('events', 'markets.event_id', 'events.id')
            ->where([['betslip.state', 1],['betslip.rate','>',-1], ['betslip.user_id', $user_id],['markets.marketStatus','OPEN']])
            ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status')
            ->orderBy('betslip.at_update', 'DESC')
            ->get();
        $fancyItems = DB::table('runners')
            ->join('markets', 'runners.market_id', 'markets.id')
            ->join('events', 'events.id', 'markets.event_id')
            ->join('betslip', 'betslip.runner_id', 'runners.id')
            ->where([['betslip.user_id', $user_id],['betslip.rate','>',-1]])->select('runners.*', 'events.name as eventName')
            ->get()->unique();
        $fancyItems_f=array();
        foreach ($fancyItems as $item) {
            $betSlips = DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->join('markets', 'markets.id', 'runners.market_id')
                ->join('events', 'markets.event_id', 'events.id')
                ->where([['betslip.state', 1], ['betslip.user_id', $user_id], ['runners.id', $item->id],['markets.marketType','fancy']])
                ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status')
                ->orderBy('betslip.at_update', 'DESC')
                ->get();
            if (count($betSlips)==0)continue;
            $item->runnerName = $item->runnerName.'('.count($betSlips).')';
            $fancyItems_f[] = $item;
        }
        if ($market_id !== 0) {
            $betSlips_matched = DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->join('markets', 'markets.id', 'runners.market_id')
                ->join('events', 'markets.event_id', 'events.id')
                ->where([['betslip.state', 1],['betslip.rate',-1], ['betslip.user_id', $user_id], ['betslip.is_matched', 'true'], ['markets.id', $market_id],['markets.marketStatus','OPEN']])
                ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status')
                ->orderBy('betslip.at_update', 'DESC')
                ->get();
            $betSlips_unmatched = DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->join('markets', 'markets.id', 'runners.market_id')
                ->join('events', 'markets.event_id', 'events.id')
                ->where([['betslip.state', 1],['betslip.rate',-1], ['betslip.user_id', $user_id], ['betslip.is_matched', 'false'], ['markets.id', $market_id],['markets.marketStatus','OPEN']])
                ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status')
                ->orderBy('betslip.at_update', 'DESC')
                ->get();
        } else {
            $betSlips_matched = DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->join('markets', 'markets.id', 'runners.market_id')
                ->join('events', 'markets.event_id', 'events.id')
                ->where([['betslip.state', 1],['betslip.rate',-1], ['betslip.user_id', $user_id], ['betslip.is_matched', 'true'],['markets.marketStatus','OPEN']])
                ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status')
                ->orderBy('betslip.at_update', 'DESC')
                ->get();
            $betSlips_unmatched = DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->join('markets', 'markets.id', 'runners.market_id')
                ->join('events', 'markets.event_id', 'events.id')
                ->where([['betslip.state', 1],['betslip.rate',-1], ['betslip.user_id', $user_id], ['betslip.is_matched', 'false'],['markets.marketStatus','OPEN']])
                ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status')
                ->orderBy('betslip.at_update', 'DESC')
                ->get();
        }
        $markets = DB::table('markets')
            ->join('events', 'events.id', 'markets.event_id')
            ->join('runners', 'runners.market_id', 'markets.id')
            ->join('betslip', 'betslip.runner_id', 'runners.id')
            ->where([['betslip.user_id', $user_id],['betslip.rate',-1],['markets.marketStatus','OPEN']])->select('markets.*', 'events.name as eventName')
            ->get()->unique();
        $markets_f = array();
        foreach ($markets as $item) {
            $betSlips = DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->join('markets', 'markets.id', 'runners.market_id')
                ->join('events', 'markets.event_id', 'events.id')
                ->where([['betslip.state', 1],['betslip.rate',-1], ['betslip.user_id', $user_id], ['markets.id', $item->id],['markets.marketStatus','OPEN']])
                ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status')
                ->orderBy('betslip.at_update', 'DESC')
                ->get();
            $item->count = count($betSlips);
            $markets_f[] = $item;
        }
        $betSlips = DB::table('betslip')
            ->join('runners', 'runners.id', 'betslip.runner_id')
            ->join('markets', 'markets.id', 'runners.market_id')
            ->join('events', 'markets.event_id', 'events.id')
            ->where([['betslip.state', 1],['betslip.rate',-1], ['betslip.user_id', $user_id],['markets.marketStatus','OPEN']])
            ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status')
            ->orderBy('betslip.at_update', 'DESC')
            ->get();
        return ['matched' => $betSlips_matched, 'ummatched' => $betSlips_unmatched,'fancyBets'=>$fancyBets, 'markets' => $markets_f,'fancy_runners'=>$fancyItems_f, 'total_count' => count($betSlips)];
    }
    public function getPlacedBetSlips($user_id, $market_id = 0)
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        return json_encode($this->getOpenBet($user_id,$market_id));
    }

    public function getUpLineAdmins($user_id)
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $user = DB::table('users')->where([['id', $user_id]])->first();
        //return json_encode($user);
        if (empty($user)) return $this->response(0, 'can not user','');
        $admins = array();
        $parentId = $user->parent_id;
        $user->admin = array();
        $user->super_master = array();
        $user->master = array();
        while (true) {
            $rootAdmin = DB::table('admins')->where('id', $parentId)->first();
            if ($parentId == 0) break;
            switch ($rootAdmin->is_super) {
                case 1:
                    $user->admin = $rootAdmin;
                    break;
                case 2:
                    $user->super_master = $rootAdmin;
                    break;
                case 3:
                    $user->master = $rootAdmin;
                    break;
            }
            $parentId = $rootAdmin->parent_id;
        }
        return $this->response(1, 'getUpLineAdmins', $user);
    }

    public function getUserPosition($user_id, $market_id = 0)
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $user_ids = $this->getUsersOfAdmin($user_id);
        $markets = DB::table('markets')
            ->join('events', 'events.id', 'markets.event_id')
            ->join('runners', 'runners.market_id', 'markets.id')
            ->join('betslip', 'betslip.runner_id', 'runners.id')
            ->where([['markets.marketType',null]])
            ->whereIn('betslip.user_id', $user_ids)
            ->select('markets.*', 'events.name as eventName')
            ->get()->unique();
        $markets_f = array();
        $runners_f = array();
        $userPosition = array();
        //return json_encode($markets);
        foreach ($markets as $item) {
            $childAdminAccount = Admin::where('parent_id', $user_id)->get();
            $childUserAccount = User::where('parent_id', $user_id)->get();
            if ($item->marketName == 'Fancy Markets')continue;
            if ($market_id!=0 && $market_id!=$item->id)continue;
            $up_item = array();
            $runners = DB::table('runners')
                ->where([['market_id', $item->id],])
                ->get();
            foreach ($childAdminAccount as $admin) {
                $account = ['name' => $admin->email, 'id' => $admin->id, 'type' => 'admins'];
                $profits = array();
                $insert_state = 0;
                $upAdmins=$this->getUpLineAdminIdsOfAdmin($admin->id);
                foreach ($runners as $runner) {
                    $temp_profit=0;
//                    foreach ($upAdmins as $upAdmin){
//                        $temp_profit+=$this->getProfitOfAdminOfRunner($runner->id, $upAdmin->id);
//                    }
                    $profit = round(/*$temp_profit+*/$this->getProfitOfAdminOfRunner($runner->id, $admin->id) ,2);
                    $profits[] = -$profit;
                    $insert_state += abs($profit);
                }
                if ($insert_state != 0) $up_item[] = ['account' => $account, 'profits' => $profits];
            }
            foreach ($childUserAccount as $admin) {
                $account = ['name' => $admin->email, 'id' => $admin->id, 'type' => 'users'];
                $profits = array();
                $insert_state = 0;
                foreach ($runners as $runner) {
                    $profit = -$this->getProfitOfRunner($runner->id, $admin->id);
                    $profits[] = $profit;
                    $insert_state += abs($profit);
                }
                if ($insert_state != 0) $up_item[] = ['account' => $account, 'profits' => $profits];
            }
            //own
            if (count($runners) == 3) {
                $profits = [0, 0, 0];
            } else {
                $profits = [0, 0];
            }

            foreach ($up_item as $pos_item) {
                $index = 0;
                foreach ($pos_item['profits'] as $profit) {
                    $profits[$index] += $profit;
                    $profits[$index] = round($profits[$index], 2);
                    $index++;
                }
            }
            $account = ['name' => "Total", 'id' => $user_id, 'type' => 'users'];
            $up_item[] = ['account' => $account, 'profits' => $profits];

            $account = ['name' => "Own", 'id' => $user_id, 'type' => 'users'];
            $runners_f[$item->id] = DB::table('runners')
                ->where([['market_id', $item->id],])
                ->get();
            $profits = array();
            foreach ($runners as $runner) {
                $profit = $this->getProfitOfAdminOfRunnerOwn($runner->id, $user_id);
                $profits[] = -$profit;
            }
            $up_item[] = ['account' => $account, 'profits' => $profits];
            //$admin=Admin::find('')
            $account = ['name' => "Parent", 'id' => $user_id, 'type' => 'users'];
            $profits = array();
            foreach ($runners as $runner) {
                $profit = $this->getProfitOfAdminOfRunnerParent($runner->id, $user_id);
                $profits[] = -$profit;
            }
            $up_item[] = ['account' => $account, 'profits' => $profits];
            $userPosition[$item->id] = $up_item;
        }
        return $this->response(1, 'Get UserPosition', ['runners' => $runners_f, 'userPosition' => $userPosition]);
    }
    //rest
    public function getUpLineAdminIdsOfAdmin($admin_id)
    {
        $admin = DB::table('admins')->where([['id', $admin_id]])->first();
        $admins = array();
        $parentId = $admin->parent_id;
        $admin_ids = [];
        while (true) {
            if ($parentId == 0) break;
            $rootAdmin = DB::table('admins')->where('id', $parentId)->first();
            $admin_ids[] = $rootAdmin;
            $parentId = $rootAdmin->parent_id;
        }
        return $admin_ids;
    }
//rest
    public function getPlacedBetSlipsAdmin($user_id, $market_id = 0)
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $user_ids = $this->getUsersOfAdmin($user_id);
        $fancyBets = DB::table('betslip')
            ->join('runners', 'runners.id', 'betslip.runner_id')
            ->join('markets', 'markets.id', 'runners.market_id')
            ->join('events', 'markets.event_id', 'events.id')
            ->whereIn('betslip.user_id', $user_ids)
            ->where([['betslip.state', 1],['betslip.rate','>',-1]])
            ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status')
            ->orderBy('betslip.at_update', 'DESC')
            ->get();
        $fancy_runners = DB::table('runners')
            ->join('markets', 'runners.market_id', 'markets.id')
            ->join('events', 'events.id', 'markets.event_id')
            ->join('betslip', 'betslip.runner_id', 'runners.id')
            ->where([['betslip.rate','>',-1]])
            ->whereIn('betslip.user_id', $user_ids)
            ->select('runners.*', 'events.name as eventName')
            ->get()->unique('id');
        $fancy_runners=$fancy_runners->values()->all();
        $fancy_runners1=array();
        foreach ($fancy_runners as $item){
            $bets=DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->join('markets', 'markets.id', 'runners.market_id')
                ->join('events', 'markets.event_id', 'events.id')
                ->whereIn('betslip.user_id', $user_ids)
                ->where([['betslip.state', 1],['betslip.rate','>',-1],['betslip.runner_id',$item->id]])
                ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status')
                ->orderBy('betslip.at_update', 'DESC')
                ->get();
            if (count($bets)==0)continue;
            $item->runnerName=$item->runnerName.'('.count($bets).')';
            $fancy_runners1[]=$item;
        }
        $fancy_runners=$fancy_runners1;
        if ($market_id !== 0) {
            $runners = DB::table('runners')
                ->where([['market_id', $market_id],])
                ->get();
            $betSlips_matched = DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->join('markets', 'markets.id', 'runners.market_id')
                ->join('events', 'markets.event_id', 'events.id')
                ->join('users', 'users.id', 'betslip.user_id')
                ->whereIn('betslip.user_id', $user_ids)
                ->where([['betslip.state', 1], ['betslip.is_matched', 'true'],['betslip.rate',-1], ['markets.id', $market_id],['markets.marketStatus','OPEN']])
                ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status', 'users.email as userName')
                ->orderBy('betslip.at_update', 'DESC')
                ->get();
            $betSlips_unmatched = DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->join('markets', 'markets.id', 'runners.market_id')
                ->join('events', 'markets.event_id', 'events.id')
                ->join('users', 'users.id', 'betslip.user_id')
                ->whereIn('betslip.user_id', $user_ids)
                ->where([['betslip.state', 1],['betslip.rate',-1], ['betslip.is_matched', 'false'], ['markets.id', $market_id],['markets.marketStatus','OPEN']])
                ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status', 'users.email as userName')
                ->orderBy('betslip.at_update', 'DESC')
                ->get();
        } else {
            $betSlips_matched = DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->join('markets', 'markets.id', 'runners.market_id')
                ->join('events', 'markets.event_id', 'events.id')
                ->join('users', 'users.id', 'betslip.user_id')
                ->whereIn('betslip.user_id', $user_ids)
                ->where([['betslip.state', 1],['betslip.rate',-1], ['betslip.is_matched', 'true'],['markets.marketStatus','OPEN']])
                ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status', 'users.email as userName')
                ->orderBy('betslip.at_update', 'DESC')
                ->get();
            $betSlips_unmatched = DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->join('markets', 'markets.id', 'runners.market_id')
                ->join('events', 'markets.event_id', 'events.id')
                ->join('users', 'users.id', 'betslip.user_id')
                ->whereIn('betslip.user_id', $user_ids)
                ->where([['betslip.state', 1],['betslip.rate',-1], ['betslip.is_matched', 'false'],['markets.marketStatus','OPEN']])
                ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status', 'users.email as userName')
                ->orderBy('betslip.at_update', 'DESC')
                ->get();
        }
        $markets = DB::table('markets')
            ->join('events', 'events.id', 'markets.event_id')
            ->join('runners', 'runners.market_id', 'markets.id')
            ->join('betslip', 'betslip.runner_id', 'runners.id')
            ->where([['markets.marketStatus','OPEN'],['betslip.rate',-1]])
            ->whereIn('betslip.user_id', $user_ids)
            ->select('markets.*', 'events.name as eventName')
            ->get()->unique();
        $markets_f = array();

        foreach ($markets as $item) {
            $betSlips = DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->join('markets', 'markets.id', 'runners.market_id')
                ->join('events', 'markets.event_id', 'events.id')
                ->whereIn('betslip.user_id', $user_ids)
                ->where([['betslip.state', 1],['betslip.rate',-1], ['markets.id', $item->id]])
                ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status')
                ->orderBy('betslip.at_update', 'ASC')
                ->get();
            $item->count = count($betSlips);
            $markets_f[] = $item;


        }
        $betSlips = DB::table('betslip')
            ->join('runners', 'runners.id', 'betslip.runner_id')
            ->join('markets', 'markets.id', 'runners.market_id')
            ->join('events', 'markets.event_id', 'events.id')
            ->whereIn('betslip.user_id', $user_ids)
            ->where([['betslip.state', 1],['betslip.rate',-1],['markets.marketStatus','OPEN']])
            ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status')
            ->orderBy('betslip.at_update', 'ASC')
            ->get();
        $betSlips_matched_f=array();
        foreach ($betSlips_matched as $item){
            $item->accountNames=$this->getAccountNameOfUpline($item->user_id);
            $betSlips_matched_f[]=$item;
        }
        $betSlips_unmatched_f=array();
        foreach ($betSlips_unmatched as $item){
            $item->accountNames=$this->getAccountNameOfUpline($item->user_id);
            $betSlips_unmatched_f[]=$item;
        }
        $fancyBets_f=array();
        foreach ($fancyBets as $item){
            $item->accountNames=$this->getAccountNameOfUpline($item->user_id);
            $fancyBets_f[]=$item;
        }
        return json_encode(['matched' => $betSlips_matched_f, 'ummatched' => $betSlips_unmatched_f, 'markets' => $markets_f,'fancy_runners'=>$fancy_runners,'fancyBets'=>$fancyBets_f, 'total_count' => count($betSlips)]);
    }
    public function getAccountNameOfUpline($user_id){
        $user = DB::table('users')->where([['id', $user_id]])->first();
        //return json_encode($user);
        if (empty($user)) return $this->response(0, 'can not user' , '');
        $admins = array();
        $parentId = $user->parent_id;

        $accountName=$user->email;
        while (true) {
            $rootAdmin = DB::table('admins')->where('id', $parentId)->first();
            if ($rootAdmin->parent_id == 0) break;
            $accountName=$rootAdmin->email.'/'.$accountName;
            $parentId = $rootAdmin->parent_id;
        }
        return $accountName;
    }
    public function getProfitBetSlipsAdmin()
    {
        $admin_id=\request('admin_id');
        if (!empty(\request('runner_id'))){
            $runner_id=\request('runner_id');
            $user_ids=array();
            if (!empty(\request('user_type'))){
                $user_ids[] = $admin_id;
            }else{
                $user_ids = $this->getUsersOfAdmin($admin_id);
            }

            $betSlips_matched = DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->join('markets', 'markets.id', 'runners.market_id')
                ->join('events', 'markets.event_id', 'events.id')
                ->join('users', 'users.id', 'betslip.user_id')
                ->whereIn('betslip.user_id', $user_ids)
                ->where([['betslip.profit','<>','none'],['runners.id', $runner_id]])
                ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status', 'users.email as userName','markets.id as marketId')
                ->orderBy('id', 'dec')
                ->get();
        }else{
            $market_id=\request('market_id');
            $user_ids=array();
            if (!empty(\request('user_type'))){
                $user_ids[] = $admin_id;
            }else{
                $user_ids = $this->getUsersOfAdmin($admin_id);
            }

            $betSlips_matched = DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->join('markets', 'markets.id', 'runners.market_id')
                ->join('events', 'markets.event_id', 'events.id')
                ->join('users', 'users.id', 'betslip.user_id')
                ->whereIn('betslip.user_id', $user_ids)
                ->where([['betslip.profit','<>','none'],['markets.id', $market_id]])
                ->select('betslip.*', 'markets.marketName', 'runners.runnerName', 'events.name as eventName', 'events.id as event_id', 'events.time_status', 'users.email as userName','markets.id as marketId')
                ->orderBy('id', 'dec')
                ->get();
        }

        //$res=array();

        return json_encode($betSlips_matched);
    }
    public function getProfitOfAdminOfRunner($runner_id, $user_id)
    {
        $admin = Admin::find($user_id);
        $market_id = DB::table('runners')->where('id', $runner_id)->value('market_id');
        $admin_ids = Admin::where('parent_id', $user_id)->pluck('id');
        $admin_ids[] = $user_id;
        $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
        $admin_ids[] = $user_id;
        $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
        $admin_ids[] = $user_id;
        $user_ids = User::whereIn('parent_id', $admin_ids)->pluck('id')->unique();
        $profit = 0;
        foreach ($user_ids as $userId) {
            $item = DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', $runner_id], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('profit_amount')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', $runner_id], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', $runner_id], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', $runner_id], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('profit_amount');
            $profit += $item * $admin->partnerShip / 100;
        }
        return round($profit, 2);
    }

    public function getProfitOfAdminOfRunnerOwn($runner_id, $user_id)
    {
        $market_id = DB::table('runners')->where('id', $runner_id)->value('market_id');
        //$user_id=\request('user_id');
        $admin_ids = Admin::where('parent_id', $user_id)->pluck('id');
        $admin_ids[] = $user_id;
        $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
        $admin_ids[] = $user_id;
        $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
        $admin_ids[] = $user_id;
        $user_ids = User::whereIn('parent_id', $admin_ids)->pluck('id')->unique();
        $profit = 0;
        foreach ($user_ids as $userId) {
            $item = DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', $runner_id], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('profit_amount')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', $runner_id], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', $runner_id], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', $runner_id], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('profit_amount');
            $profit += $item * $this->getPartnerShip($user_id, $userId);
        }
        return round($profit, 2);
    }

    public function getProfitOfAdminOfRunnerParent($runner_id, $user_id)
    {
        $market_id = DB::table('runners')->where('id', $runner_id)->value('market_id');
        //$user_id=\request('user_id');
        $admin_ids = Admin::where('parent_id', $user_id)->pluck('id');
        $admin_ids[] = $user_id;
        $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
        $admin_ids[] = $user_id;
        $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
        $admin_ids[] = $user_id;
        $user_ids = User::whereIn('parent_id', $admin_ids)->pluck('id')->unique();
        $profit = 0;
        foreach ($user_ids as $userId) {
            $item = DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', $runner_id], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('profit_amount')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', $runner_id], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', $runner_id], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', $runner_id], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('profit_amount');
            $profit += $item * ($this->getPartnerShipOfParent($user_id));
        }
        return round($profit, 2);
    }

    public function getPartnerShipOfParent($adminId)
    {
        $admin = Admin::find($adminId);
        $partnerShip = 0;
        while (true) {
            $parentId = $admin->parent_id;
            $partnerShip += $admin->partnerShip;
            if ($parentId == 0) break;
            $admin = Admin::find($parentId);
            if (!isset($admin)) break;
        }
        return $partnerShip / 100;
    }
//rest
    public function delBetSlip($id)
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $is_check = DB::table('betslip')
            ->where([['betslip.state', 1]/*,['events.status','1']*/, ['betslip.id', $id]])
            ->first();
        if (!empty($is_check)) {
            return $this->response(1, 'You can not cancel. You confirmed already', null);
        }
        $betSlipItem = DB::table('betslip')->join('runners', 'runners.id', 'betslip.runner_id')->where('betslip.id', $id)->select('betslip.*', 'runners.market_id')->first();
        DB::table('betslip')
            ->where('id', $id)->delete();
        return $this->response(0, 'Deleted', $betSlipItem->market_id);
    }
//rest
    public function delPlacedBetSlip($id)
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $is_check = DB::table('betslip')
            ->where([['betslip.state', 2]/*,['events.status','1']*/, ['betslip.id', $id]])
            ->value('is_work');
        if ($is_check==1) {
            return $this->response(1, 'You can not cancel. Plz try later', null);
        }
        $item = DB::table('betslip')
            ->where([['betslip.id', $id]])
            ->first();
        if (!isset($item)) {
            return $this->response(2, 'It was matched just now', null);
        }
        $user_id = $item->user_id;

        $user = DB::table('users')->where('id', $user_id)->first();
        $market_id = DB::table('runners')->where('id', $item->runner_id)->value('market_id');
        $isMarketsWorks=DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->first();
        if (!isset($isMarketsWorks)){
            //DB::table('user_markets')->insert(['market_id'=>$market_id,'user_id'=>$user_id,'is_work'=>1]);
            return $this->response(1, 'You can not cancel. Plz try later', null);
        }else{
            if ($isMarketsWorks->is_work==1){
               // DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0,'action'=>'delete betslip']);
                return $this->response(1, 'You can not bet, because another action, Please try later.'.$isMarketsWorks->id, null);
            }
            DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>1,'action'=>'delete betslip']);
        }
        $old_liability = $this->getLiabilityOfMarket($market_id, $user_id);
        //DB::table('betslip')            ->where([['betslip.id', $id]])->update(['is_matched'=>'false']);
        //return $this->response(0, $old_liability, '');
        DB::table('betslip')
            ->where('id', $id)->delete();
        $total_liability = $this->getLiabilityOfMarket($market_id, $user_id);
        $f_wallet = $user->wallet - $old_liability + $total_liability;
        DB::table('users')->where('id', $user_id)->update(['wallet' => $f_wallet]);
        $old_exposure=$user->exposure;
        $user->exposure = $user->exposure - $old_liability + $total_liability;

        if ($user->exposure>0)$user->exposure=0;
        DB::table('users')->where('id', $user_id)->update(['exposure' => $user->exposure]);
        DB::table('liability_log')->insert(['user_id'=>$user->id,'wallet'=>$user->wallet,'exposure'=>$user->exposure,'old_liability'=>$old_liability,'n_liability'=>$total_liability,'old_exposure'=>$old_exposure,'t_id'=>$id,'action'=>'delete betslip']);
        $msg1 = 'DelPlacedBet:Matched:' . $user->email . 'runner:' . $this->getRunnerName($item->runner_id) . ' BetType:' . $item->bet_type . ', Odds:' . $item->odd . ', Stake:' . $item->stake;
        //$firebase = new FirebaseController();
        $delPlacedBet=['bet_item' => $item, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($user_id), 'market_id' => $market_id];
        //$firebase->SendNotification('delPlacedBet', ['bet_item' => $item, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($user_id), 'market_id' => $market_id]);


        $msg1 = 'DelPlacedBet:Matched:' . ' runner:' . $this->getRunnerName($item->runner_id) . ' BetType:' . $item->bet_type . ', Odds:' . $item->odd . ', Stake:' . $item->stake;
        DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
        $note=['msg' => $msg1, 'admins' => $this->getUpLineAdminIds($user_id), 'market_id' => $market_id,'userRunnerPosition'=>$this->getRunnerPosition($market_id,$user_id),'adminRunnerPosition'=>$this->getRunnerPositionAdmins($market_id,$user_id),'openBets'=>$this->getOpenBet($user_id,0),'adminOpenBet'=>$this->getOpenBetAdmins(0,$user_id)];
        return $this->response(0, $msg1, ['delItem'=>$delPlacedBet,'note'=>$note]);
    }
//rest
    public function getLiabilityOfMarket($market_id, $user_id)
    {
        $runners = DB::table('runners')->where('market_id', $market_id)->get();
        foreach ($runners as $item) {
            $li_item = DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', $item->id], ['betslip.user_id', $user_id], ['betslip.state', 1], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id], ['betslip.is_matched', 'true']])
                    ->sum('profit_amount')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', $item->id], ['betslip.user_id', $user_id], ['betslip.state', 1], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', $item->id], ['betslip.user_id', $user_id], ['betslip.state', 1], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', $item->id], ['betslip.user_id', $user_id], ['betslip.state', 1], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id], ['betslip.is_matched', 'true']])
                    ->sum('profit_amount');
            /*DB::table('user_profit')->updateOrInsert(['market_id' => $market_id,'runner_id'=>$item->id,'user_id'=>$user_id], ['market_id' => $market_id,'runner_id'=>$item->id,'liability'=>$li_item,'user_id'=>$user_id]);*/
            $liability[] = $li_item;
        }
        $liability = min($liability);
        if ($liability>0)$liability=0;
        return $liability;
    }

    public function getLiabilityOfMarketOfMatched($market_id, $user_id, $is_matched)
    {
        $runners = DB::table('runners')->where('market_id', $market_id)->get();
        foreach ($runners as $item) {
            $li_item = DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', $item->id], ['betslip.user_id', $user_id], ['betslip.state', 1], ['betslip.is_matched', $is_matched], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('profit_amount')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', $item->id], ['betslip.user_id', $user_id], ['betslip.state', 1], ['betslip.is_matched', $is_matched], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', $item->id], ['betslip.user_id', $user_id], ['betslip.state', 1], ['betslip.is_matched', $is_matched], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', $item->id], ['betslip.user_id', $user_id], ['betslip.state', 1], ['betslip.is_matched', $is_matched], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('profit_amount');
            if ($is_matched == 'true') {
                DB::table('user_profit')->updateOrInsert(['market_id' => $market_id, 'runner_id' => $item->id, 'user_id' => $user_id], ['market_id' => $market_id, 'runner_id' => $item->id, 'liability' => $li_item, 'user_id' => $user_id]);
            }

            $liability[] = $li_item;
        }
        $liability = min($liability);
        if ($liability>0)$liability=0;
        return $liability;
    }

    public function getMatched($betslip_id, $odd)
    {
        $res = 'true';
        $runner = DB::table('runners')->join('betslip', 'betslip.runner_id', 'runners.id')->where([['betslip.id', $betslip_id]])->select('betslip.bet_type', 'runners.availableToBack', 'runners.availableToLay')->first();
        if ($runner->bet_type == 'availableToBack') {
            $values = json_decode($runner->availableToBack);
            $odds = array();
            foreach ($values as $value) {
                $odds[] = $value->price;
            }
            if ($odd > max($odds)) {
                $res = 'false';
            }
            $betslip_item=DB::table('betslip')->where('id',$betslip_id)->first();
            $is_possible=DB::table('betslip')->where([['runner_id',$betslip_item->runner_id],['odd','<',$betslip_item->odd],['user_id',$betslip_item->user_id],['is_matched','false'],['state',1],['bet_type',$betslip_item->bet_type]])->get();
            if (count($is_possible)>0)return 'false';
        } else {
            $values = json_decode($runner->availableToLay);
            $odds = array();
            foreach ($values as $value) {
                $odds[] = $value->price;
            }
            if ($odd < min($odds)) {
                $res = 'false';
            }
            $betslip_item=DB::table('betslip')->where('id',$betslip_id)->first();
            $is_possible=DB::table('betslip')->where([['runner_id',$betslip_item->runner_id],['odd','>',$betslip_item->odd],['user_id',$betslip_item->user_id],['is_matched','false'],['state',1],['bet_type',$betslip_item->bet_type]])->get();
            if (count($is_possible)>0)return 'false';
        }

        $is_possible=DB::table('betslip')->where([['runner_id',$betslip_item->runner_id],['odd',$betslip_item->odd],['id','<',$betslip_id],['user_id',$betslip_item->user_id],['is_matched','false'],['state',1],['bet_type',$betslip_item->bet_type]])->get();
        if (count($is_possible)>0)return 'false';
        return $res;
    }

    public function getMaxVolume($betslip_id)
    {
        $res = 0;
        $runner = DB::table('runners')->join('betslip', 'betslip.runner_id', 'runners.id')->where([['betslip.id', $betslip_id]])->select('betslip.bet_type', 'betslip.odd', 'runners.availableToBack', 'runners.availableToLay')->first();
        if ($runner->bet_type == 'availableToBack') {
            $values = json_decode($runner->availableToBack);
            $odds = array();
            foreach ($values as $value) {
                /* if ($runner->odd<$value->price){
                     return -1;
                 }*/
                $res = $value->size;
                return $res;
            }
            //$res=max($odds);
            return $res;
        } else {
            $values = json_decode($runner->availableToLay);
            $odds = array();
            foreach ($values as $value) {
                if ($runner->odd == $value->price) {
                    return $value->size;
                }
                $odds[] = $value->price;
                return $value->size;
            }
            //$res=max($odds);
        }
        return $res;
    }

    public function setProfitExposure($betSlipId)
    {
        $betslip = DB::table('betslip')->where('id', $betSlipId)->first();
        if ($betslip->bet_type == "availableToBack") {
            $exposure = -$betslip->stake;
            $p_profit = $betslip->odd * $betslip->stake - $betslip->stake;
        } else {
            $exposure = -($betslip->odd * $betslip->stake - $betslip->stake);
            $p_profit = $betslip->stake;
        }
        DB::table('betslip')->where('id', $betSlipId)->update(['profit_amount' => $p_profit, 'exposure' => $exposure]);
    }

    public function getUpLineAdminIds($user_id)
    {
        $user = DB::table('users')->where([['id', $user_id]])->first();
        //return json_encode($user);
        if (empty($user)) return $this->response(0, 'can not user' , '');
        $admins = array();
        $parentId = $user->parent_id;
        $user->admin = array();
        $user->super_master = array();
        $user->master = array();
        $admin_ids = [];
        while (true) {
            $rootAdmin = DB::table('admins')->where('id', $parentId)->first();
            $admin_ids[] = $rootAdmin->id;
            $parentId = $rootAdmin->parent_id;
            if ($parentId == 0) break;
        }
        return $admin_ids;
    }

    public function getSportOfRunner($runner_id)
    {
        $sport_id = DB::table('runners')->join('markets', 'markets.id', 'runners.market_id')->join('events', 'events.id', 'markets.event_id')->join('sport_names', 'sport_names.import_id', 'events.sport_id')->where('runners.id', $runner_id)->value('sport_names.id');
        return $sport_id;
    }

    public function getRunnerName($runner_id)
    {
        return DB::table('runners')->where('id', $runner_id)->value('runnerName');
    }
    public function isBet($user_id){
        $user=User::find($user_id);
        if ($user->state=='LockAccount') return 1;
        if ($user->state=='LockBet') return 1;
        $parentId=$user->parent_id;
        while (true) {
            $rootAdmin = DB::table('admins')->where('id', $parentId)->first();
            if ($rootAdmin->state=='LockAccount') return 1;
            if ($rootAdmin->state=='LockBet') return 1;
            if ($rootAdmin->is_super == 0) break;
            $parentId = $rootAdmin->parent_id;
            //if ($parentId == 2) break;
        }
        return 0;
    }
    public function getMaxLiabilityOfSession(){
        $runner_id=\request('runner_id');
        $user_id=\request('user_id');
        $user_type=\request('user_type');
        $res=$this->maxLiabilityOfSession($runner_id,$user_id,$user_type);
        return $this->response(0,'get liability of session'.$user_type,$res);

    }
    public function getFancyRunnerPositionAdmins($runner_id,$user_id){
        $adminIds=$this->getUpLineAdminIds($user_id);
        $res=array();
        $res=array();
        foreach ($adminIds as $adminId){
            $profit = $this->maxLiabilityOfSession($runner_id,$adminId,'admins');
            $res[$adminId]=['runner_id'=>$runner_id,'position'=>$profit];
        }
        return $res;
    }
    public function maxLiabilityOfSession($runner_id,$user_id,$user_type){
        if ($user_type=='users'){
            $profits=array();
            $filter=[];
            $filter[]=['runner_id',$runner_id];
            $filter[]=['user_id',$user_id];
            $filter[]=['state',1];
            $min_rate=DB::table('betslip')->where($filter)->min('rate');
            $max_rate=DB::table('betslip')->where($filter)->max('rate');
            //return $max_rate;
            $start=$min_rate==0?0:$min_rate-1;
            $end=$max_rate+1;
            //return $end;
            for ($number=$start;$number<=$end;$number++){
                $profit=DB::table('betslip')->where([['bet_type','availableToBack'],['rate','>',$number]])->where($filter)
                        ->sum('exposure')
                    +DB::table('betslip')->where([['bet_type','availableToBack'],['rate','<=',$number]])->where($filter)
                        ->sum('profit_amount')
                    +DB::table('betslip')->where([['bet_type','availableToLay'],['rate','>',$number]])->where($filter)
                        ->sum('profit_amount')
                    +DB::table('betslip')->where([['bet_type','availableToLay'],['rate','<=',$number]])->where($filter)
                        ->sum('exposure');
                $profits[]=$profit;
            }

            return min($profits);
        }
        else{
            $profits=array();

            $user_ids = $this->getUsersOfAdmin($user_id);
            //return $max_rate;
            $min_rate=DB::table('betslip')->where([['runner_id',$runner_id],['state',1]])->whereIn('user_id',$user_ids)->min('rate');
            $max_rate=DB::table('betslip')->where([['runner_id',$runner_id],['state',1]])->whereIn('user_id',$user_ids)->max('rate');
            $start=$min_rate==0?0:$min_rate-1;
            $end=$max_rate+1;
            for ($number=$start;$number<=$end;$number++){
                //return $end;
                $total_profit=0;
                foreach ($user_ids as $c_user_id){
                    $filter=[];
                    $filter[]=['runner_id',$runner_id];
                    $filter[]=['user_id',$c_user_id];
                    $filter[]=['state',1];
                    $profit=DB::table('betslip')->where([['bet_type','availableToBack'],['rate','>',$number]])->where($filter)
                            ->sum('exposure')
                        +DB::table('betslip')->where([['bet_type','availableToBack'],['rate','<=',$number]])->where($filter)
                            ->sum('profit_amount')
                        +DB::table('betslip')->where([['bet_type','availableToLay'],['rate','>',$number]])->where($filter)
                            ->sum('profit_amount')
                        +DB::table('betslip')->where([['bet_type','availableToLay'],['rate','<=',$number]])->where($filter)
                            ->sum('exposure');
                    $total_profit+=$profit*$this->getPartnerShip($user_id, $c_user_id);

                }
                $profits[]=-$total_profit;
            }

            return min($profits);
        }
    }
    //rest
    public function getScoreBook(){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $runner_id=\request('runner_id');
        $user_id=\request('user_id');
        $user_type=\request('user_type');
        $scoreBook=$this->scoreBook($runner_id,$user_id,$user_type);
        return $this->response(0,'get scoreBooks',$scoreBook);

    }
    private function scoreBook($runner_id,$user_id,$user_type){
        if ($user_type=='users'){
            $profits=array();
            $filter=[];
            $filter[]=['runner_id',$runner_id];
            $filter[]=['user_id',$user_id];
            $filter[]=['state',1];
            $min_rate=DB::table('betslip')->where($filter)->min('rate');
            $max_rate=DB::table('betslip')->where($filter)->max('rate');
            //return $max_rate;
            $start=$min_rate==0?0:$min_rate-1;
            $end=$max_rate+1;
            //return $end;
            for ($number=$start;$number<=$end;$number++){
                $profit=DB::table('betslip')->where([['bet_type','availableToBack'],['rate','>',$number]])->where($filter)
                        ->sum('exposure')
                    +DB::table('betslip')->where([['bet_type','availableToBack'],['rate','<=',$number]])->where($filter)
                        ->sum('profit_amount')
                    +DB::table('betslip')->where([['bet_type','availableToLay'],['rate','>',$number]])->where($filter)
                        ->sum('profit_amount')
                    +DB::table('betslip')->where([['bet_type','availableToLay'],['rate','<=',$number]])->where($filter)
                        ->sum('exposure');
                $profits[]=['rate'=>$number,'profit'=>$profit];
            }

            return $profits;
        }
        else{
            $profits=array();

            $user_ids = $this->getUsersOfAdmin($user_id);
            //return $max_rate;
            $min_rate=DB::table('betslip')->where([['runner_id',$runner_id],['state',1]])->whereIn('user_id',$user_ids)->min('rate');
            $max_rate=DB::table('betslip')->where([['runner_id',$runner_id],['state',1]])->whereIn('user_id',$user_ids)->max('rate');
            $start=$min_rate==0?0:$min_rate-1;
            $end=$max_rate+1;
            for ($number=$start;$number<=$end;$number++){
                //return $end;
                $total_profit=0;
                foreach ($user_ids as $c_user_id){
                    $filter=[];
                    $filter[]=['runner_id',$runner_id];
                    $filter[]=['user_id',$c_user_id];
                    $filter[]=['state',1];
                    $profit=DB::table('betslip')->where([['bet_type','availableToBack'],['rate','>',$number]])->where($filter)
                            ->sum('exposure')
                        +DB::table('betslip')->where([['bet_type','availableToBack'],['rate','<=',$number]])->where($filter)
                            ->sum('profit_amount')
                        +DB::table('betslip')->where([['bet_type','availableToLay'],['rate','>',$number]])->where($filter)
                            ->sum('profit_amount')
                        +DB::table('betslip')->where([['bet_type','availableToLay'],['rate','<=',$number]])->where($filter)
                            ->sum('exposure');
                    $total_profit+=$profit*$this->getPartnerShip($user_id, $c_user_id);

                }
                $profits[]=['rate'=>$number,'profit'=>-$total_profit];
            }

            return $profits;
        }
    }
    public function getLiabilityOfSession($runner_id,$user_id){
        $profits=array();
        $filter=[];
        $filter[]=['runner_id',$runner_id];
        $filter[]=['user_id',$user_id];
        $filter[]=['state',1];
        $min_rate=DB::table('betslip')->where($filter)->min('rate');
        $max_rate=DB::table('betslip')->where($filter)->max('rate');
        $start=$min_rate==0?0:$min_rate-1;
        $end=$max_rate+1;
        //return $end;
        for ($number=$start;$number<=$end;$number++){
            $profit=DB::table('betslip')->where([['bet_type','availableToBack'],['rate','>',$number]])->where($filter)
                    ->sum('exposure')
                +DB::table('betslip')->where([['bet_type','availableToBack'],['rate','<=',$number]])->where($filter)
                    ->sum('profit_amount')
                +DB::table('betslip')->where([['bet_type','availableToLay'],['rate','>',$number]])->where($filter)
                    ->sum('profit_amount')
                +DB::table('betslip')->where([['bet_type','availableToLay'],['rate','<=',$number]])->where($filter)
                    ->sum('exposure');
            $profits[]=$profit;
        }
        $profit=min($profits);
        $profit=$profit>0?0:$profit;
        return $profit;
    }
    public function getMaxProfitOfSession($runner_id,$user_id){
        $profits=array();
        $filter=[];
        $filter[]=['runner_id',$runner_id];
        $filter[]=['user_id',$user_id];
        $filter[]=['state',1];
        $min_rate=DB::table('betslip')->where($filter)->min('rate');
        $max_rate=DB::table('betslip')->where($filter)->max('rate');
        $start=$min_rate==0?0:$min_rate-1;
        $end=$max_rate+1;
        //return $end;
        for ($number=$start;$number<=$end;$number++){
            $profit=DB::table('betslip')->where([['bet_type','availableToBack'],['rate','>',$number]])->where($filter)
                    ->sum('exposure')
                +DB::table('betslip')->where([['bet_type','availableToBack'],['rate','<=',$number]])->where($filter)
                    ->sum('profit_amount')
                +DB::table('betslip')->where([['bet_type','availableToLay'],['rate','>',$number]])->where($filter)
                    ->sum('profit_amount')
                +DB::table('betslip')->where([['bet_type','availableToLay'],['rate','<=',$number]])->where($filter)
                    ->sum('exposure');
            $profits[]=$profit;
        }
        $profit=max($profits);
        //$profit=$profit>0?0:$profit;
        return $profit;
    }
    public function getProfitOfScore($runner_id,$user_id,$score){
        $filter=[];
        $filter[]=['runner_id',$runner_id];
        $filter[]=['user_id',$user_id];
        $filter[]=['state',1];
        $profit=DB::table('betslip')->where([['bet_type','availableToBack'],['rate','>',$score]])->where($filter)
                ->sum('exposure')
            +DB::table('betslip')->where([['bet_type','availableToBack'],['rate','<=',$score]])->where($filter)
                ->sum('profit_amount')
            +DB::table('betslip')->where([['bet_type','availableToLay'],['rate','>',$score]])->where($filter)
                ->sum('profit_amount')
            +DB::table('betslip')->where([['bet_type','availableToLay'],['rate','<=',$score]])->where($filter)
                ->sum('exposure');
        return $profit;
    }
    public function confirmBetSlip1(Request $request)
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $isBet=$this->isBet($request->user_id);
        if ($isBet==1){
            return $this->response(1, 'You cannot place bets, as your betting is locked', null);
        }
        if ((float)$request->odd == 0) {
            return $this->response(1, 'You can not bet. Invalid odd', null);
        }
        DB::table('betslip')->where([['user_id',$request->user_id],['state',0]])->delete();
        $market_id = DB::table('runners')->where('id', $request->runner_id)->value('market_id');

        $isDownMarket=DB::table('markets')->where('id',$market_id)->value('marketStatus');
        if ($isDownMarket=='CLOSED'){
            return $this->response(1, 'Market Closed Already '.$market_id, '');
        }

        $inPlay=DB::table('markets')->where('id', $market_id)->value('inPlay');

        if ((float)$request->stake == 0) {
            return $this->response(1, 'Please enter stake', $market_id);
        }

        $isMarketsWorks=DB::table('user_markets')->where([['market_id',$market_id],['user_id',$request->user_id]])->first();
        if (!isset($isMarketsWorks)){
            DB::table('user_markets')->insert(['market_id'=>$market_id,'user_id'=>$request->user_id,'is_work'=>1]);
        }
        else{
            if ($isMarketsWorks->is_work==1){
                //DB::table('user_markets')->where([['market_id',$market_id],['user_id',$request->user_id]])->update(['is_work'=>0,'action'=>'placed betslip']);
                return $this->response(1, 'You can not bet, because another action, Please try later', null);
            }
        }
        DB::table('user_markets')->where([['market_id',$market_id],['user_id',$request->user_id]])->update(['is_work'=>1]);
        $marketType = DB::table('markets')->where('id', $market_id)->value('marketType');
        if ($marketType=='fancy'){
            $odd=json_decode(Runner::where('id',$request->runner_id)->value($request->bet_type))[0]->size/100+1;
            $rate=json_decode(Runner::where('id',$request->runner_id)->value($request->bet_type))[0]->price;
            $s_odd=$request->odd;
            $s_rate=$request->score;
            if ($odd!=$s_odd or $rate!=$s_rate){
                DB::table('user_markets')->where([['market_id',$market_id],['user_id',$request->user_id]])->update(['is_work'=>0]);
                return $this->response(1, 'Odd and Score updated, Plz try again'.$market_id, '');
            }
            $insert_data = [
                'user_id' => $request->user_id,
                'runner_id' => $request->runner_id,
                'bet_type' => $request->bet_type,
                'odd' => (float)$odd,
                'stake' => $request->stake,
                'rate' => (float)$rate,
                'is_work' => 2,
            ];
        }else{
            $insert_data = [
                'user_id' => $request->user_id,
                'runner_id' => $request->runner_id,
                'bet_type' => $request->bet_type,
                'odd' => (float)$request->odd,
                'stake' => $request->stake,
                'is_work' => 2,
            ];
        }
        $id = DB::table('betslip')->insertGetId($insert_data);
        $this->setProfitExposure($id);
        $betItem = DB::table('betslip')
            ->where('betslip.id', $id)
            ->first();

        //$volume=$this->getMaxVolume(\request('id'),$stake);
        $user_id = $betItem->user_id;
        ///////
        $marketType = DB::table('markets')->where('id', $market_id)->value('marketType');
        $note=array();
        $user = DB::table('users')->where('id', $user_id)->first();
        $s_manage=DB::table('market_management')->where('market_id',$market_id)->first();
        if (!isset($s_manage)){
            $s_id = $this->getSportOfRunner($betItem->runner_id);
            $s_manage = DB::table('sport_management')->where([['sport_id', $s_id], ['admin_id', $betItem->user_id], ['userType', 'users']])->first();
        }
        $stake=$request->stake;
        //return $this->response(1, $marketType, '');
        if ($marketType=='fancy'){
            //Stake condition of sport
            $odd=json_decode(Runner::where('id',$betItem->runner_id)->value($betItem->bet_type))[0]->size/100+1;
            $rate=json_decode(Runner::where('id',$betItem->runner_id)->value($betItem->bet_type))[0]->price;
            if ($odd==0 or $rate==0) {
                DB::table('betslip')->where('id', $betItem->id)->delete();
                DB::table('user_markets')->where([['market_id',$market_id],['user_id',$request->user_id]])->update(['is_work'=>0]);
                return $this->response(1, 'Can not placed bet', $user->wallet);
            }
            $runner=Runner::find($betItem->runner_id);
            if ($runner->runnerStatus){
                DB::table('betslip')->where('id', $betItem->id)->delete();
                DB::table('user_markets')->where([['market_id',$market_id],['user_id',$request->user_id]])->update(['is_work'=>0]);
                return $this->response(1, 'Can not placed bet, because Status', $user->wallet);
            }
            DB::table('betslip')
                ->where([['betslip.id', $betItem->id]])->update([ 'state' => 0,'odd' => (float)$odd, 'rate' => (float)$rate,]);


            $s_id = $this->getSportOfRunner($betItem->runner_id);
            $s_manage=DB::table('market_management')->where('market_id',$market_id)->first();
            if (isset($s_manage)){
                if ($s_manage->lockBet==1) {
                    DB::table('betslip')->where([['betslip.id', $betItem->id]])->delete();
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$request->user_id]])->update(['is_work'=>0]);
                    return $this->response(1, 'This sport was locked now.', $s_manage);
                }
                if ($stake < $s_manage->minStake) {
                    DB::table('betslip')->where([['betslip.id', $betItem->id]])->delete();
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$request->user_id]])->update(['is_work'=>0]);
                    return $this->response(1, 'Your stake can not be smaller than ' . $s_manage->minStake, $s_manage);
                }
                if ($stake > $s_manage->maxStake) {
                    DB::table('betslip')->where([['betslip.id', $betItem->id]])->delete();
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$request->user_id]])->update(['is_work'=>0]);
                    return $this->response(1, 'Your stake can not be greater than ' . $s_manage->maxStake, $s_manage);
                }
                DB::table('betslip')
                    ->where([['betslip.id', $betItem->id]])->update(['state' => 1]);
                $n_profit=$this->getMaxProfitOfSession($betItem->runner_id, $user_id) ;
                DB::table('betslip')
                    ->where([['betslip.id', $betItem->id]])->update(['state' => 0]);
                $c_profit=$this->getMaxProfitOfSession($betItem->runner_id, $user_id) ;
                if ($n_profit > $s_manage->maxProfit and $n_profit>$c_profit) {
                    DB::table('betslip')->where([['betslip.id', $betItem->id]])->delete();
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$request->user_id]])->update(['is_work'=>0]);
                    return $this->response(1, 'Your max profit can not be greater than ' . $s_manage->maxProfit, $s_manage);
                }
                DB::table('betslip')
                    ->where([['betslip.id', $betItem->id]])->update(['state' => 0]);
            }else{
                $s_manage = DB::table('sport_management')->where([['sport_id', $s_id], ['admin_id', $betItem->user_id], ['userType', 'users']])->first();
                if ($s_manage->f_lockBet==1) {
                    DB::table('betslip')->where([['betslip.id', $betItem->id]])->delete();
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$request->user_id]])->update(['is_work'=>0]);
                    return $this->response(1, 'This sport was locked now.', $s_manage);
                }
                if ($stake < $s_manage->f_minStake) {
                    DB::table('betslip')->where([['betslip.id', $betItem->id]])->delete();
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$request->user_id]])->update(['is_work'=>0]);
                    return $this->response(1, 'Your stake can not be smaller than ' . $s_manage->f_minStake, $s_manage);
                }
                if ($stake > $s_manage->f_maxStake) {
                    DB::table('betslip')->where([['betslip.id', $betItem->id]])->delete();
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$request->user_id]])->update(['is_work'=>0]);
                    return $this->response(1, 'Your stake can not be greater than ' . $s_manage->f_maxStake, $s_manage);
                }
                DB::table('betslip')
                    ->where([['betslip.id', $betItem->id]])->update(['state' => 1]);
                $n_profit=$this->getMaxProfitOfSession($betItem->runner_id, $user_id) ;
                DB::table('betslip')
                    ->where([['betslip.id', $betItem->id]])->update(['state' => 0]);
                $c_profit=$this->getMaxProfitOfSession($betItem->runner_id, $user_id) ;
                if ($n_profit > $s_manage->f_profit and $n_profit>$c_profit) {
                    DB::table('betslip')->where([['betslip.id', $betItem->id]])->delete();
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$request->user_id]])->update(['is_work'=>0]);
                    return $this->response(1, 'Your max profit can not be greater than ' . $s_manage->maxProfit, $s_manage);
                }
                DB::table('betslip')
                    ->where([['betslip.id', $betItem->id]])->update(['state' => 0]);

            }
            /*if ($this->getMaxProfitOfSession($betItem->runner_id, $betItem->user_id) > $s_manage->f_profit) {
                DB::table('betslip')->where([['betslip.id', $betItem->id]])->delete();
                return $this->response(1, 'Your max profit can not be greater than ' . $s_manage->f_maxProfit, $s_manage);
            }*/
            DB::table('betslip')
                ->where([['betslip.id', $betItem->id]])->update([ 'state' => 0]);
            $old_liability=$this->getLiabilityOfSession($betItem->runner_id,$betItem->user_id);
            DB::table('betslip')
                ->where([['betslip.id', $betItem->id]])->update([ 'state' => 1]);
            $liability=$this->getLiabilityOfSession($betItem->runner_id,$betItem->user_id);
            DB::table('betslip')
                ->where([['betslip.id', $betItem->id]])->update([ 'state' => 0]);
            $f_wallet = $user->wallet-$old_liability+$liability;
            //return $this->response(1, $f_wallet, $user->wallet);


            if ($f_wallet+$user->pAndL+$user->comAmount+$user->cash < 0) {
                DB::table('betslip')->where('id', $betItem->id)->delete();
                DB::table('user_markets')->where([['market_id',$market_id],['user_id',$request->user_id]])->update(['is_work'=>0]);
                return $this->response(1, 'Your Balance is small for bet. Please deposit' . ($f_wallet+$user->pAndL+$user->comAmount+$user->cash) . ' more', $user->wallet);
            }

            $msg = 'Your bet placed successfully'.$old_liability.$liability.'::'.$f_wallet;

            DB::table('users')->where('id', $user_id)->update(['wallet' => $f_wallet]);
            $old_exposure=$user->exposure;
            $user->exposure = $user->exposure -$old_liability+$liability;
            if ($user->exposure>0)$user->exposure=0;
            DB::table('users')->where('id', $user_id)->update(['exposure' => $user->exposure]);
            DB::table('liability_log')->insert(['user_id'=>$user->id,'wallet'=>$user->wallet,'exposure'=>$user->exposure,'old_liability'=>$old_liability,'n_liability'=>$liability,'old_exposure'=>$old_exposure,'t_id'=>$betItem->id,'action'=>'fancy placed']);
            $msg1 = 'FancyBet:' . $user->email . ' runner:' . $this->getRunnerName($betItem->runner_id) . ' BetType' . $betItem->bet_type . ',Odds:' . $betItem->odd . ', Stake:' . $betItem->stake;
            //$firebase->SendNotification('placedBet', ['bet_item' => $betItem, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($user_id), 'market_id' => $market_id]);
            DB::table('betslip')
                ->where([['betslip.id', $betItem->id]])->update(['state' => 1, 'volume' => 'none']);
            $note[]=['bet_item' => $betItem, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($user_id), 'market_id' => $market_id,'userRunnerPosition'=>$this->getLiabilityOfSession($betItem->runner_id, $betItem->user_id),'adminRunnerPosition'=>$this->getFancyRunnerPositionAdmins($betItem->runner_id,$user_id),'openBets'=>$this->getOpenBet($user_id,0),'adminOpenBet'=>$this->getOpenBetAdmins(0,$user_id)];

            DB::table('user_markets')->where([['market_id',$market_id],['user_id',$request->user_id]])->update(['is_work'=>0]);
            return $this->response(0, $msg, $note);

        }
        ///////////
        //Stake condition of sport
        if ($stake < $s_manage->minStake) {
            DB::table('betslip')->where([['betslip.id', $betItem->id]])->delete();
            DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
            return $this->response(1, 'Your stake can not be smaller than ' . $s_manage->minStake, $s_manage);
        }
        if ($inPlay==0){//preInplayStake
            if ($stake > $s_manage->preInplayStake) {
                DB::table('betslip')->where([['betslip.id', $betItem->id]])->delete();
                DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                return $this->response(1, 'Your pre stake can not be greater than ' . $s_manage->preInplayStake, $s_manage);
            }
        }
        if ($stake > $s_manage->maxStake) {
            DB::table('betslip')->where([['betslip.id', $betItem->id]])->delete();
            DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
            return $this->response(1, $market_id.'Your stake can not be greater than ' . $s_manage->maxStake, $s_manage);
        }
        if ($s_manage->lockBet==1) {
            DB::table('betslip')->where([['betslip.id', $betItem->id]])->delete();
            DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
            return $this->response(1, 'This sport was locked now.', $s_manage);
        }
        //Stake condition of sport-----End

        $old_liability = $this->getLiabilityOfMarket($market_id, $user_id);
        if ($old_liability > 0) $old_liability = 0;
        //return $volume;
        DB::table('betslip')
            ->where([['betslip.id', $betItem->id]])->update(['is_matched' => 'true', 'state' => 1,'is_work'=>2, 'volume' => 'none']);
        $matched_liability = $this->getLiabilityOfMarket($market_id, $user_id);

        DB::table('betslip')
            ->where([['betslip.id', $betItem->id]])->update(['is_matched' => 'false', 'state' => 0, 'volume' => 'none']);
        $f_wallet = $user->wallet - $old_liability + $matched_liability;
        //return $this->response(1, $f_wallet, $user->wallet);


        if ($f_wallet+$user->pAndL+$user->comAmount+$user->cash < 0) {
            DB::table('betslip')->where('id', $betItem->id)->delete();
            DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
            return $this->response(1, 'Your Balance is small for bet. Please deposit' . ($f_wallet+$user->pAndL+$user->comAmount+$user->cash) . ' more', $user->wallet);
        }
        //maxProfit condition
        if ($inPlay==0) {//preInplayStake
            DB::table('betslip')
                ->where([['betslip.id', $betItem->id]])->update(['is_matched' => 'true', 'state' => 1, 'volume' => 'none']);
            $n_profit=$this->getMaxProfitOfMarket($market_id, $user_id);
            DB::table('betslip')
                ->where([['betslip.id', $betItem->id]])->update(['is_matched' => 'true', 'state' => 0, 'volume' => 'none']);
            $c_profit=$this->getMaxProfitOfMarket($market_id, $user_id);
            if ($n_profit > $s_manage->preInplayProfit and $n_profit>$c_profit) {
                DB::table('betslip')->where([['betslip.id', $betItem->id]])->delete();
                DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                return $this->response(1, 'Your max pre profit can not be greater than ' . $s_manage->preInplayProfit, $s_manage);
            }

        }
        DB::table('betslip')
            ->where([['betslip.id', $betItem->id]])->update(['is_matched' => 'true', 'state' => 1, 'volume' => 'none']);
        $n_profit=$this->getMaxProfitOfMarket($market_id, $user_id);
        DB::table('betslip')
            ->where([['betslip.id', $betItem->id]])->update(['is_matched' => 'true', 'state' => 0, 'volume' => 'none']);
        $c_profit=$this->getMaxProfitOfMarket($market_id, $user_id);
        if ($n_profit > $s_manage->maxProfit and $n_profit>$c_profit) {
            DB::table('betslip')->where([['betslip.id', $betItem->id]])->delete();
            DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
            return $this->response(1, 'Your max profit can not be greater than ' . $s_manage->maxProfit, $s_manage);
        }
        DB::table('betslip')
            ->where([['betslip.id', $betItem->id]])->update(['is_matched' => 'true', 'state' => 0, 'volume' => 'none']);
        //maxProfit Condition End
        if ($this->getMatched($betItem->id, $betItem->odd) == 'false') {
            //unmatched
            //unmatched Check
            if ($s_manage->unMatched == 0) {
                DB::table('betslip')->where('id', $betItem->id)->delete();
                DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                return $this->response(1, 'You can not placed bet for unmatched bet now', $user->wallet);
            }
            DB::table('betslip')
                ->where([['betslip.id', $betItem->id]])->update(['is_matched' => 'false', 'state' => 1]);
            DB::table('betslip')->where('id', $betItem->id)->update(['is_work'=>1]);
            $this->setProfitExposure($betItem->id);
            $matched_liability=$matched_liability = $this->getLiabilityOfMarket($market_id, $user_id);
            $msg = 'Your bet placed successfully0';
            DB::table('users')->where('id', $user_id)->update(['wallet' => $f_wallet]);
            $old_exposure=$user->exposure;
            $user->exposure = $user->exposure - $old_liability + $matched_liability;
            if ($user->exposure>0)$user->exposure=0;
            DB::table('users')->where('id', $user_id)->update(['exposure' => $user->exposure]);
            DB::table('liability_log')->insert(['user_id'=>$user->id,'wallet'=>$user->wallet,'exposure'=>$user->exposure,'old_liability'=>$old_liability,'n_liability'=>$matched_liability,'old_exposure'=>$old_exposure,'t_id'=>$betItem->id,'action'=>'total unmatched bet placed']);
            if ($user->exposure>0)$user->exposure=0;
            $msg1 = 'Unmatched:' . $user->email . ' runner:' . $this->getRunnerName($betItem->runner_id) . ' BetType' . $betItem->bet_type . ',Odds:' . $betItem->odd . ', Stake:' . $betItem->stake;

            $note[]=['bet_item' => $betItem, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($user_id), 'market_id' => $market_id,'userRunnerPosition'=>$this->getRunnerPosition($market_id,$user_id),'adminRunnerPosition'=>$this->getRunnerPositionAdmins($market_id,$user_id),'openBets'=>$this->getOpenBet($user_id,0),'adminOpenBet'=>$this->getOpenBetAdmins(0,$user_id)];
            DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
            return $this->response(0, $msg, $note);


        }
        $runner = DB::table('runners')->join('betslip', 'betslip.runner_id', 'runners.id')->where([['betslip.id', $betItem->id]])->select('betslip.bet_type', 'betslip.odd', 'runners.availableToBack', 'runners.availableToLay')->first();
        //maxProfit condition
        DB::table('betslip')
            ->where([['betslip.id', $betItem->id]])->update(['is_matched' => 'true', 'state' => 0, 'volume' => 'none']);
        $c_profit=$this->getMaxProfitOfMarket($market_id, $user_id);
        $newBetIds=[];
        //maxProfit Condition End
        if ($runner->bet_type == 'availableToBack') {
            $values = json_decode($runner->availableToBack);
            $rest_stake = $betItem->stake;
            foreach ($values as $value) {
                $totalStake = DB::table('betslip')
                    ->where([['runner_id', $betItem->runner_id], ['bet_type', 'availableToBack'], ['odd', $value->price], ['id', '<>', $betItem->id], ['user_id', $betItem->user_id]])
                    ->sum('stake');
                if ($rest_stake == 0) continue;
                if ($value->size - $totalStake <= 0) continue;
                if ($value->price >= $betItem->odd) {
                    if ($value->size - $totalStake < $rest_stake && $value->size > $totalStake) {
                        $profit = ($value->size - $totalStake) * ($value->price - 1);
                        $exposure = -($value->size - $totalStake);
                        $id = DB::table('betslip')
                            ->insertGetId(['runner_id' => $betItem->runner_id, 'user_id' => $betItem->user_id, 'odd' => $value->price, 'bet_type' => 'availableToBack', 'stake' => $value->size - $totalStake, 'volume' => $betItem->volume, 'state' => 1, 'is_matched' => 'true', 'profit_amount' => $profit, 'exposure' => $exposure
                            ]);
                        $newBetIds[]=$id;
                        $newBet = DB::table('betslip')->where('id', $id)->first();
                        $msg1 = 'Matched:' . $user->email . 'runner:' . $this->getRunnerName($newBet->runner_id) . 'BetType' . $newBet->bet_type . ',Odds:' . $newBet->odd . ',Stake:' . $newBet->stake;

                        DB::table('betslip')->where('id', $betItem->id)->update(['state'=>0]);
                        $note[]=['bet_item' => $newBet, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($user_id), 'market_id' => $market_id,'userRunnerPosition'=>$this->getRunnerPosition($market_id,$user_id),'adminRunnerPosition'=>$this->getRunnerPositionAdmins($market_id,$user_id),'openBets'=>$this->getOpenBet($user_id,0),'adminOpenBet'=>$this->getOpenBetAdmins(0,$user_id)];
                        DB::table('betslip')->where('id', $betItem->id)->update(['state'=>1]);
                        $rest_stake -= $value->size - $totalStake;
                    } else if ($value->size > $totalStake) {
                        $profit = ($rest_stake) * ($value->price - 1);
                        $exposure = -($rest_stake);
                        $id = DB::table('betslip')
                            ->insertGetId(['runner_id' => $betItem->runner_id, 'user_id' => $betItem->user_id, 'odd' => $value->price, 'bet_type' => 'availableToBack', 'stake' => $rest_stake, 'volume' => $betItem->volume, 'state' => 1, 'is_matched' => 'true', 'profit_amount' => $profit, 'exposure' => $exposure
                            ]);
                        $newBetIds[]=$id;
                        $newBet = DB::table('betslip')->where('id', $id)->first();
                        $msg1 = 'Matched:' . $user->email . ' runner:' . $this->getRunnerName($newBet->runner_id) . ' BetType' . $newBet->bet_type . ', Odds:' . $newBet->odd . ', Stake:' . $newBet->stake;
                        //$firebase->SendNotification('placedBet', ['bet_item' => $newBet, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($user_id), 'market_id' => $market_id]);
                        //$this->setProfitExposure($betItem->id);
                        DB::table('betslip')->where('id', $betItem->id)->update(['state'=>0]);
                        $note[]=['bet_item' => $newBet, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($user_id), 'market_id' => $market_id,'userRunnerPosition'=>$this->getRunnerPosition($market_id,$user_id),'adminRunnerPosition'=>$this->getRunnerPositionAdmins($market_id,$user_id),'openBets'=>$this->getOpenBet($user_id,0),'adminOpenBet'=>$this->getOpenBetAdmins(0,$user_id)];
                        DB::table('betslip')->where('id', $betItem->id)->update(['state'=>1]);
                        $rest_stake = 0;
                    }
                }
            }
            DB::table('betslip')->where('stake', '<=', 0)->delete();
            if ($rest_stake > 0) {
                if ($s_manage->unMatched == 0) {
                    DB::table('betslip')->where('id', $betItem->id)->delete();

                    //maxProfit condition
                    $n_profit=$this->getMaxProfitOfMarket($market_id, $user_id);
                    if ($inPlay==0) {//preInplayStake
                        if ($n_profit > $s_manage->preInplayProfit and $n_profit>$c_profit) {
                            DB::table('betslip')->whereIn('betslip.id', $newBetIds)->delete();
                            DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                            return $this->response(1, 'Your profit is '.$n_profit.'. Your max pre profit can not be greater than ' . $s_manage->preInplayProfit, $s_manage);
                        }

                    }
                    if ($n_profit > $s_manage->maxProfit and $n_profit>$c_profit) {
                        DB::table('betslip')->whereIn('betslip.id', $newBetIds)->delete();
                        DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                        return $this->response(1, 'Your profit is '.$n_profit.'. Your max pre profit can not be greater than ' .$s_manage->maxProfit, $s_manage);
                    }
                    //maxProfit Condition End


                    $matched_liability = $this->getLiabilityOfMarket($market_id, $user_id);
                    $f_wallet = $user->wallet - $old_liability + $matched_liability;
                    DB::table('users')->where('id', $user_id)->update(['wallet' => $f_wallet]);
                    $old_exposure=$user->exposure;
                    $user->exposure = $user->exposure - $old_liability + $matched_liability;
                    if ($user->exposure>0)$user->exposure=0;
                    DB::table('users')->where('id', $user_id)->update(['exposure' => $user->exposure]);
                    DB::table('liability_log')->insert(['user_id'=>$user->id,'wallet'=>$user->wallet,'exposure'=>$user->exposure,'old_liability'=>$old_liability,'n_liability'=>$matched_liability,'old_exposure'=>$old_exposure,'t_id'=>$betItem->id,'action'=>'rest unmatched bet bet placed']);
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                    return $this->response(0, 'You can not placed bet for unmatched bet now', $note);
                }
                $profit = ($rest_stake) * ($values[0]->price - 1);
                $exposure = -($rest_stake);
                $id = DB::table('betslip')
                    ->insertGetId(['runner_id' => $betItem->runner_id, 'user_id' => $betItem->user_id, 'odd' => $values[0]->price, 'bet_type' => 'availableToBack', 'stake' => $rest_stake, 'volume' => json_encode($values[0]), 'state' => 1, 'is_matched' => 'false', 'profit_amount' => $profit, 'exposure' => $exposure,'is_work'=>1
                    ]);
                $newBetIds[]=$id;
                DB::table('betslip')->where('id', $betItem->id)->delete();
                //maxProfit condition
                $n_profit=$this->getMaxProfitOfMarket($market_id, $user_id);
                if ($inPlay==0) {//preInplayStake
                    if ($n_profit > $s_manage->preInplayProfit and $n_profit>$c_profit) {
                        DB::table('betslip')->whereIn('betslip.id', $newBetIds)->delete();
                        DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                        return $this->response(1, 'Your profit is '.$n_profit.'. Your max pre profit can not be greater than ' . $s_manage->preInplayProfit, $s_manage);
                    }

                }
                if ($n_profit > $s_manage->maxProfit and $n_profit>$c_profit) {
                    DB::table('betslip')->whereIn('betslip.id', $newBetIds)->delete();
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                    return $this->response(1, 'Your profit is '.$n_profit.'. Your max pre profit can not be greater than ' .$s_manage->maxProfit, $s_manage);
                }
                //maxProfit Condition End
                DB::table('betslip')->where('id', $id)->update(['is_work'=>1]);
                $newBet = DB::table('betslip')->where('id', $id)->first();
                $msg1 = 'UnMatched:' . $user->email . 'runner:' . $this->getRunnerName($newBet->runner_id) . 'BetType' . $newBet->bet_type . ',Odds:' . $newBet->odd . ',Stake:' . $newBet->stake;


                $note[]=['bet_item' => $newBet, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($user_id), 'market_id' => $market_id,'userRunnerPosition'=>$this->getRunnerPosition($market_id,$user_id),'adminRunnerPosition'=>$this->getRunnerPositionAdmins($market_id,$user_id),'openBets'=>$this->getOpenBet($user_id,0),'adminOpenBet'=>$this->getOpenBetAdmins(0,$user_id)];
                ////////////////////////////////////////////////////////

                $matched_liability = $this->getLiabilityOfMarket($market_id, $user_id);
                $f_wallet = $user->wallet - $old_liability + $matched_liability;
                DB::table('users')->where('id', $user_id)->update(['wallet' => $f_wallet]);
                $old_exposure=$user->exposure;
                $user->exposure = $user->exposure - $old_liability + $matched_liability;
                if ($user->exposure>0)$user->exposure=0;
                DB::table('users')->where('id', $user_id)->update(['exposure' => $user->exposure]);
                DB::table('liability_log')->insert(['user_id'=>$user->id,'wallet'=>$user->wallet,'exposure'=>$user->exposure,'old_liability'=>$old_liability,'n_liability'=>$matched_liability,'old_exposure'=>$old_exposure,'t_id'=>$betItem->id,'action'=>'bet placed']);
                DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                return $this->response(0, 'Placed successfully', $note);
            }
            DB::table('betslip')->where('id', $betItem->id)->delete();
            //maxProfit condition
            $n_profit=$this->getMaxProfitOfMarket($market_id, $user_id);
            if ($inPlay==0) {//preInplayStake
                if ($n_profit > $s_manage->preInplayProfit and $n_profit>$c_profit) {
                    DB::table('betslip')->whereIn('betslip.id', $newBetIds)->delete();
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                    return $this->response(1, 'Your profit is '.$n_profit.'. Your max pre profit can not be greater than ' . $s_manage->preInplayProfit, $s_manage);
                }

            }
            if ($n_profit > $s_manage->maxProfit and $n_profit>$c_profit) {
                DB::table('betslip')->whereIn('betslip.id', $newBetIds)->delete();
                DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                return $this->response(1, 'Your profit is '.$n_profit.'. Your max pre profit can not be greater than ' .$s_manage->maxProfit, $s_manage);
            }
            //maxProfit Condition End
            $matched_liability = $this->getLiabilityOfMarket($market_id, $user_id);
            $f_wallet = $user->wallet - $old_liability + $matched_liability;
            DB::table('users')->where('id', $user_id)->update(['wallet' => $f_wallet]);
            $old_exposure=$user->exposure;
            $user->exposure = $user->exposure - $old_liability + $matched_liability;
            if ($user->exposure>0)$user->exposure=0;
            DB::table('users')->where('id', $user_id)->update(['exposure' => $user->exposure]);
            DB::table('liability_log')->insert(['user_id'=>$user->id,'wallet'=>$user->wallet,'exposure'=>$user->exposure,'old_liability'=>$old_liability,'n_liability'=>$matched_liability,'old_exposure'=>$old_exposure,'t_id'=>$betItem->id,'action'=>'total matched back bet placed']);
            DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
            return $this->response(0, 'Placed successfully', $note);
        } else {
            $values = json_decode($runner->availableToLay);
            $rest_stake = $betItem->stake;
            foreach ($values as $value) {
                $totalStake = DB::table('betslip')
                    ->where([['runner_id', $betItem->runner_id], ['bet_type', 'availableToLay'], ['odd', $value->price], ['id', '<>', $betItem->id], ['user_id', $betItem->user_id]])
                    ->sum('stake');
                if ($rest_stake == 0) continue;
                if ($value->size - $totalStake <= 0) continue;
                if ($value->price <= $betItem->odd) {
                    if ($value->size - $totalStake < $rest_stake && $value->size > $totalStake) {
                        $exposure = -($value->size - $totalStake) * ($value->price - 1);
                        $profit = ($value->size - $totalStake);
                        $id = DB::table('betslip')
                            ->insertGetId(['runner_id' => $betItem->runner_id, 'user_id' => $betItem->user_id, 'odd' => $value->price, 'bet_type' => 'availableToLay', 'stake' => $value->size, 'volume' => $betItem->volume, 'state' => 1, 'is_matched' => 'true', 'profit_amount' => $profit, 'exposure' => $exposure
                            ]);
                        $newBetIds[]=$id;
                        $newBet = DB::table('betslip')->where('id', $id)->first();
                        $msg1 = 'Matched:' . $user->email . 'runner:' . $this->getRunnerName($newBet->runner_id) . 'BetType' . $newBet->bet_type . ',Odds:' . $newBet->odd . ',Stake:' . $newBet->stake;
                        //$firebase->SendNotification('placedBet', ['bet_item' => $newBet, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($user_id), 'market_id' => $market_id]);
                        DB::table('betslip')->where('id', $betItem->id)->update(['state'=>0]);
                        $note[]=['bet_item' => $newBet, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($user_id), 'market_id' => $market_id,'userRunnerPosition'=>$this->getRunnerPosition($market_id,$user_id),'adminRunnerPosition'=>$this->getRunnerPositionAdmins($market_id,$user_id),'openBets'=>$this->getOpenBet($user_id,0),'adminOpenBet'=>$this->getOpenBetAdmins(0,$user_id)];
                        DB::table('betslip')->where('id', $betItem->id)->update(['state'=>1]);
                        $rest_stake -= $value->size - $totalStake;
                    } else if ($value->size > $totalStake) {
                        $exposure = -($rest_stake) * ($value->price - 1);
                        $profit = ($rest_stake);
                        $id = DB::table('betslip')
                            ->insertGetId(['runner_id' => $betItem->runner_id, 'user_id' => $betItem->user_id, 'odd' => $value->price, 'bet_type' => 'availableToLay', 'stake' => $rest_stake, 'volume' => $betItem->volume, 'state' => 1, 'is_matched' => 'true', 'profit_amount' => $profit, 'exposure' => $exposure
                            ]);
                        $newBetIds[]=$id;
                        $this->setProfitExposure($betItem->id);
                        $newBet = DB::table('betslip')->where('id', $id)->first();
                        $msg1 = 'Matched:' . $user->email . 'runner:' . $this->getRunnerName($newBet->runner_id) . 'BetType' . $newBet->bet_type . ',Odds:' . $newBet->odd . ',Stake:' . $newBet->stake;
                        //$firebase->SendNotification('placedBet', ['bet_item' => $newBet, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($user_id), 'market_id' => $market_id]);
                        DB::table('betslip')->where('id', $betItem->id)->update(['state'=>0]);
                        $note[]=['bet_item' => $newBet, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($user_id), 'market_id' => $market_id,'userRunnerPosition'=>$this->getRunnerPosition($market_id,$user_id),'adminRunnerPosition'=>$this->getRunnerPositionAdmins($market_id,$user_id),'openBets'=>$this->getOpenBet($user_id,0),'adminOpenBet'=>$this->getOpenBetAdmins(0,$user_id)];
                        DB::table('betslip')->where('id', $betItem->id)->update(['state'=>1]);
                        $rest_stake = 0;
                    }
                }

            }
            DB::table('betslip')->where('stake', '<=', 0)->delete();
            if ($rest_stake > 0) {
                if ($s_manage->unMatched == 0) {
                    DB::table('betslip')->where('id', $betItem->id)->delete();

                    //maxProfit condition
                    $n_profit=$this->getMaxProfitOfMarket($market_id, $user_id);
                    if ($inPlay==0) {//preInplayStake
                        if ($n_profit > $s_manage->preInplayProfit and $n_profit>$c_profit) {
                            DB::table('betslip')->whereIn('betslip.id', $newBetIds)->delete();
                            DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                            return $this->response(1, 'Your profit is '.$n_profit.'. Your max pre profit can not be greater than ' . $s_manage->preInplayProfit, $s_manage);
                        }

                    }
                    if ($n_profit > $s_manage->maxProfit and $n_profit>$c_profit) {
                        DB::table('betslip')->whereIn('betslip.id', $newBetIds)->delete();
                        DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                        return $this->response(1, 'Your profit is '.$n_profit.'. Your max pre profit can not be greater than ' .$s_manage->maxProfit, $s_manage);
                    }
                    //maxProfit Condition End
                    $matched_liability = $this->getLiabilityOfMarket($market_id, $user_id);
                    $f_wallet = $user->wallet - $old_liability + $matched_liability;
                    DB::table('users')->where('id', $user_id)->update(['wallet' => $f_wallet]);
                    $old_exposure=$user->exposure;
                    $user->exposure = $user->exposure - $old_liability + $matched_liability;
                    if ($user->exposure>0)$user->exposure=0;
                    DB::table('users')->where('id', $user_id)->update(['exposure' => $user->exposure]);
                    DB::table('liability_log')->insert(['user_id'=>$user->id,'wallet'=>$user->wallet,'exposure'=>$user->exposure,'old_liability'=>$old_liability,'n_liability'=>$matched_liability,'old_exposure'=>$old_exposure,'t_id'=>$betItem->id,'action'=>'lay1 bet placed']);
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                    return $this->response(0, 'You can not placed bet for unmatched bet now', $note);
                }
                $exposure = -($rest_stake) * ($values[0]->price - 1);
                $profit = ($rest_stake);
                $id = DB::table('betslip')
                    ->insertGetId(['runner_id' => $betItem->runner_id, 'user_id' => $betItem->user_id, 'odd' => $values[0]->price, 'bet_type' => 'availableToLay', 'stake' => $rest_stake, 'volume' => json_encode($values[0]), 'state' => 1, 'is_matched' => 'false', 'profit_amount' => $profit, 'exposure' => $exposure,'is_work'=>1
                    ]);
                $newBetIds[]=$id;
                DB::table('betslip')->where('id', $betItem->id)->delete();
                //maxProfit condition
                $n_profit=$this->getMaxProfitOfMarket($market_id, $user_id);
                if ($inPlay==0) {//preInplayStake
                    if ($n_profit > $s_manage->preInplayProfit and $n_profit>$c_profit) {
                        DB::table('betslip')->whereIn('betslip.id', $newBetIds)->delete();
                        DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                        return $this->response(1, 'Your profit is '.$n_profit.'. Your max pre profit can not be greater than ' . $s_manage->preInplayProfit, $s_manage);
                    }

                }
                if ($n_profit > $s_manage->maxProfit and $n_profit>$c_profit) {
                    DB::table('betslip')->whereIn('betslip.id', $newBetIds)->delete();
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                    return $this->response(1, 'Your profit is '.$n_profit.'. Your max pre profit can not be greater than ' .$s_manage->maxProfit, $s_manage);
                }
                //maxProfit Condition End
                DB::table('betslip')->where('id', $id)->update(['is_work'=>1]);
                //$firebase->SendNotification('placedBet', ['bet_item' => DB::table('betslip')->where('id', $id)->first(), 'msg' => $user->email . ' have place unmatched bet just now', 'admins' => $this->getUpLineAdminIds($user_id), 'market_id' => $market_id]);
                $msg1=$user->email . ' have place unmatched bet just now';
                $newBet=DB::table('betslip')->where('id', $id)->first();
                $note[]=['bet_item' => $newBet, 'msg' => $msg1, 'admins' => $this->getUpLineAdminIds($user_id), 'market_id' => $market_id,'userRunnerPosition'=>$this->getRunnerPosition($market_id,$user_id),'adminRunnerPosition'=>$this->getRunnerPositionAdmins($market_id,$user_id),'openBets'=>$this->getOpenBet($user_id,0),'adminOpenBet'=>$this->getOpenBetAdmins(0,$user_id)];
                ////////////////////////////////////////////////////////////////////////

                $matched_liability = $this->getLiabilityOfMarket($market_id, $user_id);
                $f_wallet = $user->wallet - $old_liability + $matched_liability;
                DB::table('users')->where('id', $user_id)->update(['wallet' => $f_wallet]);
                $old_exposure=$user->exposure;
                $user->exposure = $user->exposure - $old_liability + $matched_liability;
                if ($user->exposure>0)$user->exposure=0;
                DB::table('users')->where('id', $user_id)->update(['exposure' => $user->exposure]);
                DB::table('liability_log')->insert(['user_id'=>$user->id,'wallet'=>$user->wallet,'exposure'=>$user->exposure,'old_liability'=>$old_liability,'n_liability'=>$matched_liability,'old_exposure'=>$old_exposure,'t_id'=>$betItem->id,'action'=>'lay2 bet placed']);
                DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                return $this->response(0, 'Placed successfully', $note);
            }
            DB::table('betslip')->where('id', $betItem->id)->delete();
            //maxProfit condition
            $n_profit=$this->getMaxProfitOfMarket($market_id, $user_id);
            if ($inPlay==0) {//preInplayStake
                if ($n_profit > $s_manage->preInplayProfit and $n_profit>$c_profit) {
                    DB::table('betslip')->whereIn('betslip.id', $newBetIds)->delete();
                    DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                    return $this->response(1, 'Your profit is '.$n_profit.'. Your max pre profit can not be greater than ' . $s_manage->preInplayProfit, $s_manage);
                }

            }
            if ($n_profit > $s_manage->maxProfit and $n_profit>$c_profit) {
                DB::table('betslip')->whereIn('betslip.id', $newBetIds)->delete();
                DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
                return $this->response(1, 'Your profit is '.$n_profit.'. Your max pre profit can not be greater than ' .$s_manage->maxProfit, $s_manage);
            }
            //maxProfit Condition End
            $matched_liability = $this->getLiabilityOfMarket($market_id, $user_id);
            $f_wallet = $user->wallet - $old_liability + $matched_liability;
            DB::table('users')->where('id', $user_id)->update(['wallet' => $f_wallet]);
            $old_exposure=$user->exposure;
            $user->exposure = $user->exposure - $old_liability + $matched_liability;
            if ($user->exposure>0)$user->exposure=0;
            DB::table('users')->where('id', $user_id)->update(['exposure' => $user->exposure]);

            DB::table('liability_log')->insert(['user_id'=>$user->id,'wallet'=>$user->wallet,'exposure'=>$user->exposure,'old_liability'=>$old_liability,'n_liability'=>$matched_liability,'old_exposure'=>$old_exposure,'t_id'=>$betItem->id,'action'=>'lay2 bet placed']);
            DB::table('user_markets')->where([['market_id',$market_id],['user_id',$user_id]])->update(['is_work'=>0]);
            return $this->response(0, 'Placed successfully', $note);
            //$res=max($odds);
        }
        DB::table('betslip')->where('id', $betItem->id)->delete();

        return $this->response(1, 'Something wrong', '');
    }
    public function getRunnerPosition($market_id,$user_id){
        $runners = DB::table('runners')->where('market_id', $market_id)->get();
        $res=array();
        foreach ($runners as $runner) {
            $profit = $this->getProfitOfRunner($runner->id, $user_id);
            $res[]=['runner_id'=>$runner->id,'position'=>$profit];
        }
        return $res;
    }
    public function getRunnerPositionAdmins($market_id,$user_id){
        $adminIds=$this->getUpLineAdminIds($user_id);
        $res=array();
        $runners = DB::table('runners')->where('market_id', $market_id)->get();
        $res=array();
        foreach ($adminIds as $adminId){
            foreach ($runners as $runner) {
                $profit = $this->getProfitAdmin1($runner->id,$adminId);
                $res[$adminId][]=['runner_id'=>$runner->id,'position'=>$profit];
            }
        }

        return $res;
    }
    public function getOpenBetAdmins($market_id,$user_id){
        $adminIds=$this->getUpLineAdminIds($user_id);
        $res=array();
        $runners = DB::table('runners')->where('market_id', $market_id)->get();
        $res=array();
        foreach ($adminIds as $adminId){
            $openBet = $this->getPlacedBetSlipsAdmin($adminId,$market_id);
            $res[$adminId]=json_decode($openBet);
        }

        return $res;
    }
    private function userWalletCheck($user_id,$action){
        $user=User::find($user_id);
        if ($user->wallet-$user->exposure!=$user->credit_limit){
            $user->state='Lock';
            $user->state='Detected wrong data at '.$action;
            $user->save();
        }
    }

    public function db_init()
    {
    //    DB::table('runners')->truncate();
    //    DB::table('markets')->truncate();
    //    DB::table('events')->truncate();
        DB::table('betslip')->truncate();
        DB::table('liability_log')->truncate();
//       DB::table('leagues')->truncate();
    //    DB::table('markets')->update(['marketStatus'=>'OPEN']);
        DB::table('reports')->truncate();;
        DB::table('settlement')->truncate();
        DB::table('users')/*->where([['isTest',1]])*/->update(['wallet'=>0,'credit_limit'=>0,'exposure'=>0,'pAndL'=>0,'cash'=>0,'bUp'=>0,'bUp1'=>0,'bDown'=>0,'bDown1'=>0,'comUp'=>0,'comUp1'=>0,'comDown'=>0,'comDown1'=>0,'comAmount'=>0]);
        //DB::table('users')->where([['email','tolren']])->update(['wallet'=>100000,'credit_limit'=>0,'exposure'=>0,'pAndL'=>0,'cash'=>0,'bUp'=>0,'bDown'=>0,'comUp'=>0,'comDown'=>0,'comAmount'=>0]);
        //DB::table('users')->where([['email','sun001']])->update(['wallet'=>100000,'credit_limit'=>0,'exposure'=>0,'pAndL'=>0,'cash'=>0,'bUp'=>0,'bDown'=>0,'comUp'=>0,'comDown'=>0,'comAmount'=>0]);
        /*DB::table('users')->where([['email','demo001']])->update(['wallet'=>100000,'credit_limit'=>0,'exposure'=>0,'pAndL'=>0,'cash'=>0,'bUp'=>0,'bDown'=>0,'comUp'=>0,'comDown'=>0,'comAmount'=>0]);
        DB::table('users')->where([['email','amit001']])->update(['wallet'=>100000,'credit_limit'=>0,'exposure'=>0,'pAndL'=>0,'cash'=>0,'bUp'=>0,'bDown'=>0,'comUp'=>0,'comDown'=>0,'comAmount'=>0]);*/
        DB::table('admins')->update(['wallet'=>0,'credit_limit'=>0,'pAndL'=>0,'cash'=>0,'bUp'=>0,'bUp1'=>0,'bDown'=>0,'bDown1'=>0,'comUp'=>0,'comUp1'=>0,'comDown'=>0,'comDown1'=>0,'comAmount'=>0]);
        DB::table('admins')->where('is_super',0)->update(['wallet'=>1000000000]);
//        DB::table('betslip')->join('users','users.id','betslip.user_id')->where([['users.isTest',1]])->delete();
        /*$check_event=DB::table('events')
            ->join('markets','markets.event_id','events.id')
            ->join('runners','runners.market_id','markets.id')
            ->join('betslip','betslip.runner_id','runners.id')
            ->where([['events.id',$ended_event->id],['events.state','<>','done']])->get();
        if (count($check_event)==0){
            DB::table('runners')
                ->join('markets','runners.market_id','markets.id')
                ->join('events','markets.event_id','events.id')
                ->where([['events.id',$ended_event->id],['events.state','<>','done']])->delete();
            DB::table('markets')->where('event_id',$ended_event->id)->delete();
            DB::table('events')->where([['id',$ended_event->id],['events.state','<>','done']])->delete();
            //continue;
        }*/
        /*$check_event = DB::table('events')
            ->join('markets', 'markets.event_id', 'events.id')
            ->join('runners', 'runners.market_id', 'markets.id')
            ->join('betslip', 'betslip.runner_id', 'runners.id')
            ->select('events.*')
            ->where([['events.time_status', '3']])->get();*/

        return json_encode(\request('loginsession'));
    }

    public function getMaxProfitOfMarket($market_id, $user_id)
    {
        $runners = DB::table('runners')->where('market_id', $market_id)->get();
        $maxProfit = array();
        foreach ($runners as $item) {
            $profit = DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', $item->id], ['betslip.user_id', $user_id], ['betslip.state', 1]/*, ['betslip.is_matched', 'true']*/, ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('profit_amount')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', $item->id], ['betslip.user_id', $user_id], ['betslip.state', 1]/*, ['betslip.is_matched', 'true']*/, ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', $item->id], ['betslip.user_id', $user_id], ['betslip.state', 1]/*, ['betslip.is_matched', 'true']*/, ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', $item->id], ['betslip.user_id', $user_id], ['betslip.state', 1]/*, ['betslip.is_matched', 'true']*/, ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('profit_amount');
            /*DB::table('user_profit')->updateOrInsert(['market_id' => $market_id,'runner_id'=>$item->id,'user_id'=>$user_id], ['market_id' => $market_id,'runner_id'=>$item->id,'liability'=>$li_item,'user_id'=>$user_id]);*/
            $maxProfit[] = $profit;
        }
        $maxProfit = max($maxProfit);
        return $maxProfit;
    }

    public function getProfit()
    {
        $market_id = DB::table('runners')->where('id', \request('runner_id'))->value('market_id');
        $liability = array();
        $profit = DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->where([['betslip.runner_id', \request('runner_id')], ['betslip.user_id', \request('user_id')], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                ->sum('profit_amount')
            + DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->where([['betslip.runner_id', '<>', \request('runner_id')], ['betslip.user_id', \request('user_id')], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                ->sum('exposure')
            + DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->where([['betslip.runner_id', \request('runner_id')], ['betslip.user_id', \request('user_id')], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                ->sum('exposure')
            + DB::table('betslip')
                ->join('runners', 'runners.id', 'betslip.runner_id')
                ->where([['betslip.runner_id', '<>', \request('runner_id')], ['betslip.user_id', \request('user_id')], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                ->sum('profit_amount');


        return json_encode($profit);
    }

    public function getUsersOfAdmin($user_id)
    {
        $admin_ids = Admin::where('parent_id', $user_id)->pluck('id');
        $admin_ids[] = $user_id;
        $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
        $admin_ids[] = $user_id;
        $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
        $admin_ids[] = $user_id;
        $user_ids = User::whereIn('parent_id', $admin_ids)->pluck('id')->unique();
        return $user_ids;
    }

    public function getProfitAdmin()
    {
        $market_id = DB::table('runners')->where('id', \request('runner_id'))->value('market_id');
        $user_id = \request('user_id');
        $admin_ids = Admin::where('parent_id', $user_id)->pluck('id');
        $admin_ids[] = $user_id;
        $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
        $admin_ids[] = $user_id;
        $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
        $admin_ids[] = $user_id;
        $user_ids = User::whereIn('parent_id', $admin_ids)->pluck('id')->unique();
        $profit = 0;
        foreach ($user_ids as $userId) {
            $item = DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', \request('runner_id')], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('profit_amount')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', \request('runner_id')], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToBack'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', \request('runner_id')], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('exposure')
                + DB::table('betslip')
                    ->join('runners', 'runners.id', 'betslip.runner_id')
                    ->where([['betslip.runner_id', '<>', \request('runner_id')], ['betslip.user_id', $userId], ['betslip.state', 1], ['betslip.is_matched', 'true'], ['betslip.bet_type', 'availableToLay'], ['runners.market_id', $market_id]])
                    ->sum('profit_amount');
            $profit += $item * $this->getPartnerShip($user_id, $userId);
        }

        return json_encode(-$profit);
    }

    public function getPartnerShip($adminId, $userId)
    {
        $user = User::find($userId);
        $parentId = $user->parent_id;
        $partnerShip = $user->partnerShip;
        while (true) {
            if ($parentId == $adminId) break;
            $admin = Admin::find($parentId);
            if (!isset($admin)) break;
            $partnerShip = $admin->partnerShip;
            $parentId = $admin->parent_id;
        }
        return $partnerShip / 100;
    }

    public function response($state, $message, $data)
    {
        $senddate['state'] = $state;
        $senddate['message'] = $message;
        $senddate['data'] = $data;
        return json_encode($senddate);
    }

    //update balence
    public function testing(){
        return 'test';
    }
    public function updateBalance()
    {
        //return response()->json(Auth::guard('api')->user());
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $r_data = Input::all();
        $user_id = $r_data['user_id'];
        $user = User::where('id', $user_id)->first();
        $send_data['wallet'] = $user->wallet;
        $send_data['liability'] = $user->exposure;
        $send_data['name'] = $user->email;
        //$send_data['winnings'] = $user->profit_loss_amount;
        return $this->response(100, 'Get balance', $user);
    }

    public function createMarkets(){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $marketName=\request('marketName');
        $event_id=\request('event_id');
        $runners=\request('runners');
        $market=new Market();
        $market->event_id=$event_id;
        $market->marketId=-1;
        $market->marketName=$marketName;

        $market->save();
        foreach ($runners as $item){
            $runner=new Runner();
            $runner->runnerId=-1;
            $runner->runnerName=$item;
            $runner->market_id=$market->id;
            $runner->save();
        }
        return $this->response(100, 'Success added', '');
    }
    public function delMarkets(){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $market_id=\request('market_id');
        Runner::where('market_id',$market_id)->delete();
        Market::where('id',$market_id)->delete();
        return $this->response(100, 'Success delete', '');
    }

    public function addMarket()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $data = Input::all();
        $state = $data['state'];
        $event_id = $data['event_id'];
        $user_id = $data['user_id'];
        $market_type = $data['market_type'];
        if ($state == 'false') {
            DB::table('market')->insert(['event_id' => $event_id, 'user_id' => $user_id, 'market_type' => $market_type]);
        } else {
            DB::table('market')->where([['event_id', $event_id], ['user_id', $user_id, 'market_type' => $market_type]])->delete();
        }
        return $this->response(100, 'Success', $data);
    }

    public function getMarket()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $data = Input::all();
        $user_id = $data['user_id'];
        $send_data = DB::table('market')->where([['user_id', $user_id]])->get();
        return $this->response(100, 'Success', $send_data);
    }

    public function bethistory()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $filter = [];
        if (!empty(\request('search'))) {
            $filter[] = ['runners.runnerName', 'like', '%' . \request('search') . '%'];
        }
        if (!empty(\request('start_date'))) {
            $filter[] = ['betslip.at_update', '>=', \request('start_date')];
        }
        if (!empty(\request('end_date'))) {
            $filter[] = ['betslip.at_update', '<=', \request('end_date')];
        }
        if (!empty(\request('odd'))) {
            $filter[] = ['betslip.odd', \request('odd')];
        }
        if (!empty(\request('stake'))) {
            $filter[] = ['betslip.stake', \request('stake')];
        }
        if (!empty(\request('bet_type'))) {
            $filter[] = ['betslip.stake', \request('bet_type')];
        }
        if (!empty(\request('ip'))) {
            $filter[] = ['betslip.ip', \request('ip')];
        }
        if (!empty(\request('state'))) {
            $filter[] = ['betslip.state', \request('state')];
        }
        $send_data = DB::table('betslip')
            ->join('runners', 'runners.id', 'betslip.runner_id')
            ->where([['betslip.user_id', \request('user_id')], ['betslip.state', '<>', 0]])
            ->where($filter)
            ->orderBy('betslip.id', 'dec')
            ->select('betslip.*', 'runners.runnerName')
            ->get();
        return $this->response('1', 'Get data', $send_data);
    }

    public function acc_statement()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $filter = [];
        if (!empty(\request('search'))) {
            $filter[] = ['remark', 'like', '%' . \request('search') . '%'];
        }
        if (!empty(\request('start_date'))) {
            $filter[] = ['datetime', '>=', \request('start_date')];
        }
        if (!empty(\request('end_date'))) {
            $filter[] = ['datetime', '<=', \request('end_date')];
        }
        $send_data = DB::table('wallet_history')
            ->where([['user_id', \request('user_id')], ['user_type', 2]])
            ->where($filter)
            ->get();
        return $this->response('1', 'Get data', $send_data);
    }

    public function profitOfUser()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $filter = [];
        if (!empty(\request('event_name'))) {
            $filter[] = ['events.name', 'like', '%' . \request('event_name') . '%'];
        }
        if (\request('sport') !== 'all') {
            $filter[] = ['events.sport_id', \request('sport')];
        }
        if (!empty(\request('start_date'))) {
            $filter[] = ['events.time', '>=', \request('start_date')];
        }
        if (!empty(\request('end_date'))) {
            $filter[] = ['events.time', '<=', \request('end_date')];
        }
        $markets = DB::table('markets')
            ->join('events', 'events.id', 'markets.event_id')
            ->where([['markets.state', 'done']])
            ->where($filter)
            //->whereBetween('events.time',[\request('start_time'),\request('end_time')])
            ->select('markets.*', 'events.id as event_id', 'events.time as date_time', 'events.name as eventName')
            ->get();
        $f_market = array();
        $general_setting = array();
        $data = DB::table('general_setting')->get();
        foreach ($data as $item) {
            $general_setting[$item->name] = $item->value;
        }
        foreach ($markets as $market) {
            $insert_item = array();
            $is_detect = DB::table('runners')
                ->join('betslip', 'betslip.runner_id', 'runners.id')
                //->join('payment_history','payment_history.t_id','betslip.id')
                ->where([['betslip.state', 2], ['runners.market_id', $market->id], ['betslip.user_id', \request('user_id')]])
                //->select('payment_history.amount')
                ->get();
            if (count($is_detect) == 0) continue;
            //
            $user_profit = DB::table('runners')
                ->join('betslip', 'betslip.runner_id', 'runners.id')
                //->join('payment_history','payment_history.t_id','betslip.id')
                ->where([['betslip.state', 2], ['runners.market_id', $market->id]])
                //->select('payment_history.amount')
                ->sum('betslip.profit_amount');

            //$insert_item['admin']=$admin_profit;
            //$insert_item['s_master']=$s_master_profit;
            //$insert_item['master']=$master_profit;
            $insert_item['user'] = $user_profit;
            $insert_item['market'] = $market;
            $insert_item['service_fee'] = $general_setting['service_fee'];;
            $f_market[] = $insert_item;

        }
        return $this->response('1', 'Get Profit of user', $f_market);
    }

    public function sports_edit()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $data = Input::all();
        $r_data = json_decode($data['parameter'], true);
        $id = $r_data['id'];
        $name = $r_data['name'];
        $type = $r_data['type'];
        switch ($type) {
            case 'edit':
                DB::table('sports')->where('id', $id)->update(['name' => $name]);
                break;
            case 'add':
                DB::table('sports')->insert(['id' => $id, 'name' => $name]);
                break;
            case 'del':
                DB::table('sports')->where('id', $id)->delete();
                break;
        }
        return $this->response(100, 'Success Sports', null);
    }

    public function getSeries()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $series = DB::table('leagues')->get();
        return $this->response(0, 'Get Series', $series);
    }

    public function getSports()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $sports = DB::table('sport_names')->orderByRaw("FIELD(name , 'Cricket') DESC")->get();
        $userType = \request('userType') < 4 ? 'admins' : 'users';
        $c_account = DB::table($userType)->where('id', \request('user_id'))->first();
        //return json_encode($c_account);
        foreach ($sports as $item) {
            $is_check = DB::table('sport_management')->where([['admin_id', \request('user_id')], ['sport_id', $item->id], ['userType', $userType]])->get();
            //return count($is_check);
            if (count($is_check)!=0) continue;
            if ($userType=='admins') {
                if ($c_account->is_super == 0) {
                    DB::table('sport_management')->insert([
                        'admin_id' => \request('user_id'),
                        'sport_id' => $item->id,
                        'userType' => $userType,
                    ]);
                    continue;
                }
            }
            $parent_data = DB::table('sport_management')->where([['admin_id', $c_account->parent_id], ['sport_id', $item->id], ['userType', 'admins']])->first();
            if (!isset($parent_data)) continue;
            DB::table('sport_management')->insert([
                'admin_id' => $c_account->id,
                'sport_id' => $item->id,
                'userType' => $userType,
                'minStake' => $parent_data->minStake,
                'maxStake' => $parent_data->maxStake,
                'maxProfit' => $parent_data->maxProfit,
                'preInplayProfit' => $parent_data->preInplayProfit,
                'preInplayStake' => $parent_data->preInplayStake,
                'commission' => $parent_data->commission,
                'delaySec' => $parent_data->delaySec,
                'unMatched' => $parent_data->unMatched,
                'lockBet' => $parent_data->lockBet,
            ]);
        }
        $sports_manage = DB::table('sport_names')
            ->join('sport_management', 'sport_names.id', 'sport_management.sport_id')
            ->join($userType, $userType . '.id', 'sport_management.admin_id')
            ->select('sport_management.*', 'sport_names.name', $userType . '.name as adminName', $userType . '.email as adminEmail')
            ->where([['sport_management.admin_id', \request('user_id')],['sport_management.userType',$userType]])
            ->orderByRaw("FIELD(sport_names.name , 'Cricket') DESC")->get();
        return $this->response(0, 'Get Sports', $sports_manage);
    }

    public function setSeries()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        DB::table('leagues')->where('id', \request('id'))->update(['isUpdate' => \request('isUpdate'), 'is_active' => \request('is_active')]);
        return $this->response(0, 'Success updated', '');
    }
    public function setSeriesAll()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $sportId=\request('id');
        if (!empty(\request('isUpdate'))){
            DB::table('leagues')->where('sport_id',$sportId )->update(['isUpdate' => \request('isUpdate')]);
        }
        if (!empty(\request('is_active'))){
            DB::table('leagues')->where('sport_id',$sportId )->update(['is_active' => \request('is_active')]);
        }

        return $this->response(0, 'Success updated', '');
    }

    public function setSport()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $sport_item=json_decode(json_encode(\request('item')));
        $user_id = DB::table('sport_management')->where('id', $sport_item->id)->value('admin_id');
        $userType = DB::table('sport_management')->where('id', $sport_item->id)->value('userType');
        $sport_id = DB::table('sport_management')->where('id', $sport_item->id)->value('sport_id');
        $c_account = DB::table($userType)->where('id', $user_id)->first();
        if (\request('isSuper') != 0) {
            $parent_data = DB::table('sport_management')->where([['admin_id', $c_account->parent_id], ['sport_id', $sport_id], ['userType', 'admins']])->first();
            if ($sport_item->minStake < $parent_data->minStake) return $this->response(0, 'Min Stake can not be smaller than ' . $parent_data->minStake, '');
            if ($sport_item->f_minStake < $parent_data->f_minStake) return $this->response(0, 'Min Stake can not be smaller than ' . $parent_data->f_minStake, '');
            if ($sport_item->maxStake > $parent_data->maxStake) return $this->response(0, 'Max Stake can not be greater than ' . $parent_data->maxStake, '');
            if ($sport_item->f_maxStake > $parent_data->f_maxStake) return $this->response(0, 'Max Stake can not be greater than ' . $parent_data->f_maxStake, '');
            if ($sport_item->maxProfit > $parent_data->maxProfit) return $this->response(0, 'Max Profit can not be greater than ' . $parent_data->maxProfit, '');
            if ($sport_item->f_profit > $parent_data->f_profit) return $this->response(0, 'Max Profit can not be greater than ' . $parent_data->f_profit, '');
            if ($sport_item->preInplayProfit > $parent_data->preInplayProfit) return $this->response(0, 'PreInPlayProfit can not be greater than ' . $parent_data->preInplayProfit, '');
            if ($sport_item->preInplayStake > $parent_data->preInplayStake) return $this->response(0, 'PreInPlayStake can not be greater than ' . $parent_data->preInplayStake, '');
            if ($sport_item->delaySec < $parent_data->delaySec) return $this->response(0, 'Bet Delay can not be smaller than ' . $parent_data->delaySec, '');

            if ($parent_data->unMatched == 0 && $sport_item->unMatched == 1) return $this->response(0, 'Now can not allow unMatched Bet because your root admin did not allow', '');
            if ($parent_data->f_unMatched == 0 && $sport_item->f_unMatched == 1) return $this->response(0, 'Now can not allow unMatched Bet because your root admin did not allow', '');
            if ($parent_data->lockBet == 1 && $sport_item->lockBet == 0) return $this->response(0, 'Now can not allow unMatched Bet because your root admin did not allow', '');
            if ($parent_data->f_lockBet == 1 && $sport_item->f_lockBet == 0) return $this->response(0, 'Now can not allow unMatched Bet because your root admin did not allow', '');
        }
        DB::table('sport_management')->where('id', $sport_item->id)
            ->update(
                [
                    'minStake' => $sport_item->minStake,
                    'f_minStake' => $sport_item->f_minStake,
                    'maxStake' => $sport_item->maxStake,
                    'f_maxStake' => $sport_item->f_maxStake,
                    'maxProfit' => $sport_item->maxProfit,
                    'f_profit' => $sport_item->f_profit,
                    'preInplayProfit' => $sport_item->preInplayProfit,
                    'preInplayStake' => $sport_item->preInplayStake,
                    'delaySec' => $sport_item->delaySec,
                    'f_delaySec' => $sport_item->f_delaySec,
                    'unMatched' =>$sport_item->unMatched,
                    'f_unMatched' =>$sport_item->f_unMatched,
                    'lockBet' => $sport_item->lockBet,
                    'f_lockBet' => $sport_item->f_lockBet,
                    'commission' => $sport_item->commission,
                    'f_commission' => $sport_item->f_commission,
                ]
            );
        $admin_ids = Admin::where('parent_id', $user_id)->pluck('id');
        $admin_ids[] = $user_id;
        $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
        $admin_ids[] = $user_id;
        $admin_ids = Admin::whereIn('parent_id', $admin_ids)->pluck('id');
        $admin_ids[] = $user_id;
        $user_ids = User::whereIn('parent_id', $admin_ids)->pluck('id')->unique();
        DB::table('sport_management')->where([['sport_id', $sport_id], ['userType', 'admins']])->whereIn('admin_id', $admin_ids)
            ->update(
                [
                    'minStake' => $sport_item->minStake,
                    'f_minStake' => $sport_item->f_minStake,
                    'maxStake' => $sport_item->maxStake,
                    'f_maxStake' => $sport_item->f_maxStake,
                    'maxProfit' => $sport_item->maxProfit,
                    'f_profit' => $sport_item->f_profit,
                    'preInplayProfit' => $sport_item->preInplayProfit,
                    'preInplayStake' => $sport_item->preInplayStake,
                    'delaySec' => $sport_item->delaySec,
                    'f_delaySec' => $sport_item->f_delaySec,
                    'unMatched' =>$sport_item->unMatched,
                    'f_unMatched' =>$sport_item->f_unMatched,
                    'lockBet' => $sport_item->lockBet,
                    'f_lockBet' => $sport_item->f_lockBet,
                    'commission' => $sport_item->commission,
                    'f_commission' => $sport_item->f_commission,
                ]
            );
        DB::table('sport_management')->where([['sport_id', $sport_id], ['userType', 'users']])->whereIn('admin_id', $user_ids)
            ->update(
                [
                    'minStake' => $sport_item->minStake,
                    'f_minStake' => $sport_item->f_minStake,
                    'maxStake' => $sport_item->maxStake,
                    'f_maxStake' => $sport_item->f_maxStake,
                    'maxProfit' => $sport_item->maxProfit,
                    'f_profit' => $sport_item->f_profit,
                    'preInplayProfit' => $sport_item->preInplayProfit,
                    'preInplayStake' => $sport_item->preInplayStake,
                    'delaySec' => $sport_item->delaySec,
                    'f_delaySec' => $sport_item->f_delaySec,
                    'unMatched' =>$sport_item->unMatched,
                    'f_unMatched' =>$sport_item->f_unMatched,
                    'lockBet' => $sport_item->lockBet,
                    'f_lockBet' => $sport_item->f_lockBet,
                    'commission' => $sport_item->commission,
                    'f_commission' => $sport_item->f_commission,
                ]
            );
        DB::table('market_management')
            ->join('markets','markets.id','market_management.market_id')
            ->join('events','markets.event_id','events.id')
            ->where([['events.sport_id', $sport_id],['markets.marketType',null]])
            ->update(
                [
                    'market_management.minStake' => $sport_item->minStake,
                    'market_management.maxStake' => $sport_item->maxStake,
                    'market_management.maxProfit' => $sport_item->maxProfit,
                    'market_management.preInplayProfit' => $sport_item->preInplayProfit,
                    'market_management.preInplayStake' => $sport_item->preInplayStake,
                    'market_management.delaySec' => $sport_item->delaySec,
                    'market_management.unMatched' =>$sport_item->unMatched,
                    'market_management.lockBet' => $sport_item->lockBet,
                    'market_management.commission' => $sport_item->commission,
                ]
            );
        DB::table('market_management')
            ->join('markets','markets.id','market_management.market_id')
            ->join('events','markets.event_id','events.id')
            ->where([['events.sport_id', $sport_id],['markets.marketType','fancy']])
            ->update(
                [
                    'market_management.minStake' => $sport_item->f_minStake,
                    'market_management.maxStake' => $sport_item->f_maxStake,
                    'market_management.maxProfit' => $sport_item->f_profit,
                    'market_management.preInplayProfit' => $sport_item->preInplayProfit,
                    'market_management.preInplayStake' => $sport_item->preInplayStake,
                    'market_management.delaySec' => $sport_item->f_delaySec,
                    'market_management.unMatched' =>$sport_item->f_unMatched,
                    'market_management.lockBet' => $sport_item->f_lockBet,
                    'market_management.commission' => $sport_item->f_commission,
                ]
            );

        //$sport = DB::table('sport_names')->where('id', $sport_item->id)->first();
        $marketsManamgement=DB::table('market_management')
            ->join('markets','markets.id','market_management.market_id')
            ->join('events','markets.event_id','events.id')
            ->where([['events.sport_id', $sport_id],])->get();
        return $this->response(0, 'Success updated', $marketsManamgement);
    }

    public function getAvailablePartnerShip($admin_id)
    {
        $admin = Admin::find($admin_id);
        $partnerShip = $admin->partnerShip;
        while (true) {
            if ($admin->is_super == 0) break;
            $parentId = $admin->parent_id;
            $admin = Admin::find($parentId);
            //if (!isset($admin))break;
            $partnerShip += $admin->partnerShip;
        }
        return 100 - $partnerShip;
    }
    public function changePasswordAdmin(){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $user =\request('user_type')=='admins'?Admin::find(\request('user_id')):User::find(\request('user_id'));
        if (\request('newPassword')!=\request('confirmPassword')){
            return json_encode(['msg'=>'Confirm password is not matched']);
        }
        $user->password=Hash::make(\request('newPassword'));
        $user->save();
        return json_encode(['msg'=>'Success update password']);
    }
    public function changePassword(){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $user_type=\request('user_type');
        $user_id=\request('user_id');
        if (\request('newPassword') != \request('confirmPassword')) {
            return $this->response(1, 'Did not matched password and confirm password', '');
        }
        if ($user_type=='users'){
            $account=User::find($user_id);
        }else{
            $account=Admin::find($user_id);
        }

        if (!Hash::check(\request('oldPassword'),$account->password)){
            return $this->response(1,'Old password is not matched',null);
        }
        $account->password=Hash::make(\request('newPassword'));
        $account->save();
        return $this->response(0,'Your password changed successfully',null);


    }
    public function addAdmin()
    {
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $is_check = Admin::where('email', \request('email'))->get();
        //return $this->response(1, 'Duplicate of Account Name', '');
        if (count($is_check) > 0) {
            return $this->response(0, 'Duplicate of Account Name', '');
        }
        $is_check = User::where('email', \request('email'))->get();
        //return $this->response(1, 'Duplicate of Account Name', '');
        if (count($is_check) > 0) {
            return $this->response(0, 'Duplicate of Account Name', '');
        }
        $availablePartnerShip = $this->getAvailablePartnerShip(\request('parent_id'));
        if ($availablePartnerShip < \request('partnerShip')) {
            return $this->response(0, 'Your partnerShip is unable value, it should small than ' . $availablePartnerShip, '');
        }
        if (0 > \request('partnerShip')) {
            return $this->response(0, 'Your partnerShip is unable value, it should great than 0', '');
        }
        if (\request('password') != \request('confirmPassword')) {
            return $this->response(0, 'Did not matched password and confirm password', '');
        } else {

            if (\request('is_super') == 4) {
                $admin = new User();
                $admin->name = \request('name');
                $admin->email = \request('email');
                $admin->partnerShip = $availablePartnerShip;
                $admin->comm = \request('comm');
                $admin->password = Hash::make(\request('password'));
                $admin->parent_id = \request('parent_id');
                $admin->delayOfFancy = \request('delayOfFancy');
                $admin->delaySec = \request('delaySec');
                $admin->save();

                $sports = DB::table('sport_names')->orderByRaw("FIELD(name , 'Cricket') DESC")->get();
                $userType = 'users';
                //return json_encode($c_account);
                foreach ($sports as $item) {
                    $is_check = DB::table('sport_management')->where([['admin_id', $admin->id], ['sport_id', $item->id], ['userType', $userType]])->get();
                    if (count($is_check) > 0) continue;
                    $parent_data = DB::table('sport_management')->where([['admin_id', $admin->parent_id], ['sport_id', $item->id], ['userType', 'admins']])->first();
                    if (!isset($parent_data)) continue;
                    DB::table('sport_management')->insert([
                        'admin_id' => $admin->id,
                        'sport_id' => $item->id,
                        'userType' => $userType,
                        'minStake' => $parent_data->minStake,
                        'maxStake' => $parent_data->maxStake,
                        'maxProfit' => $parent_data->maxProfit,
                        'preInplayProfit' => $parent_data->preInplayProfit,
                        'preInplayStake' => $parent_data->preInplayStake,
                        'commission' => $parent_data->commission,
                        'delaySec' => $parent_data->delaySec,
                        'unMatched' => $parent_data->unMatched,
                        'lockBet' => $parent_data->lockBet,
                    ]);
                }
                return $this->response(2, 'user created successfully', $admin);
            } else {
                $admin = new Admin();
                $admin->name = \request('name');
                $admin->email = \request('email');
                $admin->partnerShip = \request('partnerShip');
                $admin->comm = \request('comm');
                $admin->password = Hash::make(\request('password'));
                $admin->is_super = \request('is_super');
                $admin->parent_id = \request('parent_id');
                $admin->delayOfFancy = \request('delayOfFancy');
                $admin->delaySec = \request('delaySec');
                $admin->save();

                $sports = DB::table('sport_names')->orderByRaw("FIELD(name , 'Cricket') DESC")->get();
                $userType = 'admins';
                //return json_encode($c_account);
                foreach ($sports as $item) {
                    $is_check = DB::table('sport_management')->where([['admin_id', $admin->id], ['sport_id', $item->id], ['userType', $userType]])->get();
                    if (count($is_check) > 0) continue;
                    $parent_data = DB::table('sport_management')->where([['admin_id', $admin->parent_id], ['sport_id', $item->id], ['userType', 'admins']])->first();
                    if (count($parent_data) == 0) continue;
                    DB::table('sport_management')->insert([
                        'admin_id' => $admin->id,
                        'sport_id' => $item->id,
                        'userType' => $userType,
                        'minStake' => $parent_data->minStake,
                        'maxStake' => $parent_data->maxStake,
                        'maxProfit' => $parent_data->maxProfit,
                        'preInplayProfit' => $parent_data->preInplayProfit,
                        'preInplayStake' => $parent_data->preInplayStake,
                        'commission' => $parent_data->commission,
                        'delaySec' => $parent_data->delaySec,
                        'unMatched' => $parent_data->unMatched,
                        'lockBet' => $parent_data->lockBet,
                    ]);
                }
                return $this->response(1, 'Account created successfully', $admin);
            }


        }

    }
    public function setMultiMarket(){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $user_id=\request('user_id');
        $user_type=\request('user_type');
        $market_id=\request('market_id');
        $is_check=DB::table('market')->where([['user_id',$user_id],['user_type',$user_type],['market_id',$market_id]])->first();
        if (empty($is_check)){
            DB::table('market')->insert([
                'user_id'=>$user_id,'user_type'=>$user_type,'market_id'=>$market_id
            ]);
            return $this->response(0,'active_market',$market_id);
        }else{
            DB::table('market')->where([['user_id',$user_id],['user_type',$user_type],['market_id',$market_id]])->delete();
            return $this->response(0,'deactive_market',$market_id);
        }
    }


    public function setAccountState(){
        $this->authorization(\request()->header('authtype'),\request()->header('authorization'),\request()->header('authentication'));
        $state=\request('state');
        $accountType=\request('accountType');
        $admin_id=\request('admin_id');
        $account_id=\request('account_id');
        $u_remark=\request('u_remark');
        $admins=$this->getUpLineAdminIdsOfAdmin($admin_id);
        $admin_ids=array();
        foreach ($admins as $admin){
            $admin_ids[]=$admin->id;
        }
        $isPossible=AccountState::where([['account_id',$account_id],['accountType',$accountType]])->whereIn('admin_id',$admin_ids)->get();
        if (count($isPossible)>0)return $this->response(1, 'Can not set because set by your Upper account.', '');
        $account=$accountType=="admins"?Admin::find($account_id):User::find($account_id);
        $account->state=$state;
        $account->u_remark=$u_remark;
        $account->save();
        AccountState::where([['account_id',$account_id],['accountType',$accountType]/*,['admin_id',$admin_id]*/])->delete();

        if ($state=='Active')return $this->response(1, 'You have set your account state.', '');
        $accountState=new AccountState();
        $accountState->admin_id=$admin_id;
        $accountState->account_id=$account_id;
        $accountState->accountType=$accountType;
        $accountState->remark=$u_remark;
        $accountState->state=$state;
        $accountState->save();
        return $this->response(0, 'You have set your account state.', '');
    }
    //////////////////////////
}
