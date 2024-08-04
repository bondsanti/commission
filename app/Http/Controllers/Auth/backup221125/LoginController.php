<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
 protected $_redirectTo = '/dashboard';

 /**
  * Create a new controller instance.
  *
  * @return void
  */
 public function __construct()
 {
  $this->middleware('guest')->except('logout');
 }

 public function username()
 {
  return 'code';
 }

 protected function _validateLogin(Request $request)
 {
  $request->validate([
   'code' => 'required|string',
   'password' => 'required|string',
  ]);
 }

 public function login(Request $request)
 {

  $this->validateLogin($request);

  // If the class is using the ThrottlesLogins trait, we can automatically throttle
  // the login attempts for this application. We'll key this by the username and
  // the IP address of the client making these requests into this application.
  if ($this->hasTooManyLoginAttempts($request)) {

   $this->fireLockoutEvent($request);

   return $this->sendLockoutResponse($request);
  }

  // if ($this->attemptLogin($request)) {
  //     return $this->sendLoginResponse($request);
  // }

// --- old version ---
         if (
            Auth::attempt(['code' => $request->code, 'password' => $request->password, 'active' => 1]) ||
            Auth::attempt(['old_code' => $request->code, 'password' => $request->password, 'active' => 1])
        ) {
            // The user is active, not suspended, and exists.
            $user = Auth::user();
            if (!$user->role()) {
                Auth::logout();
            }
            if ($user->last_login_at == null) {
                $user->last_login_at = date('Y-m-d H:i:s');
                $user->save();
                return redirect()->route('passwords.firsttime');
            }
// --- old version ---

   DB::table('vbeyond_report.log_login')->insert([
    'username' => Auth::user()->code,
    'dates' => date('Y-m-d'),
    'timeStm' => date('Y-m-d H:i:s'),
    'page' => 'Agent',
    'action' => '1'
   ]);

   $user->last_login_at = date('Y-m-d H:i:s');
   $user->save();
   return $this->sendLoginResponse($request);
  } 
  
  // If the login attempt was unsuccessful we will increment the number of attempts
  // to login and redirect the user back to the login form. Of course, when this
  // user surpasses their maximum number of attempts they will get locked out.
  $this->incrementLoginAttempts($request);

  return $this->sendFailedLoginResponse($request);
 }
}
