<?php

namespace App\Http\Controllers;

use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Admin;
use Illuminate\Support\Facades\Hash;
use App\Notifications\RepliedToThread;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use League\Flysystem\File;

class PartnerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $auth_admin;
    public function __construct()
    {
        $this->middleware('auth:admin');
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
        return view('partner.Layout.pagetemplate1');

    }



}
