<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\FirebaseController;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function showLoginForm()
    {
        return redirect('/mobile/login');
    }
    public function userLogout()
    {
        Auth::guard('web')->logout();
        return redirect('/mobile/login');
    }
    public function login(Request $request){
        //Validate the form data
        $data=DB::table('general_setting')->get();
        foreach ($data as $item) {
            $general_setting[$item->name]=$item->value;
        }
        if ($general_setting['login']=='no'){
            Auth::guard('web')->logout();
            return redirect('/');
        }
        if ($request->v_code!==$request->v_code1){
            Auth::guard('web')->logout();
            return Redirect::back()->withErrors(['v_code'=>'Error verification code']);
        }
        //Attempt to log the user in
        if (Auth::guard('web')->attempt(['email' => $request->identity, 'password' => $request->password], $request->remember)) {
            $id = Auth::user()->id;
            $user = User::find($id);
            $user->last_login=Carbon::now();
            $user->login_session=str_random(10);
            $user->save();
            $fireBase = new FirebaseController();
            $device=$this->getDevice($request->header('User-Agent'));
            $msg='Someone have login at '.$device;
            $fireBase->SendNotification('loginCheck/users/'.$id, ['link' => '/users/logout', 'message' => $msg, 'userIds' => $id,'user_type'=>'users','ip'=>$request->ip(),'device'=>$device,'login_session'=>$user->login_session]);
            //if ($user->state)
            if ($this->isLogin($user->id)==1){
                Auth::guard('web')->logout();
                return Redirect::back()->withErrors(['v_code'=>'Your account locked, please contact support team.']);
            }
            return redirect('/');
        }else{
            Auth::guard('web')->logout();
            return Redirect::back()->withErrors(['v_code','Error verification code']);
        }
        //return redirect('/');
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

    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'userLogout']]);

    }

    public function username()
    {
        $identity  = request()->get('identity');
        $fieldName = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        request()->merge([$fieldName => $identity]);
        return $fieldName;
    }
    protected function authenticated(Request $request, User $user){
        $user->last_login=Carbon::now();
        $user->save();
        return redirect('/');
    }
    protected function validateLogin(Request $request)
    {
        $this->validate(
            $request,
            [
                'identity' => 'required|string',
                'password' => 'required|string',
            ],
            [
                'identity.required' => 'Username or email is required',
                'password.required' => 'Password is required',
            ]
        );

    }
    protected function sendFailedLoginResponse(Request $request)
    {
        $request->session()->put('login_error', trans('auth.failed'));
        return redirect()->to('mobile/login');
        /*throw ValidationException::withMessages(
            [
                'error' => [trans('auth.failed')],
            ]
        );*/
    }
}
