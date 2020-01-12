<?php
use Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Crypt;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//$data=DB::table('general_setting')->get();

/*foreach ($data as $item) {
    $general_setting[$item->name]=$item->value;
}
\View::share('general_setting', $general_setting);*/
/*Route::get('/testview', function () {
    return view('welcome');
});*/
//Route::get('firebase','FirebaseController@index');
//Route::get('/sport/{id}', 'HomeController@sport_page')->name('sport_page');
//Route::get('/league/{id}', 'HomeController@league_page')->name('league_page');
//Route::get('/event/{id}/{market_type?}', 'HomeController@event_page')->name('event_page');
Route::get('/updatedata', 'HomeController@updatedata')->name('updatedata');
Route::get('/updatedataRunner', 'HomeController@updatedataRunner')->name('updatedata');
Auth::routes();

//Route::get('/register', 'Auth\RegisterController@showLoginForm')->name('register');
//Route::post('/register', 'Auth\RegisterController@login')->name('register.submit');
Route::get('/auth','Auth\LoginMainController@loginWithMainSite')->name('auth_login');

Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');
/*Route::get('/markAsRead/{id}',function ($id){
    auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
});*/
Route::prefix('')->group(function (){
//    Route::get('/', 'MobileController@index')->name('home_mobile');
//    Route::get('promotions/', 'MobileController@promotions')->name('promotions_mobile');
    Route::get('mobile/login','MobileController@loginPage')->name('mobile_login');
//    Route::get('/event/detail/{fixtureid}', 'MobileController@eventDetail_page')->name('eventdetail_mobile');
//    Route::get('/cricket', 'MobileController@cricket_page')->name('cricket_mobile');
//    Route::get('/soccer', 'MobileController@soccer_page')->name('soccer_mobile');
//    Route::get('/tennis', 'MobileController@tennis_page')->name('tennis_mobile');
//    Route::get('/in-play', 'MobileController@in_play_page')->name('in_play_mobile');
//    Route::get('/sports',function(){
//        $data=DB::table('general_setting')->get();
//        foreach ($data as $item) {
//            $general_setting[$item->name]=$item->value;
//        }
//        \View::share('general_setting', $general_setting);
//        $sports_list=DB::table('sport_names')->where('is_active','true')->get();
//        return view('pages.mobile.sports',['sports_list'=>$sports_list]);
//    })->name('sports_mobile');
//    Route::get('/multiMarkets', 'MobileController@multiMarkets_page')->name('multiMarkets_mobile');
//
//    Route::get('account/profile','MobileController@profile_page' )->name('profile_mobile');
//    Route::get('account/bet_history','MobileController@bet_history_page' )->name('bet_history_mobile');
//    Route::get('account/current_bets','MobileController@current_bets_page' )->name('current_bets_mobile');
//    Route::get('account/profit_loss','MobileController@profit_loss_page' )->name('profit_loss_mobile');
//    Route::get('account/summary','MobileController@summary_page' )->name('summary_mobile');
//    Route::get('account/transferredLog','MobileController@transferredLog_page' )->name('transferredLog_mobile');
});
//Route::get('/in-play', 'HomeController@inPlay')->name('inPlay');
//admin route
Route::get('admins/{any?}', 'AdminController@market')->where('any','.*');;
//Route::get('thirdAdmin/{any?}', 'AdminController@market')->where('any','.*');;
Route::get('admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('admin/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
Route::get('admin/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

//Route::get('partners/login', 'Auth\PartnerLoginController@showLoginForm')->name('partners.login');
//Route::post('partners/login', 'Auth\PartnerLoginController@login')->name('partners.login.submit');
//Route::get('partners/logout', 'Auth\PartnerLoginController@logout')->name('partners.logout');
/*Route::get('/{spots?}/{root?}/{league?}/{event_id?}/{market_type?}', 'HomeController@index')->name('home');*/

Route::group(['middleware' => 'auth:partner'], function () {
    //Route::get('partners/{any?}', 'PartnerController@index')->where('any','.*');;
    //Route::get('/{any?}', 'HomeController@index')->name('home')->where('any','.*');;
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/{any?}', 'HomeController@index')->name('home')->where('any','.*');;
});

