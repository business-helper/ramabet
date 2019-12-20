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
        $data=DB::table('general_setting')->get();
        foreach ($data as $item) {
            $general_setting[$item->name]=$item->value;
        }
        \View::share('general_setting', $general_setting);
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
        //$sports_list=DB::table('sport_names')->where('is_active','true')->get();
        return view('user/pages/updatedata');
    }
    public function updatedataRunner(){
        return view('user/pages/updatedataRunner');
    }


}
