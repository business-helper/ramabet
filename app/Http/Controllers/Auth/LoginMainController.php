<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Auth;
class LoginMainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function loginWithMainSite(){
        $user=User::find($_GET['id']);
        if (!isset($user)) return 'wrong request';
        if ($_GET['token']!=$user->auth_token)return 'wrong token';
        $user->auth_token=str_random(100);
        $user->save();
        Auth::login($user);
        $user->last_login=\Carbon\Carbon::now();
        $user->login_session=str_random(10);
        $user->save();
        $fireBase = new \App\Http\Controllers\FirebaseController();
        $device="rama333.com";
        $msg='Someone have login at '.$device;
        $fireBase->SendNotification('loginCheck/users/'.$user->id, ['link' => '/users/logout', 'message' => $msg, 'userIds' => $user->id,'user_type'=>'users','ip'=>\request('ip'),'device'=>$device,'login_session'=>$user->login_session]);
        //if ($user->state)
        $loginCon=new \App\Http\Controllers\Auth\LoginController();
        if ($loginCon->isLogin($user->id)==1){
            Auth::guard('web')->logout();
            return 'Your account locked, please contact support team.';
        }
        return redirect('/');
    }

}
