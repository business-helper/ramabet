<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\RepliedToThread;
use App\Admin;
use Illuminate\Http\Request;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*Auth::routes(['register' => false]);*/

        $this->middleware('guest');


    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */




    public function register(Request $request) {
        $data=DB::table('general_setting')->get();
        foreach ($data as $item) {
            $general_setting[$item->name]=$item->value;
        }
        if ($general_setting['registration']=='no'){
            return redirect('/');
        }
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = $this->create($request->all());
        $admin=Admin::where('id','2')->first();
        $notification_data='';
        $notification_data['type']='register';
        $notification_data['message']=$user->name.' have registe just now';
        $admin->notify(new RepliedToThread($user,$notification_data));
        // Sending email, sms or doing anything you want


        return redirect('/login')->with('message', 'We sent a comfirmation email to your email, please click on link inside before login');
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        /*$admin=Admin::where('id','2')->first();
        $notification_data='';
        $notification_data['type']='betting';
        $notification_data['message']=$data['name'].' resisted to your site';
        $admin->notify(new RepliedToThread($data,$notification_data));*/
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
