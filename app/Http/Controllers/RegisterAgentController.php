<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Session;
use App\Models\File;
use App\Models\Log;
use App\Models\Member;
use App\Models\Team;
use App\Models\User;
use App\Models\Tambon;
use Carbon\Carbon;
use Auth;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RegisterAgentController extends Controller
{
    public function index()
    {
        // $provinces = DB::connection('user')->table('provinces')->get();
        // $amphures = [];
        // $districts = [];
        $provinces = Tambon::select('province', 'province_id')->distinct()->get();
        $amphoes = Tambon::select('amphoe', 'amphoe_id')->distinct()->get();
        $tambons = Tambon::select('tambon', 'tambon_id')->distinct()->get();
        // return response()->json([
        //     'amphures'=> $provinces
        //    ]);
        // $provinces = DB::connection('mysql')->table('tambons')->select('province_code')->distinct()->get();
        // $amphoes = DB::connection('mysql')->table('tambons')->select('amphoe_code')->distinct()->get();
        // $tambons = DB::connection('mysql')->table('tambons')->select('tambon_code')->distinct()->get();

        return view('pages.registeragent.index', compact('provinces', 'amphoes', 'tambons'));
    }

    public function list()
    {
        if (Auth::user()->role()->name == 'Admin') {

            $members = Member::wherein('status', [0, 1])->orderBy('id', 'DESC')->get();
            $teams = Team::where('team_status', "=", null)->get();

            // $provinces = DB::connection('user')->table('provinces')->get();
            // $amphures = DB::connection('user')->table('amphures')->get();
            // $districts = DB::connection('user')->table('districts')->get();
            $provinces = Tambon::select('province', 'province_id')->distinct()->get();
            $amphoes = Tambon::select('amphoe', 'amphoe_id')->distinct()->get();
            $tambons = Tambon::select('tambon', 'tambon_id')->distinct()->get();
            // $amphures = [];
            // $districts = [];

            // return response()->json([
            //     'amphures'=> $provinces
            //    ]);


            return view('pages.registeragent.list', compact('members', 'teams', 'provinces', 'amphoes', 'tambons'));
        } elseif (Auth::user()->role()->name == 'Authorizer' || Auth::user()->role()->name == 'Support' || Auth::user()->role()->name == 'AdminAgent' || Auth::user()->role()->name == 'AdminSupport') {


            $id = Auth::user()->id;
            if (Auth::user()->role()->name == 'AdminSupport') {
                $members = Member::wherein('status', [0, 1])->orderBy('id', 'DESC')->get();
            } else {
                $members = Member::wherein('status', [0, 1])->where('agent_by', $id)->orderBy('id', 'DESC')->get();
            }

            $teams = Team::where('team_status', "=", null)->get();

            // $provinces = DB::connection('user')->table('provinces')->get();
            // $amphures = DB::connection('user')->table('amphures')->get();
            // $districts = DB::connection('user')->table('districts')->get();
            $provinces = Tambon::select('province', 'province_code')->distinct()->get();
            $amphoes = Tambon::select('amphoe', 'amphoe_code')->distinct()->get();
            $tambons = Tambon::select('tambon', 'tambon_code')->distinct()->get();
            // $amphures = [];
            // $districts = [];

            // return response()->json([
            //     'amphures'=> $provinces
            //    ]);

            $role_agents = Auth::user()->role()->name;
            return view('pages.registeragent.listbyteam', compact('members', 'teams', 'provinces', 'amphoes', 'tambons', 'role_agents'));
        }
    }

    public function getProvinces()
    {
        $provinces = Tambon::select('province', 'province_id')
            ->distinct()
            ->get();
        return $provinces;
    }
    public function getAmphoes(Request $request)
    {

        $province = $request->get('province_id');
        $amphoes = Tambon::select('amphoe_id', 'amphoe')
            ->where('province_id', $province)
            ->distinct()
            ->get();
        return $amphoes;
    }
    public function getTambons(Request $request)
    {

        $province = $request->get('province_id');
        $amphoe = $request->get('amphoe_id');
        $tambons = Tambon::select('tambon_id', 'tambon')
            ->where('province_id', $province)
            ->where('amphoe_id', $amphoe)
            ->distinct()
            ->get();
        return $tambons;
    }
    public function getZipcodes(Request $request)
    {

        $province = $request->get('province_id');
        $amphoe = $request->get('amphoe_id');
        $tambon = $request->get('tambon_id');
        $zipcodes = Tambon::select('zipcode')
            ->where('province_id', $province)
            ->where('amphoe_id', $amphoe)
            ->where('tambon_id', $tambon)
            ->get();
        return $zipcodes;
    }

    public function edit($id)
    {
        if (Auth::user()->role()->name == 'Admin') {

            $member = Member::where('id', $id)->first();
            $teams = Team::where('team_status', "=", null)->get();

            $provinces = Tambon::select('province', 'province_id')->distinct()->get();
            $amphoes = Tambon::select('amphoe', 'amphoe_id')->distinct()->get();
            $tambons = Tambon::select('tambon', 'tambon_id')->distinct()->get();
            // $provinces = DB::connection('user')->table('provinces')->get();
            // $amphures = DB::connection('user')->table('amphures')->get();
            // $districts = DB::connection('user')->table('districts')->get();



            return view('pages.registeragent.edit', compact('member', 'teams', 'provinces', 'amphoes', 'tambons'));
        } elseif (Auth::user()->role()->name == 'Authorizer' || Auth::user()->role()->name == 'Support' || Auth::user()->role()->name == 'AdminAgent' || Auth::user()->role()->name == 'AdminSupport') {


            // $id = Auth::user()->id;

            $member = Member::where('id', $id)->first();
            $teams = Team::where('team_status', "=", null)->get();

            $provinces = Tambon::select('province', 'province_id')->distinct()->get();
            $amphoes = Tambon::select('amphoe', 'amphoe_id')->distinct()->get();
            $tambons = Tambon::select('tambon', 'tambon_id')->distinct()->get();
            // $provinces = DB::connection('user')->table('provinces')->get();
            // $amphures = DB::connection('user')->table('amphures')->get();
            // $districts = DB::connection('user')->table('districts')->get();


            return view('pages.registeragent.edit', compact('member', 'teams', 'provinces', 'amphoes', 'tambons'));
        }
    }
    public function insertAgent(Request $request)
    {


        ////// gen code agent //////
        $dateNow = date('d/m/Y', strtotime('+543 years'));
        $yearCreate = Carbon::createFromFormat('d/m/Y', $dateNow);
        $year = $yearCreate->year; //ตัดเหลือแค่ปี 66
        $month = str_pad($yearCreate->month, 2, '0', STR_PAD_LEFT); //ถ้าเลขเดือนไม่ถึง 2 หลักให้เติม 0 นำหน้า โดยเติมจากด้านซ้าย
        $lastTwoDigits = substr($year, -2); // ตัดให้เหลือ 2 ตัว ท้าย 2566 => 66

        $user = Member::where('id', $request->id)->first();
        $email = $user->email;

        $team = Team::where('id', $request->team_id)->first();


        $lastAgent = User::where('code', 'like', $team->code_team . '%')
            ->orderBy('code', 'desc')
            ->first();

        $lastAgentMonth = $lastAgent ? substr($lastAgent->code, 6, 2) : '';
        $lastAgentCodeTeam = $lastAgent ? substr($lastAgent->code, 0, 4) : '';


        // เช็คว่ามีการเปลี่ยน เดือน หรือ code_team หรือไม่ ถ้าเปลี่ยนใหม่ให้เริ่มนับรหัส Agent ใหม่เป็น 1
        if ($lastAgentMonth !== $month || $lastAgentCodeTeam !== $team->code_team) {
            $startingCode = 1;
        } else {
            $lastAgentNumber = substr($lastAgent->code, -3);
            $startingCode = intval($lastAgentNumber) + 1;
        }

        //create patten code agent
        $userCode = $team->code_team . $lastTwoDigits . $month . str_pad($startingCode, 3, '0', STR_PAD_LEFT);
        //dd($userCode);

        $randomPassword = Str::random(8);
        //dd($randomPassword);


        $sale = new User;

        $sale->name_th = $user->name_th;
        $sale->name_eng = $user->name_eng;
        $sale->email = $user->email;
        $sale->idcard = str_replace('-', '', $user->idcard);
        $sale->address = $user->address;
        $sale->district_id = $user->district_id;
        $sale->amphur_id = $user->amphur_id;
        $sale->province_id = $user->province_id;
        $sale->postcode = $user->postcode;
        $sale->bank_name = $user->bank_name;
        $sale->bank_account = $user->bank_account;
        $sale->lineid = $user->lineid;
        $sale->phone = str_replace('-', '', $user->phone);
        $sale->department_id = 14; //agent
        $sale->position_id = 71; //position agent
        $sale->active_agent = 1;
        $sale->team_id = $request->team_id;
        $sale->company_id = 1; //vbeyond

        $sale->created_at = date('Y-m-d');
        $sale->password = bcrypt($randomPassword);
        $sale->code = $userCode;
        $sale->active = 1;
        $sale->save();


        DB::table('role_user')->insert([
            'role_id' => 71,
            'user_id' => $sale->id
        ]);
        $lsale = [];
        $lsale = json_encode($sale);

        $log = new Log;
        $log->action = 'Appove Agent';
        $log->new = $lsale;
        $log->user_id = $sale->id;
        $log->save();

        $user->code = $userCode;
        $user->status = 1;
        $user->save();


        if ($user->file_contract !== "") {

            $file_user = $user->file_register . "," . $user->file_legal . "," . $user->file_contract;
            $file_array = explode(',', $file_user);

            foreach ($file_array as $fileName) {
                $file = new File;
                $file->name = $fileName;
                // You may need to modify the URL logic if the existing files have different paths
                $file->url = $fileName;
                $file->user_id = $sale->id;
                $file->save();
            }
        } else {
            $file = new File;
            $file->name = $user->file_register;
            // You may need to modify the URL logic if the existing files have different paths
            $file->url = $user->file_register;
            $file->user_id = $sale->id;
            $file->save();
        }




        $latestUser = User::orderBy('id', 'desc')->first();
        //dd($latestUser);


        //ส่ง Mail
        Mail::send(
            'pages.registeragent.mail',
            ['Link' => 'https://vbagent.vbeyond.co.th', 'users' => $latestUser, 'teams' => $team, 'Pass' => $randomPassword],
            function (Message $message) use ($email) {
                $message->to($email)
                    ->subject('ตัวแทนอสังหาริมทรัพย์กับทาง V Beyond Developments Public Co.,Ltd.');
            }
        );







        Session::flash('success', 'อนุมัติ เรียบร้อย');
        return redirect()->back();

        // return redirect('/');





    }

    public function register(Request $request)
    {

        //dd($request->inlineRadioOptions);
        //$request->file_register;
        $request->validate(
            [
                'inlineRadioOptions' => 'required',
                'idcard' => 'required',
                'name_th' => 'required',
                'name_eng' => 'required',
                'email' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'province_id' => 'required',
                'amphur_id' => 'required',
                'district_id' => 'required',
                'bank_name' => 'required',
                'postcode' => 'required',
                'bank_account' => 'required',
                'lineid'    => 'required',
                'file_register' => 'required|file|mimes:jpg,jpeg,png,pdf',
                'file_legal' => 'file|mimes:jpg,jpeg,png,pdf',
            ]
        );

        $member = Member::where('idcard', $request->idcard)->count();
        //$user = User::where('idcard', $request->idcard)->count();

        // if ($user > 0) {

        //     Session::flash('error', 'เลขบัตรประชาชนซ้ำ');
        //     return redirect()->back();
        //  }
        $randomStr = Str::random(15);

        if ($member > 0) {

            Session::flash('error', 'เลขบัตรประชาชนซ้ำ');
            return redirect()->back();
        }

        if ($request->hasFile('file_legal')) {
            $fileLegal = $request->file('file_legal');
            $fileLegalExtension = $fileLegal->getClientOriginalExtension();

            // Check if the file extension is allowed
            if (in_array($fileLegalExtension, ['jpg', 'jpeg', 'png', 'pdf'])) {
                $fileNameLegal = 'legal_' . time() . $randomStr . '.' . $fileLegalExtension;
                $fileLegal->move(public_path('/storage/file/'), $fileNameLegal);
                $file_legal = asset('/storage/file/' . $fileNameLegal);
                // Perform any further processing or database operations as needed
            } else {
                Session::flash('error', 'Allowed types: jpg, jpeg, png, pdf');
                return redirect()->back();
            }
        } else {
            $file_legal = ''; // Set to empty if no file is uploaded
        }


        if ($request->hasFile('file_register')) {
            $fileRegister = $request->file('file_register');
            $fileRegisterExtension = $fileRegister->getClientOriginalExtension();

            // Check if the file extension is allowed
            if (in_array($fileRegisterExtension, ['jpg', 'jpeg', 'png', 'pdf'])) {
                $fileNameRegister = 'regis_' . time() . $randomStr . '.' . $fileRegisterExtension;
                $fileRegister->move(public_path('/storage/file/'), $fileNameRegister);
                $file_register = asset('/storage/file/' . $fileNameRegister);
                //dd($file_register);
            } else {
                Session::flash('error', 'Allowed types: jpg, jpeg, png, pdf');
                return redirect()->back();
            }
        } else {
            $file_register = ''; // Set to empty if no file is uploaded
        }


        $register = new Member;
        $register->regis_type = $request->inlineRadioOptions;
        $register->name_th = $request->name_th;
        $register->name_eng = $request->name_eng;
        $register->email = $request->email;
        $register->idcard = str_replace('-', '', $request->idcard);
        $register->address = $request->address;
        $register->district_id = $request->district_id;
        $register->amphur_id = $request->amphur_id;
        $register->province_id = $request->province_id;
        $register->postcode = $request->postcode;
        $register->bank_name = $request->bank_name;
        $register->lineid = $request->lineid;
        $register->bank_account = $request->bank_account;
        $register->phone = str_replace('-', '', $request->phone);
        $register->created_at = date('Y-m-d H:i:s');
        $register->file_register =  $file_register;
        $register->file_legal = $file_legal;
        $register->status = 0;
        $register->save();

        $log = new Log;
        $log->action = 'Register';
        $log->new = $register->id;
        $log->user_id = '0';
        $log->save();




        if ($register) {
            Session::flash('success', 'สมัครสมาชิกสำเร็จ');
            return redirect()->back();
        } else {
            Session::flash('error', 'ไม่สามารถสมัครสมัครชิกได้');
            return redirect()->back();
        }

        // return redirect('/');





    }


    public function destroy($id)
    {
        // $user = Member::find($id);
        // unlink(asset('storage/file/' . $user->file_register)); // ลบภาพเก่า
        // unlink(asset('storage/file/' . $user->file_legal)); // ลบภาพเก่า
        // $user->delete();



        // $log = new Log;
        // $log->user_id = Auth::id();
        // $log->action = 'delete';
        // $log->old = $user;
        // $log->save();

        // if ($user) {
        //     Session::flash('success', 'ลบข้อมูลสำเร็จ');
        //     return redirect()->back();
        // }
        $user = Member::find($id);

        if ($user) {
            // ลบภาพเก่า
            Storage::delete('file/' . $user->file_register);
            Storage::delete('file/' . $user->file_legal);

            // ลบข้อมูลสมาชิก
            $user->status = 5;
            $user->save();

            // บันทึก log
            $log = new Log;
            $log->user_id = Auth::id();
            $log->action = 'delete';
            $log->old = $user;
            $log->save();

            Session::flash('success', 'ลบข้อมูลสำเร็จ');
        } else {
            Session::flash('error', 'ไม่พบข้อมูลสมาชิก');
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $randomStr = Str::random(15);
        $user = Member::where('id', $request->id)->first();
        if ($request->hasFile('file_legal')) {
            $fileLegal = $request->file('file_legal');
            $fileLegalExtension = $fileLegal->getClientOriginalExtension();

            // Check if the file extension is allowed
            if (in_array($fileLegalExtension, ['jpg', 'jpeg', 'png', 'pdf'])) {
                $fileNameLegal = 'legal_' . time() . $randomStr . '.' . $fileLegalExtension;
                $fileLegal->move(public_path('/storage/file/'), $fileNameLegal);
                $file_legal = asset('/storage/file/' . $fileNameLegal);
                // Perform any further processing or database operations as needed
            } else {
                Session::flash('error', 'Allowed types: jpg, jpeg, png, pdf');
                return redirect()->back();
            }
        } else {
            $file_legal = ''; // Set to empty if no file is uploaded
        }


        if ($request->hasFile('file_register')) {
            $fileRegister = $request->file('file_register');
            $fileRegisterExtension = $fileRegister->getClientOriginalExtension();

            // Check if the file extension is allowed
            if (in_array($fileRegisterExtension, ['jpg', 'jpeg', 'png', 'pdf'])) {
                $fileNameRegister = 'regis_' . time() . $randomStr . '.' . $fileRegisterExtension;
                $fileRegister->move(public_path('/storage/file/'), $fileNameRegister);
                $file_register = asset('/storage/file/' . $fileNameRegister);
                //dd($file_register);
            } else {
                Session::flash('error', 'Allowed types: jpg, jpeg, png, pdf');
                return redirect()->back();
            }
        } else {
            $file_register = ''; // Set to empty if no file is uploaded
        }

        if ($request->hasFile('file_contract')) {
            $fileContract = $request->file('file_contract');
            $fileContractExtension = $fileContract->getClientOriginalExtension();

            // Check if the file extension is allowed
            if (in_array($fileContractExtension, ['jpg', 'jpeg', 'png', 'pdf'])) {
                $fileNameContract = 'legal_' . time() . $randomStr . '.' . $fileContractExtension;
                $fileContract->move(public_path('/storage/file/'), $fileNameContract);
                $file_contract = asset('/storage/file/' . $fileNameContract);
                // Perform any further processing or database operations as needed
            } else {
                Session::flash('error', 'Allowed types: jpg, jpeg, png, pdf');
                return redirect()->back();
            }
        } else {
            $file_contract = ''; // Set to empty if no file is uploaded
        }


        $sale = User::where('code', $request->code)->first();
        if ($request->file_register) {
            $user->file_register = $file_register;
        }

        if ($request->file_legal) {
            $user->file_legal = $file_legal;
        }

        if ($request->file_contract) {
            $user->file_contract = $file_contract;
        }
        $user->name_th = $request->name_th;
        $user->name_eng = $request->name_eng;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->idcard = $request->idcard;
        $user->province_id = $request->province_id;
        $user->amphur_id = $request->amphur_id;
        $user->district_id = $request->district_id;
        $user->address = $request->address;
        $user->postcode = $request->postcode;
        $user->bank_name = $request->bank_name;
        $user->lineid = $request->lineid;
        $user->save();



        $files = new File;
        $files->file_register = $user->file_register;
        $files->file_legal = $user->file_legal;
        $files->file_contract = $user->file_contract;
        if ($sale == null) {
            $id = $user->id;
        } else {
            $id = $sale->id;
        }
        $files->user_id = $id;
        $files->save();


        $log = new Log;
        $log->user_id = Auth::id();
        $log->action = 'update';
        $log->old = $user;
        $log->save();

        if ($user) {
            Session::flash('success', 'อัพเดทข้อมูลสำเร็จ!');
            return redirect()->back();
        }
    }

    public function reject(Request $request)
    {
        $user = Member::where('id', $request->id)->first();

        $user->status = 2;
        $user->save();



        $log = new Log;
        $log->user_id = Auth::id();
        $log->action = 'reject';
        $log->old = $user;
        $log->save();

        if ($user) {
            Session::flash('success', 'อัพเดทข้อมูลสำเร็จ!');
            return redirect()->back();
        }
    }

    public function regisbyteam(Request $request, $id)
    {

        $users = DB::connection('user')
            ->table('users')->where('id', $id)
            ->select('id')
            ->first();
        //dd($users);
        // $provinces = DB::connection('user')->table('provinces')->get();
        $provinces = Tambon::select('province', 'province_id')->distinct()->get();
        $amphoes = Tambon::select('amphoe', 'amphoe_id')->distinct()->get();
        $tambons = Tambon::select('tambon', 'tambon_id')->distinct()->get();

        // $amphures = [];
        // $districts = [];

        // return response()->json([
        //     'amphures'=> $provinces
        //    ]);
        return view('pages.linkregis.register', compact('users', 'provinces', 'amphoes', 'tambons'));
    }


    public function regiscopy(Request $request)
    {

        $users = DB::connection('user')
            ->table('users')->where('id', Auth::user()->id)
            ->select('id', 'code')
            ->first();
        return view('pages.linkregis.linkregis', compact('users'));
    }

    public function registerBycodeteam(Request $request)
    {

        $request->validate(
            [
                'inlineRadioOptions' => 'required',
                'idcard' => 'required',
                'name_th' => 'required',
                'name_eng' => 'required',
                'email' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'province_id' => 'required',
                'amphur_id' => 'required',
                'district_id' => 'required',
                'bank_name' => 'required',
                'postcode' => 'required',
                'bank_account' => 'required',
                'lineid' => 'required',
                'file_register' => 'required|file|mimes:jpg,jpeg,png,pdf',
                'file_legal' => 'file|mimes:jpg,jpeg,png,pdf',
            ]
        );

        $memberId = Member::where('idcard', $request->idcard)->count();
        $memberEmail = Member::where('email', $request->email)->count();
        $memberPhone = Member::where('phone', $request->phone)->count();
        $randomStr = Str::random(15);

        if ($memberId > 0) {

            Session::flash('error', 'เลขบัตรประชาชนนี้ เคยลงทะเบียนแล้ว');

            return redirect()->back();
        }
        if ($memberEmail > 0) {

            Session::flash('error', 'Email นี้ เคยลงทะเบียนแล้ว');

            return redirect()->back();
        }
        if ($memberPhone > 0) {

            Session::flash('error', 'เบอร์โทรศัพท์ นี้ เคยลงทะเบียนแล้ว');

            return redirect()->back();
        }

        if ($request->hasFile('file_legal')) {
            $fileLegal = $request->file('file_legal');
            $fileLegalExtension = $fileLegal->getClientOriginalExtension();

            // Check if the file extension is allowed
            if (in_array($fileLegalExtension, ['jpg', 'jpeg', 'png', 'pdf'])) {
                $fileNameLegal = 'legal_' . time() . $randomStr . '.' . $fileLegalExtension;
                $fileLegal->move(public_path('/storage/file/'), $fileNameLegal);
                $file_legal = asset('/storage/file/' . $fileNameLegal);
                // Perform any further processing or database operations as needed
            } else {
                Session::flash('error', 'Allowed types: jpg, jpeg, png, pdf');
                return redirect()->back();
            }
        } else {
            $file_legal = ''; // Set to empty if no file is uploaded
        }


        if ($request->hasFile('file_register')) {
            $fileRegister = $request->file('file_register');
            $fileRegisterExtension = $fileRegister->getClientOriginalExtension();

            // Check if the file extension is allowed
            if (in_array($fileRegisterExtension, ['jpg', 'jpeg', 'png', 'pdf'])) {
                $fileNameRegister = 'regis_' . time() . $randomStr . '.' . $fileRegisterExtension;
                $fileRegister->move(public_path('/storage/file/'), $fileNameRegister);
                $file_register = asset('/storage/file/' . $fileNameRegister);
                //dd($file_register);
            } else {
                Session::flash('error', 'Allowed types: jpg, jpeg, png, pdf');
                return redirect()->back();
            }
        } else {
            $file_register = ''; // Set to empty if no file is uploaded
        }

        $register = new Member;
        $register->agent_by = $request->id; // Subteam
        $register->regis_type = $request->inlineRadioOptions;
        $register->name_th = $request->name_th;
        $register->name_eng = $request->name_eng;
        $register->email = $request->email;
        $register->idcard = str_replace('-', '', $request->idcard);
        $register->address = $request->address;
        $register->district_id = $request->district_id;
        $register->amphur_id = $request->amphur_id;
        $register->province_id = $request->province_id;
        $register->postcode = $request->postcode;
        $register->bank_name = $request->bank_name;
        $register->lineid = $request->lineid;
        $register->bank_account = $request->bank_account;
        $register->phone = str_replace('-', '', $request->phone);
        $register->created_at = date('Y-m-d H:i:s');
        $register->file_register =  $file_register;
        $register->file_legal = $file_legal;
        $register->status = 0;
        $register->save();

        $log = new Log;
        $log->action = 'Register';
        $log->new = $register->id;
        $log->user_id = '0';
        $log->save();



        if ($register) {
            Session::flash('success', 'สมัครสมาชิกสำเร็จ');
            return redirect()->back();
        } else {

            Session::flash('error', 'ไม่สามารถสมัครสมัครชิกได้');
            return redirect()->back();
        }
    }

    public function insertAgentbyTeam(Request $request)
    {


        ////// gen code agent //////
        $dateNow = date('d/m/Y', strtotime('+543 years'));
        $yearCreate = Carbon::createFromFormat('d/m/Y', $dateNow);
        $year = $yearCreate->year; //ตัดเหลือแค่ปี
        $month = str_pad($yearCreate->month, 2, '0', STR_PAD_LEFT); //ถ้าเลขเดือนไม่ถึง 2 หลักให้เติม 0 นำหน้า โดยเติมจากด้านซ้าย
        $lastTwoDigits = substr($year, -2); // ตัดให้เหลือ 2 ตัว ท้าย 2566 => 66



        // $subteam = $user->subteam; //VBMN6609001
        // $cutnumber = substr($subteam, 0, 4); // เลือกตั้งแต่ตำแหน่งที่ 0 ถึง 3 คือ "VBMN"
        $user = Member::where('id', $request->id)->first();
        $email = $user->email;

        $team = Team::where('id', $request->team_id)->first();


        $lastAgent = User::where('code', 'like', $team->code_team . '%')
            ->orderBy('code', 'desc')
            ->first();

        if ($team) {

            $lastAgent = User::where('code', 'like', $team->code_team . '%')
                ->orderBy('code', 'desc')
                ->first();
            // $lastAgent = User::orderBy('id', 'desc')->first();
            //dd($lastAgent);

            $lastAgentMonth = $lastAgent ? substr($lastAgent->code, 6, 2) : '';
            $lastAgentCodeTeam = $lastAgent ? substr($lastAgent->code, 0, 4) : '';


            // เช็คว่ามีการเปลี่ยน เดือน หรือ code_team หรือไม่ ถ้าเปลี่ยนใหม่ให้เริ่มนับรหัส Agent ใหม่เป็น 1
            if ($lastAgentMonth !== $month || $lastAgentCodeTeam !== $team->code_team) {
                $startingCode = 1;
            } else {
                $lastAgentNumber = substr($lastAgent->code, -3);
                $startingCode = intval($lastAgentNumber) + 1;
            }

            //create patten code agent
            $userCode = $team->code_team . $lastTwoDigits . $month . str_pad($startingCode, 3, '0', STR_PAD_LEFT);
            // dd($userCode);

            $randomPassword = Str::random(8);
            //dd($randomPassword);


            $sale = new User;

            $sale->name_th = $user->name_th;
            $sale->name_eng = $user->name_eng;
            $sale->email = $user->email;
            $sale->idcard = str_replace('-', '', $user->idcard);
            $sale->address = $user->address;
            $sale->district_id = $user->district_id;
            $sale->amphur_id = $user->amphur_id;
            $sale->province_id = $user->province_id;
            $sale->postcode = $user->postcode;
            $sale->bank_name = $user->bank_name;
            $sale->bank_account = $user->bank_account;
            $sale->lineid = $user->lineid;
            $sale->phone = str_replace('-', '', $user->phone);
            $sale->department_id = 14; //agent
            $sale->position_id = 71; //position agent
            $sale->active_agent = 1;
            $sale->team_id = $team->id; //ทีม Agent
            $sale->agent_by = $request->agent_by;

            $sale->company_id = 1; //vbeyond

            $sale->created_at = date('Y-m-d');
            $sale->password = bcrypt($randomPassword);
            $sale->code = $userCode;
            $sale->active = 1;
            $sale->save();


            DB::table('role_user')->insert([
                'role_id' => 71,
                'user_id' => $sale->id
            ]);
            $lsale = [];
            $lsale = json_encode($sale);

            $log = new Log;
            $log->action = 'Appove Agent';
            $log->new = $lsale;
            $log->user_id = $sale->id;
            $log->save();

            $files = File::where('user_id', $request->id)->first();
            $files->user_id = $sale->id;
            $files->save();

            $user->code = $userCode;
            $user->status = 1;
            $user->save();

            $latestUser = User::orderBy('id', 'desc')->first();

            //ส่ง Mail
            Mail::send(
                'pages.registeragent.mail',
                ['Link' => 'https://vbagent.vbeyond.co.th', 'users' => $latestUser, 'teams' => $team, 'Pass' => $randomPassword],
                function (Message $message) use ($email) {
                    $message->to($email)
                        ->subject('ตัวแทนอสังหาริมทรัพย์กับทาง V Beyond Developments Public Co.,Ltd.');
                }
            );


            Session::flash('success', 'อนุมัติ เรียบร้อย');
            return redirect()->back();
        } else {

            Session::flash('error', 'เกิดข้อผิดพลาด กรุณาตรวจสอบ Code Team');
            return redirect()->back();
        }
    }
}
