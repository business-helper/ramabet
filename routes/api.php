<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
//Route::get('my_first_api','ApiController@my_first_api');
//Route::get('testnotification','ApiController@testnotification');
//Route::get('getInplay','ApiController@getInplay');
//Route::get('updateEventOfSports/{import_id}','ApiController@updateEventOfSports');
//Route::get('updateEventOdd/{import_id}','ApiController@updateEventOdd');
//Route::get('insert_runner/{market_id}','ApiController@insert_runner');

//Route::post('getSeriesList/','ApiController@getSeriesList');
//Route::post('getMatchList/','ApiController@getMatchList');
//Route::post('getMarketList/','ApiController@getMarketList');
//Route::post('getRunners/','ApiController@getRunners');

//Route::post('getSeriesIds/','ApiController@getSeriesIds');
//Route::post('getEventIds/','ApiController@getEventIds');
//Route::post('getMarketApiIds/','ApiController@getMarketApiIds');

Route::group(['middleware' => ['auth:api']], function()
{
    //Route::post('/updateBalance', 'ApiController@updateBalance');
});
Route::post('/updateBalance', 'ApiController@updateBalance');
Route::get('/testing', function (Request $request){
    return response()->json($request->header('User-Agent'));
});
Route::post('testing','ApiController@testing');
Route::post('getEventOfSports','ApiController@getEventOfSports');
Route::post('updateOdd','ApiController@updateOdd');
//Route::post('getEventOfLeague','ApiController@getEventOfLeague');
Route::get('getRunnerOfMatch/{event_id}','ApiController@getRunnerOfMatch');
//Route::get('getBetSlips/{user_id}','ApiController@getBetSlips');
Route::get('getPlacedBetSlips/{user_id}/{market_id?}','ApiController@getPlacedBetSlips');
Route::get('getPlacedBetSlipsAdmin/{user_id}/{market_id?}','ApiController@getPlacedBetSlipsAdmin');
Route::get('getUserPosition/{user_id}','ApiController@getUserPosition');
Route::get('getUPAR/{user_id}/{market_id?}','ApiController@getUPAR');
Route::get('getSettlementOfAdmin/{user_id}/{userType?}','ApiController@getSettlementOfAdmin');
Route::get('getRunnersOfMarket/{id}/{user_id}','ApiController@getRunnersOfMarket');
Route::get('getRunnersOfMarketAdmin/{id}/{user_id}','ApiController@getRunnersOfMarketAdmin');
Route::get('getEventDetail/{id}/{is_active?}','ApiController@getEventDetail');
Route::post('getMarketsOfEvent','ApiController@getMarketsOfEvent');//for app
Route::post('getMultiMarkets','ApiController@getMultiMarkets');//for app
Route::post('getMarketsOfBetslip','ApiController@getMarketsOfBetslip');//for app
Route::post('getFancyMarkets1','ApiController@getFancyMarkets1');//for app
//Route::get('getLeagueOfSport/{id}','ApiController@getLeagueOfSport');
//Route::get('getEventsOfLeague/{id}','ApiController@getEventsOfLeague');
//Route::get('getMarketOfEvent/{id}','ApiController@getMarketOfEvent');
Route::get('getMyMarkets/{id}/{userType}','ApiController@getMyMarkets');
Route::get('getFancyMarkets/{is_super?}','ApiController@getFancyMarkets');
Route::get('getMyMarketsOfBetting/{user_id}/','ApiController@getMyMarketsOfBetting');
Route::get('getMyAccountMarketsOfBetting/{user_id}/','ApiController@getMyAccountMarketsOfBetting');

//Route::get('delBetSlip/{id}','ApiController@delBetSlip');
Route::get('delPlacedBetSlip/{id}','ApiController@delPlacedBetSlip');
//Route::post('createBetSlip','ApiController@createBetSlip');
//Route::post('updateBetSlip/{id}','ApiController@updateBetSlip');
//Route::post('confirmBetSlip','ApiController@confirmBetSlip');
Route::post('confirmBetSlip1','ApiController@confirmBetSlip1');
Route::post('changePassword','ApiController@changePassword');
Route::post('getProfit','ApiController@getProfit');
Route::post('getProfitAdmin','ApiController@getProfitAdmin');
Route::post('setActiveMarket','ApiController@setActiveMarket');
Route::post('setMarketManage','ApiController@setMarketManage');
Route::post('setRunnersVol','ApiController@setRunnersVol');


//Route::get('updateEvent/{import_id}','ApiController@updateEvent');
//Route::get('testcurl','ApiController@testcurl');


