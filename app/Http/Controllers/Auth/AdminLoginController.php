<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\FirebaseController;
use App\Admin;
use Carbon\Carbon;

class AdminLoginController extends Controller
{
    protected $name = 'name';
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
        $data=DB::table('general_setting')->get();
        foreach ($data as $item) {
            $general_setting[$item->name]=$item->value;
        }
        \View::share('general_setting', $general_setting);
    }
    public function showLoginForm(){
        return view('admin.pages.login');
    }
    public function login(Request $request){
        //Validate the form data
        /*$this->validate($request,[
            'name'=>'required|name',
            'password'=>'required|min:6',
        ]);*/
        //Attempt to log the user in

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $id = Admin::where('email',$request->email)->value('id');
            $user = Admin::find($id);
            $user->last_login=Carbon::now();
            $user->login_session=str_random(10);
            $user->save();
            $fireBase = new FirebaseController();
            $device=$this->getDevice($request->header('User-Agent'));
            $msg='Someone have login at '.$device;
            $fireBase->SendNotification('loginCheck/admins/'.$id, ['link' => '/admin/logout', 'message' => $msg, 'userIds' => $id,'user_type'=>'admins','ip'=>$request->ip(),'device'=>$device,'login_session'=>$user->login_session]);
            if ($this->isLogin($id)==1){
                Auth::guard('admin')->logout();
                return redirect()->back()->withErrors(['LockAccount'=>'Your account locked, Please contact support team.']);
            }
            return redirect('/admins');
            //return redirect()->intended(route('admin.dashboard'));
        }
        //return 'wrong';
        return redirect()->back()->withInput($request->only('password','remember'));

    }
    public function isLogin($parentId){
        while (true) {
            $rootAdmin = DB::table('admins')->where('id', $parentId)->first();

            if ($rootAdmin->state=='LockAccount') return 1;
            if ($rootAdmin->is_super == 0) break;
            $parentId = $rootAdmin->parent_id;
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
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

}
