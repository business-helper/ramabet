<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use Stripe\Reporting\ReportRun;

class Api1Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $host='http://52.208.223.36';
    private $firebase;
    public function __construct()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        $this->firebase=new FirebaseController();
    }


    /**
     * Show the application dashboard.
     *6046:Football,
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function getSportIds(){

    }
    public function competition_list(){
        //request()->ip()
        $sport_ids = DB::table('sport_names')->where('is_active', 'true')->pluck('import_id');
        foreach ($sport_ids as $sport_id){
            $url=$this->host.'/betfair/competition_list/'.$sport_id;
            $seriesList = $this->curl($url);
            if (isset($seriesList->error)){
                return \response(json_encode(['request url'=>$url,'data'=>$seriesList]));
            }
            if ($seriesList==null)continue;
            foreach ($seriesList as $series) {
                $is_check = League::where('import_id', $series->competition->id)->value('id');
                if (isset($is_check)) {
                    $league = League::find($is_check);
                    $league->sport_id = $sport_id;
                    $league->league_name = $series->competition->name;
                    $league->import_id = $series->competition->id;
                    $league->save();
                    //$updatedIds[] = $is_check;
                } else {
                    $league = new League();
                    $league->sport_id = $sport_id;
                    $league->league_name = $series->competition->name;
                    $league->import_id = $series->competition->id;
                    $league->save();
                    //$createdIds = $league->id;
                }

                //print_r($temp);
            }
        }
        $series = DB::table('leagues')->where('isUpdate',1)->get();
        return \response(json_encode($series));
        //$url=$this->host.'/betfair/competition_list/'.$sport_id;
        //$res=$this->curl($url);
        //return \response(json_encode(['request url'=>$url,'data'=>$res]));

    }
    public function getLeagues()
    {
        $series = DB::table('leagues')->where('isUpdate',1)->get();
        return json_encode($series);
    }
    public function event_list_by_competition($competition_id){
        //request()->ip()
        $league_id = $competition_id;
        $league = League::find($league_id);
        if (!isset($league))return;
        $updatedIds = array();
        $createdIds = array();
        $url=$this->host.'/betfair/event_list_by_competition/'.$league->import_id;
        $matcheList = $this->curl($url);
        $res=$matcheList;
        if (!isset($res)){
            League::where('id',$league_id)->delete();
            return \response(json_encode(['request url'=>$url,'data'=>$res]));
        }
        foreach ($matcheList as $match) {
            $is_check = Event::where('import_id', $match->event->id)->value('id');
            if ($league->league_name==$match->event->name)continue;
            if ($is_check > 0) {
                $event = Event::find($is_check);
                $event->sport_id = $league->sport_id;
                $event->league_id = $league->id;
                $event->import_id = $match->event->id;
                $event->name = $match->event->name;
                $date = new DateTime($match->event->openDate);
                $event->time = $date->format('Y-m-d H:i:s');
                $event->save();
                $updatedIds[]=$event;
            } else {
                $event = new Event();
                $event->sport_id = $league->sport_id;
                $event->league_id = $league->id;
                $event->import_id = $match->event->id;
                $event->name = $match->event->name;
                $date = new DateTime($match->event->openDate);
                $event->time = $date->format('Y-m-d H:i:s');;
                $event->save();
                $createdIds[] = $event;
            }
            //print_r($temp);
        }

        //$url=$this->host.'/betfair/event_list_by_competition/'.$competition_id;
        //$res=$this->curl($url);
        return \response(json_encode(['request url'=>$url,'data'=>$res]));

    }
    public function getEventIds(){
        $event_ids = Event::where([/*['events.time','>',Carbon::now()->subHour(12)],['events.time','<',Carbon::now()->addHour(12)]*/])->join('markets','markets.event_id','events.id')->where([['markets.isUpdate', 1], ['events.is_active', 'true'], ['events.time', '>', Carbon::now()->subHour(12)], ['events.time', '<', Carbon::now()->addHour(72)]])->pluck('events.id');
        return $this->response(0, 'Get Event Ids', $event_ids);
    }
    public function market_catalogue_list($r_count){
        //request()->ip()
        $event_ids = Event::where([['events.is_fresh', 'true'], ['events.is_active', 'true'],['events.time', '>', Carbon::now()->subHour(12)], ['events.time', '<', Carbon::now()->addHour(48)] ])->take(200)->skip($r_count*200)->pluck('events.import_id');

        $count=count($event_ids);
        $r_count++;
        if ($count<200)$r_count=0;

        $event_ids=implode(",",json_decode(json_encode($event_ids)));
        $url=$this->host.'/betfair/market_catalogue_list/'.$event_ids;
        $res=$this->curl($url);
        if ($res==null)return \response(json_encode(['error'=>'NULL','request url'=>$url,'data'=>$res]));
        foreach ($res as $item){
            /*$url1=$this->host.'/api/betfair/activate_b/'.$item->marketId;
            $this->curl($url1);*/
            $event_id=Event::where('import_id',$item->event->id)->value('id');
            if (!isset($event_id))continue;
            $is_market=Market::where('marketId',$item->marketId)->value('id');
            if(isset($is_market))continue;
            $market=new  Market();
            $market->event_id=$event_id;
            $market->marketId=$item->marketId;
            $market->marketName=$item->marketName;
            $market->save();
            foreach ($item->runners as $runner_item){
                $is_runner=Runner::where([['runnerId',$runner_item->selectionId],['market_id',$market->id]])->value('id');
                if (isset($is_runner))continue;
                $runner=new Runner();
                $runner->runnerId=$runner_item->selectionId;
                $runner->market_id=$market->id;
                $runner->runnerName=$runner_item->runnerName;
                $runner->save();
            }
        }
        return \response(json_encode(['count'=>$r_count,'request url'=>$url,'data'=>$res]));

    }
    public function market_book_list($marketId){
        //request()->ip()
        $url=$this->host.'/betfair/market_book_list/'.$marketId;
        $res=$this->curl($url);
        if ($res==null) return "fancy markets is 0";
        foreach ($res as $market_item){
            $url1=$this->host.'/api/betfair/activate_b/'.$market_item->marketId;
            $this->curl($url1);
            $is_check=Market::where('marketId', $marketId)->value('id');
            if (isset($is_check)){
                $market=Market::find($is_check);
                $market->marketId=$market_item->marketId;
                $market->marketStatus=$market_item->status;
                $market->inPlay=$market_item->inplay;
                $market->inPlay=$market_item->inplay;
                $market->runners=json_encode($market_item->runners);
                $market->save();
                foreach ($market_item->runners as $runner_item){
                    $is_runner=Runner::where([['runnerId',$runner_item->selectionId],['market_id',$market->id]])->value('id');
                    if (isset($is_runner)){
                        $runner=Runner::find($is_runner);
                        $runner->market_id=$market->id;
                        $runner->runnerId=$runner_item->selectionId;
                        //$runner->runnerName=$runner_item->selectionId;
                        $runner->save();

                    }
                }
            }

        }
        return "fancy markets is ".count($res);
//        $market_ids = Market::where([['market_result', 'none']])->pluck('marketId');
//        return implode(",",json_decode(json_encode($market_ids)));

    }
    public function cricket_extra_market_list($event_id){
        //request()->ip()
        $url=$this->host.'/betfair/cricket_extra_market_list/'.$event_id;
        $res=$this->curl($url);
        if ($res==null)return 0;
        //if ($res==null)return \response(json_encode(['count'=>0,'error'=>'NULL','request url'=>$url,'data'=>$res]));
        foreach ($res as $item){
            $url1=$this->host.'/api/betfair/activate_b/'.$item->marketId;
            $this->curl($url1);
            $event_id=Event::where('import_id',$item->event->id)->value('id');
            if (!isset($event_id))continue;
            $is_market=Market::where('marketId',$item->marketId)->value('id');
            if(isset($is_market))continue;
            $market=new  Market();
            $market->event_id=$event_id;
            $market->marketId=$item->marketId;
            $market->marketName=$item->marketName;
            $market->save();
            foreach ($item->runners as $runner_item){
                $is_runner=Runner::where([['runnerId',$runner_item->selectionId],['market_id',$market->id]])->value('id');
                if (isset($is_runner))continue;
                $runner=new Runner();
                $runner->runnerId=$runner_item->selectionId;
                $runner->market_id=$market->id;
                $runner->runnerName=$runner_item->runnerName;
                $runner->save();
            }
        }
        return \response(json_encode(['request url'=>$url,'data'=>$res]));

    }
    public function line_market_list($event_ids){
        /*$event_ids = Event::where([['events.is_fresh', 'true'], ['events.is_active', 'true'],['events.time', '>', Carbon::now()->subHour(12)], ['events.time', '<', Carbon::now()->addHour(72)] ])->take(200)->skip($r_count*200)->pluck('events.import_id');
        $count=count($event_ids);
        $r_count++;
        if ($count<200)$r_count=0;

        $event_ids=implode(",",json_decode(json_encode($event_ids)));*/
        //request()->ip()
        $url=$this->host.'/betfair/line_market_list/'.$event_ids;
        $res=$this->curl($url);
        if ($res==null)return 0;
        //if ($res==null)return \response(json_encode(['count'=>0,'error'=>'NULL','request url'=>$url,'data'=>$res]));
        foreach ($res as $item){
            $url1=$this->host.'/api/betfair/activate_b/'.$item->marketId;
            $this->curl($url1);
            $event_id=Event::where('import_id',$item->event->id)->value('id');
            if (!isset($event_id))continue;
            $is_market=Market::where('marketId',$item->marketId)->value('id');
            if(isset($is_market))continue;
            $market=new  Market();
            $market->event_id=$event_id;
            $market->marketId=$item->marketId;
            $market->marketName=$item->marketName;
            $market->save();
            foreach ($item->runners as $runner_item){
                $is_runner=Runner::where([['runnerId',$runner_item->selectionId],['market_id',$market->id]])->value('id');
                if (isset($is_runner))continue;
                $runner=new Runner();
                $runner->runnerId=$runner_item->selectionId;
                $runner->market_id=$market->id;
                $runner->runnerName=$runner_item->runnerName;
                $runner->save();
            }
        }

        //return \response(json_encode(['count'=>$r_count,'request url'=>$url,'data'=>$res]));

    }
    public function under_over_goal_market_list($event_id){
        //request()->ip()
        $url=$this->host.'/betfair/under_over_goal_market_list/'.$event_id;
        $res=$this->curl($url);
        if ($res==null)return 0;
        //if ($res==null)return \response(json_encode(['count'=>0,'error'=>'NULL','request url'=>$url,'data'=>$res]));
        foreach ($res as $item){
            $url1=$this->host.'/api/betfair/activate_b/'.$item->marketId;
            $this->curl($url1);
            $event_id=Event::where('import_id',$item->event->id)->value('id');
            if (!isset($event_id))continue;
            $is_market=Market::where('marketId',$item->marketId)->value('id');
            if(isset($is_market))continue;
            $market=new  Market();
            $market->event_id=$event_id;
            $market->marketId=$item->marketId;
            $market->marketName=$item->marketName;
            $market->save();
            foreach ($item->runners as $runner_item){
                $is_runner=Runner::where([['runnerId',$runner_item->selectionId],['market_id',$market->id]])->value('id');
                if (isset($is_runner))continue;
                $runner=new Runner();
                $runner->runnerId=$runner_item->selectionId;
                $runner->market_id=$market->id;
                $runner->runnerName=$runner_item->runnerName;
                $runner->save();
            }
        }
        return \response(json_encode(['request url'=>$url,'data'=>$res]));

    }
    /*public function market_book_list($event_id){
        //request()->ip()
        $url=$this->host.'/betfair/market_book_list/'.$event_id;
        $res=$this->curl($url);
        return \response(json_encode(['request url'=>$url,'data'=>$res]));
    }*/
    public function activate_b($event_id){
        //request()->ip()
        $url=$this->host.'/api/betfair/activate_b/'.$event_id;
        $res=$this->curl($url);
        return \response(json_encode(['request url'=>$url,'data'=>$res]));
    }
    public function activeMarket($marketId){
        $url1=$this->host.'/api/betfair/activate_b/'.$marketId;
        return $this->curl($url1);
    }
    public function getOdd($r_count){
        //request()->ip()
        $api=new ApiController();
        $marketIds = Market::join(
            'events','events.id','markets.event_id'
        )
            ->whereNotIn('markets.marketStatus',['CLOSED','CANCELED'])
            ->where([['markets.isUpdate', 1],['markets.marketName','<>','Fancy Markets'],['events.time','>',Carbon::now()->subHour(24)]])->take(100)->skip($r_count*100)->pluck('markets.marketId')->unique();
        $f_marketIds = Market::join(
            'events','events.id','markets.event_id'
        )
            ->whereNotIn('markets.marketStatus',['CLOSED','CANCELED'])
            ->where([['markets.isUpdate', 1],['markets.marketName','<>','Fancy Markets'],['events.sport_id',4],['events.time','>',Carbon::now()->subHour(24)]])->take(100)->skip($r_count*100)->pluck('markets.marketId')->unique();
        //return $marketIds;
        $marketIds=$marketIds->values()->all();
        //return json_encode($marketIds);
        if (count($marketIds)<=0)return 'No markets';
        $count=count($marketIds);
        $r_count++;
        if ($count<100)$r_count=0;
        $marketIdList=$marketIds;
        $marketIds=implode(",",json_decode(json_encode($marketIds)));
        $url=$this->host.':8001/api/betfair/'.$marketIds;
        //$res='test';
        $res=$this->curl($url);
        $index=0;
        $res1=array();
        $matchedBet=array();
        $markets=array();
        $index=0;
        $insert_runners=[];
        foreach ($res as $item){
            if ($item==null){
                $url1=$this->host.'/api/betfair/activate_b/'.$marketIdList[$index];
                $this->curl($url1);
                $index++;
                continue;
            }
            $index++;
            if (!isset($item->marketId))continue;
            $is_market=Market::where('marketId',$item->marketId)->value('id');
            if(!isset($is_market))continue;
            $market=Market::find($is_market);
            $old_marketStatus=$market->marketStatus;
            $market->marketStatus=$item->status;
            $market->inPlay=$item->inplay;

            if ($item->status=='CLOSED'){
                foreach ($item->runners as $runner){
                    $is_runner=Runner::where([['market_id',$market->id],['runnerId',$runner->selectionId]])->value('id');
                    if (!isset($is_runner))continue;
                    $db_runner=Runner::find($is_runner);
                    $db_runner->status=$runner->status;
                    if ($runner->status=='WINNER') $market->winnerName=$db_runner->runnerName;
                }
                $api->setMarketResultFromApi($market->id,$market->winnerName);
            }
            else if ($item->status=='SUSPENDED'){
                if ($item->status!=$market->marketStatus){
                    $api->setMarketResultFromApi($market->id,'--Suspend--');
                }

            }else if ($item->status=='CANCELED'){
                if ($item->status!=$market->marketStatus){
                    $api->setMarketResultFromApi($market->id,'--Abandon--');
                }

            }
            else{
                /*$db_runner=json_decode($market->runners);
                if ($market->runners!=json_encode($item->runners)){

                }*/
                /*$temp=$api->insertRunner($market->id,$item->runners);
                $res1=array_merge($res1,$temp['runners']);
                $matchedBet=array_merge($matchedBet,$temp['matchedBet']);*/
                $insert_runners[]=['market_id'=>$market->id,'runners'=>$item->runners,'runners1'=>json_decode($market->runners)];
            }
            $market->runners=json_encode($item->runners);
            $market->save();
            Market::where('marketId',$item->marketId)->update(['marketStatus'=>$item->status]);
            if ($old_marketStatus!=$market->marketStatus){
                $markets[]=$market;
            }

        }


        $f_marketIds=$f_marketIds->values()->all();
        //return json_encode($marketIds);
        $marketIds=implode(",",json_decode(json_encode($f_marketIds)));

        $url1=$this->host.':8002/api/dream/'.$marketIds;
        //$res='test';
        $res=$this->curl($url1);
        $index=0;
        $res2=array();
        $fancyBets=array();
        if (count($f_marketIds)>0)
        foreach ($res as $item){
            $marketId=$f_marketIds[$index];
            $index++;
            if ($item==null)continue;
            $res2[]=['marketId'=>$marketId,'runners'=>$item->session];
            $is_market=Market::where([['marketId',$marketId],['marketType','fancy']])->value('id');
            $event_id=Market::where([['marketId',$marketId]])->value('event_id');
            if(!isset($is_market))
            {
                $market=new Market();
                $market->marketId=$marketId;
                $market->marketType='fancy';
                $market->event_id=$event_id;
                $market->marketName='Fancy Markets';
                $market->save();
            }
            else{
                $market=Market::find($is_market);
                $market->marketName='Fancy Markets';
                $market->save();
            }

            foreach ($item->session as $item1){
                $is_runner=Runner::where([['market_id',$market->id],['runnerId',$item1->SelectionId]])->value('id');
                if ($is_runner<1){
                    $runner=new Runner();
                    $runner->runnerId=$item1->SelectionId;
                    $runner->runnerName=$item1->RunnerName;
                    $runner->runnerStatus=$item1->GameStatus;
                    $runner->market_id=$market->id;
                    $availableToBack=[];
                    $availableToBack[]=['price'=>$item1->BackPrice1,'size'=>$item1->BackSize1];
                    $availableToLay=[];
                    $availableToLay[]=['price'=>$item1->LayPrice1,'size'=>$item1->LaySize1];
                    $runner->availableToBack=json_encode($availableToBack);
                    $runner->availableToLay=json_encode($availableToLay);
                    $runner->save();
                    $fancyBets[]=$runner;
                }else{
                    $runner=Runner::find($is_runner);
                    if ($runner->state==1)continue;
                    $runner->runnerId=$item1->SelectionId;
                    $runner->runnerName=$item1->RunnerName;
                    $runner->runnerStatus=$item1->GameStatus;
                    $availableToBack=[];
                    $availableToBack[]=['price'=>$item1->BackPrice1,'size'=>$item1->BackSize1];
                    $availableToLay=[];
                    $availableToLay[]=['price'=>$item1->LayPrice1,'size'=>$item1->LaySize1];
                    $runner->availableToBack=json_encode($availableToBack);
                    $runner->availableToLay=json_encode($availableToLay);
                    $runner->save();
                    $fancyBets[]=$runner;
                }
            }
        }
        return \response(json_encode(['count'=>$r_count,'request url'=>$url,'request url1'=>$url1,'data'=>$res2,'data1'=>$f_marketIds,'note'=>['link' => $res1, 'message' => 'update odd', 'type' => 'update odd', 'user_type' => 'users'],'matchedBet'=>$matchedBet,'fancyBets'=>$fancyBets,'markets'=>$markets,'insert_runners'=>$insert_runners]));
    }
    public function insertRunner(){
        $api=new ApiController();
        $res1=array();
        $matchedBet=array();
        $market_id=\request('market_id');
        $runners=json_decode(json_encode(\request('runners')));
        $temp = $api->insertRunner($market_id, $runners);
        $res1 = array_merge($res1, $temp['runners']);
        $matchedBet = array_merge($matchedBet, $temp['matchedBet']);
        return \response(json_encode(['note'=>['link' => $res1, 'message' => 'update odd', 'type' => 'update odd', 'user_type' => 'users'],'matchedBet'=>$matchedBet]));
    }

    private function curl($url)
    {
        //$url = 'https://api.betsapi.com/v1/events/ended?token=YOUR_TOKEN&sport_id=1';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        if ($data === false) {
            $info = curl_getinfo($ch);
            curl_close($ch);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($ch);
        return json_decode($data);
    }
    public function testing(){
        return Market::where('isUpdate', 1)->orWhere('runners', null)->take(200)->toSql();
    }

    public function auth(){
        $email=\request('login_name');
        //$wallet=\request('wallet');
        $is_check=User::where('email',$email)->first();
        if (!isset($is_check))return \response(json_encode(['state'=>400,'description'=>$email.' do not exist user account in exchange']));
        $user=User::find($is_check->id);
        $user->auth_token=str_random(100);
        $user->save();
        return \response(json_encode(['state'=>0,'launch_url'=>url('/').'/auth?id='.$user->id.'&token='.$user->auth_token]));
    }
    /////
    public function login(Request $request){
        $user = User::where('email',$request->email)->first();
        if (empty($user))return $this->response(1,'Can not find your account, Please contact support team to register.',$user);
        if (!Hash::check($request->password,$user->password)){
            return $this->response(1,'Password is wrong',null);
        }
        $user->last_login=Carbon::now();
        $user->login_session=str_random(10);
        $user->save();
        $fireBase = new FirebaseController();
        $device=$this->getDevice($request->header('User-Agent'));
        $msg='Someone have login at '.$device;
        $fireBase->SendNotification('loginCheck/users/'.$user->id, ['link' => '/users/logout', 'message' => $msg, 'userIds' => $user->id,'user_type'=>'users','ip'=>$request->ip(),'device'=>$device,'login_session'=>$user->login_session]);
        //if ($user->state)
        if ($this->isLogin($user->id)==1){
            return $this->response(1,'Your account locked, please contact support team.','');
        }
        return $this->response(0,'Successfully login.',$user);

    }
    public function isLogin($parentId){
        $user=User::find($parentId);
        if ($user->state=='LockAccount') return 1;
        $parentId=$user->parent_id;
        while (true) {
            $rootAdmin = DB::table('admins')->where('id', $parentId)->first();
            if ($rootAdmin->state=='LockAccount') return 1;
            if ($rootAdmin->is_super == 0) break;
            $parentId = $rootAdmin->parent_id;
            if ($parentId == 2) break;
        }
        return 0;
    }
    public function getDevice($user_agent){

        $bname = 'Unknown';
        $platform = 'Unknown';

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
    public function response($state, $message, $data)
    {
        $senddate['state'] = $state;
        $senddate['message'] = $message;
        $senddate['data'] = $data;
        print_r(json_encode($senddate));
    }
}
