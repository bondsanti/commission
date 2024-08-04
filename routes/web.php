<?php

use App\Models\User;
use Illuminate\Support\Facades\DB; //Query Builder
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
//update
Route::get('3xnjCGjTSGPa6qENUcrbKgHFR57qvaFjQT2KRz2VNarYW6BvHekP3TeE85n9/{code}&{token}', function ($code,$token) {

    $user = User::where('code', '=', $code)->orWhere('old_code', '=', $code)->first();
    if ($user) {

        Auth::login($user);
        $user->token = $token;
        $user->last_login_at = date('Y-m-d H:i:s');
        $user->save();
        $checkToken = User::where('token', '=', $token)->first();
        if ($checkToken) {
            // DB::table('vbeyond_report.log_login')->insert([
            //     'username' => Auth::user()->code,
            //     'dates' => date('Y-m-d'),
            //     'timeStm' => date('Y-m-d H:i:s'),
            //     'page' => 'Agent',
            //     'action' => '1'
            // ]);
            return redirect('/');
        } else {
            Auth::logout();
            return redirect('/');
        }  

    } else {
        return redirect('/');
    }
});

Route::get('/regisform','RegisterAgentController@index')->name('regis.form');

// Route::get('/regisform', function () {
//     return view('registeragent.form');
// });
Route::post('/regis/register','RegisterAgentController@register')->name('regis.register');
Route::get('/get-amphures/{provinceId}', 'RegisterAgentController@getAmphures')->name('get-amphures');
Route::get('/get-districts/{amphureId}', 'RegisterAgentController@getDistricts')->name('get-districts');


Route::middleware('web')->group(function () {
    Route::resource('roles', 'RoleController');
    Route::resource('teams', 'TeamController');
    // Route::resource('sales', 'SaleController');
    Route::resource('subteams', 'SubTeamController');
    Route::resource('users', 'UserController');
    Route::resource('commissions', 'CommissionController');
    Route::resource('commissionssalein', 'CommissionSaleInController');
    Route::resource('settings', 'SettingController');
    Route::resource('news', 'NewsController');
    Route::resource('calendars', 'CalendarController');
    Route::resource('promotions', 'PromotionController');
    Route::resource('projects', 'ProjectController');
    Route::resource('lists', 'ListController');
    Route::resource('salein', 'SaleInController');

    Route::post('/list/search', 'ListController@search')->name('list.search');
    Route::post('commissions/update', 'CommissionController@update')->name('commission.update');
    Route::post('commissionssalein/update', 'CommissionSaleInController@update')->name('commissionssalein.update');
    Route::get('/salein/commissions', 'SaleInController@commissions')->name('salein.commission');
    Route::get('/salein/{salein}/commissions', 'SaleInController@commissions')->name('salein.commission');
    

    Route::get('/', 'HomeController@index');
    Route::get('/users/create/other', 'UserController@createOther')->name('users.other.create');
    Route::post('/users/create/store', 'UserController@storeOther')->name('users.other.store');
    Route::get('/user/search', 'UserController@search')->name('user.search');

    Route::post('/users/{id}/approve', 'UserController@approve')->name('users.approve');
    Route::post('/users/{id}/reject', 'UserController@reject')->name('users.reject');
    Route::get('/commission/search', 'CommissionController@search')->name('commission.search');
    Route::post('/commissions/{id}/paid', 'CommissionController@paid')->name('commissions.paid');
    Route::post('/commissions/{id}/approved', 'CommissionController@approved')->name('commissions.approved');
    Route::post('/commissionssalein/{id}/approved', 'CommissionSaleInController@approved')->name('commissionssalein.approved');
    Route::get('/setting/commissionssalein', 'CommissionSaleInController@setting')->name('commissionssalein.setting');
    Route::post('/setting/commissionssalein/{id}', 'CommissionSaleInController@settingUpdate')->name('commissionssalein.setting.update');
    Route::PUT('/setting/commissionssalein/{id}', 'CommissionSaleInController@settingPut')->name('commissionssalein.setting.put');
    Route::delete('/setting/commissionssalein/{id}', 'CommissionSaleInController@settingDelete')->name('commissionssalein.setting.delete');
    Route::PUT('/setting/point/{key}', 'CommissionSaleInController@settingPoint')->name('commissionssalein.setting.point');


    Route::post('/commissions/{id}/allowance', 'CommissionController@postAllowance')->name('commissionssalein.allowance');
    Route::put('/commissions/{id}/allowance', 'CommissionController@putAllowance')->name('commissionssalein.allowance');


    Route::put('/users/{id}/password', 'UserController@password')->name('users.password');

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

    Route::post('import', 'UserController@importExcel')->name('users.import.excel');
    Route::get('import', 'UserController@getimportExcel');

    Route::get('/oldusers', 'HomeController@users');

    Route::get('/changepassword', 'HomeController@changepassword')->name('passwords.firsttime');
    Route::put('/password/change', 'HomeController@passwordChange')->name('passwords.change');

    Route::get('/user', 'UserController@getListAgents');

    Route::get('/member', 'RegisterAgentController@list')->name('regis.list');
    Route::get('/member/edit/{id}', 'RegisterAgentController@edit')->name('regis.edit');
    Route::delete('/member/{id}', 'RegisterAgentController@destroy')->name('regis.del');
    Route::post('/member/update', 'RegisterAgentController@update')->name('regis.update');
    Route::post('/member/agent','RegisterAgentController@insertAgent')->name('insert.agent');
    Route::post('/member/reject','RegisterAgentController@reject')->name('regis.reject');


    Route::get('/regis/gen','RegisterAgentController@regiscopy')->name('linkgis');
    Route::get('/regis/{id}','RegisterAgentController@regisbyteam');
    Route::get('/regis/en/{id}','RegisterAgentController@regisbyteam');
    Route::post('/regis/agent','RegisterAgentController@registerBycodeteam')->name('regis.registeam');
    Route::post('/member/agent/byteam','RegisterAgentController@insertAgentbyTeam')->name('insert.agent.byteam');

    Route::group(['prefix' => 'salein'], function () {
        // Route::get('/dashboard', 'SaleInController@dashboard')->name('salein.dashboard');
    });
    /////////
});
