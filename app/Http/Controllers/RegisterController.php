<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\File;
use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function index()
    {
        $provinces = DB::connection('user')->table('provinces')->get();
 

        $amphures = [];
        $districts = [];

        // return response()->json([
        //     'amphures'=> $provinces
        //    ]);
    
        return view('register.index', compact('provinces', 'amphures', 'districts'));
    }

    public function getAmphures($provinceId)
    {
        $amphures = DB::connection('user')->table('amphures')->where('province_id', $provinceId)->get();

       return response()->json([
        'amphures'=> $amphures
       ]);
    }

    public function getDistricts($amphureId)
    {
        $districts = DB::connection('user')->table('districts')->where('amphur_id', $amphureId)->get();
 
        return response()->json([
            'districts'=> $districts
           ]);
    }


    public function insert(Request $request)
    {

        //dd($request->file_register);
        //$request->file_register;
        $request->validate(
            [
                'idcard' => 'required',
                'name_th' => 'required',
                'name_eng'=> 'required',
                'email'=> 'required',
                'address' => 'required',
                'phone' => 'required',
                'province_id'=>'required',
                'amphur_id'=>'required',
                'district_id'=>'required',
                'bank_name'=>'required',
                'bank_account'=>'required',
                'file_register' => 'required|file|mimes:jpg,jpeg,png,pdf',
            ]
        );

        $user = User::where('idcard', $request->idcard)->count();
        //dd($user);
        if ($user > 0) {
           
           Session::flash('Error', 'เลขบัตรประชาชนซ้ำ');
           return redirect()->back();
        }

                ////// gen code agent //////
        $dateNow = date('d/m/Y', strtotime('+543 years'));
        $yearCreate = Carbon::createFromFormat('d/m/Y',$dateNow);
        $year = $yearCreate->year; //ตัดเหลือแค่ปี
        $month = str_pad($yearCreate->month, 2, '0', STR_PAD_LEFT); //ถ้าเลขเดือนไม่ถึง 2 หลักให้เติม 0 นำหน้า โดยเติมจากด้านซ้าย
        $lastTwoDigits = substr($year, -2); // ตัดให้เหลือ 2 ตัว ท้าย 2566 => 66

        $code_team = "VBDA";

        //ถ้าไม่มี code_team
        // if($code_team==""){
        //     Session::flash('Status', 'Error! Code_team Is Null');
        //     return redirect()->back();
        // }

        $lastAgent = User::orderBy('id', 'desc')->first();
        $lastAgentMonth = $lastAgent ? substr($lastAgent->code, 6, 2) : '';
        $lastAgentCodeTeam = $lastAgent ? substr($lastAgent->code, 0, 4) : '';


        // เช็คว่ามีการเปลี่ยน เดือน หรือ code_team หรือไม่ ถ้าเปลี่ยนใหม่ให้เริ่มนับรหัส Agent ใหม่เป็น 1
        if ($lastAgentMonth !== $month || $lastAgentCodeTeam !== $code_team) {
            $startingCode = 1;
        } else {
            $lastAgentNumber = substr($lastAgent->code, -3);
            $startingCode = intval($lastAgentNumber) + 1;
        }

        //create patten code agent
        $userCode = $code_team.$lastTwoDigits.$month.str_pad($startingCode, 3, '0', STR_PAD_LEFT);
        //dd($userCode);
        $sale = new User;

        $sale->name_th = $request->name_th;
        $sale->name_eng = $request->name_eng;
        $sale->email = $request->email;
        $sale->idcard = str_replace('-', '', $request->idcard);
        $sale->address = $request->address;
        $sale->district_id = $request->district_id;
        $sale->amphur_id = $request->amphur_id;
        $sale->province_id = $request->province_id;
        $sale->bank_name = $request->bank_name;
        $sale->bank_account = $request->bank_account;
        $sale->phone = str_replace('-', '', $request->phone);
        $sale->department_id = 14;
        $sale->position_id = 71;
        $sale->created_at = date('Y-m-d');
        $sale->password = bcrypt('123456');
        $sale->code = $userCode;
        $sale->active = 1;
        $sale->save();


        DB::table('role_user')->insert([
            'role_id' => 71,
            'user_id' => $sale->id
        ]);

        $sale->save();
        $log = new Log;
        $log->action = 'Register';
        $log->new = $sale;
        $log->user_id = $sale->id;
        $log->save();




        if ($request->hasFile('file_register')) {
            foreach ($request->file('file_register') as $key => $value) {
                $path = $value->store('public/file');
                $file = new File;
                $file->name = $value;
                $path = str_replace('public', 'storage', $path);
                $file->url =  config('app.url') . '/' . $path;
                $file->user_id =  $sale->id;
                $file->save();
            }
        }

        Session::flash('Success', 'สมัครสมาชิกสำเร็จ');
        return redirect()->back();
        
        // return redirect('/');
        
      



    }


    
}