//Route::get('bet_result','ApiController@bet_result');
//Route::post('addBetting', array('uses' => 'ApiController@addBetting'));
Route::post('setbetslip', array('uses' => 'ApiController@setbetslip'));
//Route::post('clear_betslip', array('uses' => 'ApiController@clear_betslip'));
Route::post('getbetslip', array('uses' => 'ApiController@getbetslip'));
Route::post('setbetsliplist', array('uses' => 'ApiController@setbetsliplist'));
//Route::post('search', array('uses' => 'ApiController@search'));
Route::post('getEvent', array('uses' => 'ApiController@getEvent'));
//Route::post('/update_user','ApiController@update_user');
Route::post('/add_user','ApiController@add_user');
Route::post('/addMarket','ApiController@addMarket');
Route::post('/getMarket','ApiController@getMarket');
Route::post('/getLeague','ApiController@getLeague');
Route::post('/general_setting', 'ApiController@add_general_setting');

//Route::post('/updateBalance', 'ApiController@updateBalance');
Route::post('/sports_edit', 'ApiController@sports_edit');


Route::post('/main_server', 'ApiController@main_server');

Route::post('acc_statement','ApiController@acc_statement');
Route::post('bethistory','ApiController@bethistory');
Route::post('profitOfUser','ApiController@profitOfUser');

Route::post('/updateBalanceOfAdmin', 'ApiController@updateBalanceOfAdmin');
Route::post('/getMarketOfStatus', 'ApiController@getMarketOfStatus');

Route::post('/addAdmin', 'ApiController@addAdmin');
Route::post('/getAdmins', 'ApiController@getAdmins');
Route::post('/getAdmin', 'ApiController@getAdmin');
Route::post('/depositToChildUser', 'ApiController@depositToChildUser');
Route::post('/getSports', 'ApiController@getSports');
Route::post('/getSeries', 'ApiController@getSeries');
Route::post('/setSport', 'ApiController@setSport');
Route::post('/setSeries', 'ApiController@setSeries');
Route::post('/setSeriesAll', 'ApiController@setSeriesAll');
Route::post('/createMarkets', 'ApiController@createMarkets');
Route::post('/delMarkets', 'ApiController@delMarkets');
Route::post('/setMarketActive', 'ApiController@setMarketActive');
Route::post('/setMarketUpdate', 'ApiController@setMarketUpdate');
Route::post('/setMarketPlay', 'ApiController@setMarketPlay');
Route::post('/setMarketResult', 'ApiController@setMarketResult');
Route::post('/getSettlement', 'ApiController@getSettlement');
Route::post('/setSettlement', 'ApiController@setSettlement');
Route::post('/getProfitUPAR', 'ApiController@getProfitUPAR');
Route::post('/setStake', 'ApiController@setStake');
Route::post('/unDeclare', 'ApiController@unDeclare');
Route::post('/getReport', 'ApiController@getReport');
Route::post('/getProfitBetSlipsAdmin', 'ApiController@getProfitBetSlipsAdmin');
Route::post('/setAccountState', 'ApiController@setAccountState');
Route::get('/getUpLineAdmins/{user_id}', 'ApiController@getUpLineAdmins');
Route::post('/changePasswordAdmin', 'ApiController@changePasswordAdmin');
Route::post('/getScoreBook', 'ApiController@getScoreBook');
Route::post('/getMaxLiabilityOfSession', 'ApiController@getMaxLiabilityOfSession');
Route::post('/setResultOfSession', 'ApiController@setResultOfSession');
Route::post('/updateShowRunner', 'ApiController@updateShowRunner');


//////////////////////
Route::prefix('betfair/v1')->group(function (){
    Route::get('competition_list', 'Api1Controller@competition_list');
    Route::get('getLeagues', 'Api1Controller@getLeagues');
    Route::get('event_list_by_competition/{competition_id}', 'Api1Controller@event_list_by_competition');
    Route::get('getEventIds', 'Api1Controller@getEventIds');
    Route::get('market_catalogue_list/{r_count}', 'Api1Controller@market_catalogue_list');
    Route::get('cricket_extra_market_list/{event_id}', 'Api1Controller@cricket_extra_market_list');
    Route::get('line_market_list/{r_count}', 'Api1Controller@line_market_list');
    Route::get('under_over_goal_market_list/{event_id}', 'Api1Controller@under_over_goal_market_list');
    Route::get('activate_b/{event_id}', 'Api1Controller@activate_b');
    Route::get('getOdd/{r_count}', 'Api1Controller@getOdd');
    Route::get('viewOdd/{marketIds}', 'Api1Controller@viewOdd');
    Route::get('market_book_list/{market_id}', 'Api1Controller@market_book_list');
    Route::get('getSportIds', 'Api1Controller@getSportIds');
    Route::get('testing', 'Api1Controller@testing');
    Route::post('/insertRunner', 'Api1Controller@insertRunner');
});
//////////////////////
Route::prefix('v1')->group(function (){
    Route::post('/login', 'Api1Controller@login');
    Route::post('/setMultiMarket', 'ApiController@setMultiMarket');
    Route::post('/auth', 'Api1Controller@auth');
    Route::post('/updateSportItem', 'Api1Controller@updateSportItem');
});

Route::prefix('v1')->group(function (){
    Route::post('/login', 'Api1Controller@login');
});

//Route::get('db_init','ApiController@db_init');



