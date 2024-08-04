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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/stat/stackedBarChart', 'Api\StatController@stackedBarChart');
Route::get('/stat/handleBarChart', 'Api\StatController@handleBarChart');
Route::get('/stat/handlePieAndDonutChart', 'Api\StatController@handlePieAndDonutChart');

Route::get('/users/teams/{id}', 'Api\UserController@getUsersFromTeam');
Route::get('/users/sub_team/{id}', 'Api\UserController@getUsersFromSub_Team');
Route::get('/users/promote/{id}', 'Api\UserController@getListUsersPromote');

Route::get('/calendars', 'Api\CalendarController@getData');
Route::post('/calendars', 'Api\CalendarController@postData');
Route::put('/calendar/{id}', 'Api\CalendarController@putData');
Route::delete('/calendar/{id}', 'Api\CalendarController@removeData');

Route::get('/commission/{id}', 'Api\CommissionController@commission');
Route::get('/commissionsalein/{id}', 'Api\CommissionController@commissionsalein');
Route::get('/point/{id}', 'Api\CommissionController@point');
Route::get('/pointvp/{id}', 'Api\CommissionController@pointVP');

Route::get('/pointdaily/{id}', 'Api\CommissionController@pointDaily');

Route::post('/users/{id}/comission', 'Api\UserController@updateCommission');
