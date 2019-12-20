<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Input;

class MobileController extends Controller
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
        ini_set('memory_limit', '-1');
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

    }
    public function loginPage(){
        return view('pages.mobile.login');
    }


}
