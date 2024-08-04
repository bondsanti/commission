<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use App\Models\Role_Log;
use App\Models\News;
use Validator;
use View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return $this->dashboard();
        $roleLog = [];
        if (Auth::user()->role->name == 'Admin') {
            $roleLog = Role_Log::where('approve', 0)->where('reject', 0)->get();
            return view('pages.dashboard')->withRoleLog($roleLog);
        } else {
            // $roleLog = Role_Log::where('approve', 0)->get() ;
            return view('pages.dashboard')->withRoleLog($roleLog);
        }
    }

    public function dashboard()
    {

        $roleLog = [];
        $roleLogReject = [];

        if (Auth::user()->role()->name == 'Admin') {
            $roleLog = Role_Log::where('approve', 0)->where('reject', 0)->get();
            $roleLogReject = Role_Log::where('approve', 0)->where('reject', 1)->get();
        } else {
            // $roleLog = DB::table('role_log')
            //                     ->join('users', 'users.id', 'role_log.user_id')
            //                     ->join('roles as A', 'A.id', 'role_log.role_before_id')
            //                     ->join('roles as B', 'B.id', 'role_log.role_after_id')
            //                     ->select('users.*', 'A.role_before_id as role_before_id', 'B.role_after_id as role_after_id')
            //                     ->get();
            // dd($roleLog);
            // $roleLog = Role_Log::where('approve', 0)->get() ;
        }

        $news = News::get();
        if (Auth::user()->role()->name == 'Team Leader') {
            return redirect('/lists');
        } else {
            return view('pages.dashboard')
            ->withRoleLog($roleLog)
            ->withNews($news)
            ->withRoleLogReject($roleLogReject);
        }
    }

    public function changepassword()
    {
        // return redirect('register')->withErrors($validator);
        return View::make('auth.passwords.change');
    }

    public function messages()
    {
        return [
            'c_password.same' => 'The confirm password and password must match.'
        ];
    }


    public function passwordChange(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'c_password' => 'required|same:password'
        ], $this->messages());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();
        Session::flash('status', 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว');
        return redirect('/');
    }

    public function users()
    {

        $u = DB::connection('user')->table('users')->whereNotNull('old_code')->whereNotNull('old_password')->skip(800)->take(200)->get();

        foreach ($u as $key => $value) {
            // dd([
            //     $value->id,
            //     $value->old_code ,
            //     $value->old_password,
            //     bcrypt($value->old_password)
            //     ]);

            DB::connection('user')->table('users')->where('id', $value->id)->update([
                'password' => bcrypt($value->old_password)
            ]);
        }
    }
}