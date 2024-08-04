<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Role_Log;
use App\Models\Log;
use App\Models\Team;
use App\Models\sub_team;
use App\Models\Company;
use App\Models\Commission;
use App\Models\File;
use App\Models\Setting;
use App\Imports\UsersImport;
use App\Models\Member;
use App\Models\Tambon;
use Maatwebsite\Excel\Facades\Excel;
use Session;
// use File;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Validator;

class UserController extends Controller
{
    public $limitPerPage = 10;

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $count = 0;
        if (Auth::user()->role()->name == 'Admin' || Auth::user()->role()->name == 'AdminSupport') {

            $data = [];
            $teams = Team::where('team_status', '=', null)->get();
            $totalUserCount = 0;

            // foreach ($teams as $key => $team) {

            //     $userCount = User::where('team_id', $team->id)
            //         ->where('department_id', 14)
            //         ->where('active', 1)
            //         ->whereNull('resign_date')
            //         ->count();

            //     $usersInTeam = User::with(['roles' => function ($query) {
            //         $query->select('id', 'name'); // เลือกเฉพาะฟิลด์ id และ name_position ของ role
            //     }])

            //         ->leftJoin('users as agents', 'users.agent_by', '=', 'agents.id') // เชื่อมกับตาราง users อีกครั้ง
            //         // ->leftJoin('dynamic_commission.files as files', 'users.id', '=', 'files.user_id') // เชื่อมกับตาราง files
            //         ->leftJoin('dynamic_commission.register as register', 'users.code', '=', 'register.code') // เชื่อมกับตาราง register
            //         ->where('users.team_id', $team->id)
            //         ->where('users.department_id', 14)
            //         ->where('users.active', 1)
            //         ->whereNull('users.resign_date')
            //         // ->groupBy('files.user_id') // แยกข้อมูลตาม user_id
            //         ->orderBy('users.code','ASC')// เรียงลำดับตามฟิลด์ users.code ในลำดับจากมากไปหาน้อย
            //         ->get([
            //             'users.id',
            //             'users.code',
            //             'users.name_th',
            //             'users.sub_team_id',
            //             'users.position_id',
            //             'users.agent_by',
            //             'agents.name_th as agent_name',
            //             'users.created_date',
            //             // 'files.file_register',
            //             // 'files.file_legal',
            //             // 'files.file_contract',
            //             'register.regis_type'

            //         ]);


            //     $fileUser = File::where('user_id',)->get();
            //     $data[$key]['team'] = $team;
            //     $data[$key]['user_count'] = $userCount;
            //     $data[$key]['users'] = $usersInTeam;
            //     $totalUserCount += $userCount;
            // }

            // $data['total_user_count'] = $totalUserCount;
            foreach ($teams as $key => $team) {

                $usersInTeam = User::with(['roles' => function ($query) {
                    $query->select('id', 'name');
                }])
                    ->leftJoin('users as agents', 'users.agent_by', '=', 'agents.id')
                    ->leftJoin('dynamic_commission.register as register', 'users.code', '=', 'register.code')
                    ->leftJoin('dynamic_commission.files', 'users.id', '=', 'files.user_id')
                    ->where('users.team_id', $team->id)
                    ->where('users.department_id', 14)
                    ->where('users.active', 1)
                    ->whereNull('users.resign_date')
                    ->orderBy('users.code', 'ASC')
                    ->select([
                        'users.id',
                        'users.code',
                        'users.name_th',
                        'users.sub_team_id',
                        'users.position_id',
                        'users.agent_by',
                        'agents.name_th as agent_name',
                        'users.created_date',
                        'register.regis_type',
                        'files.file_legal',
                        'files.file_register',
                        'files.file_contract'
                    ])
                    ->distinct('users.id')
                    ->get();


                $data[$key]['team'] = $team;
                $data[$key]['users'] = $usersInTeam;
                $data[$key]['user_count'] = $usersInTeam->count();
                $totalUserCount += $usersInTeam->count();
            }

            $data['total_user_count'] = $totalUserCount;

            //return response()->json($data);


        } elseif (Auth::user()->role()->name == 'Authorizer' || Auth::user()->role()->name == 'Support' || Auth::user()->role()->name == 'AdminAgent') {

            $data = [];

            //$teams = Team::get();
            $teams = Team::where('team_status', '=', null)->get();
            $totalUserCount = 0;

            foreach ($teams as $key => $team) {
                $userCount = User::where('team_id', $team->id)
                    ->where('department_id', 14)
                    ->where('active', 1)
                    ->where('agent_by', Auth::user()->id)
                    ->whereNull('resign_date')
                    ->count();

                $usersInTeam = User::with(['roles' => function ($query) {
                    $query->select('id', 'name'); // เลือกเฉพาะฟิลด์ id และ name_position ของ role
                }])
                    ->where('team_id', $team->id)
                    ->where('agent_by', Auth::user()->id)
                    ->where('department_id', 14)
                    ->where('active', 1)
                    ->whereNull('resign_date')
                    ->get(['id', 'code', 'name_th', 'sub_team_id', 'position_id', 'agent_by', 'created_date']);



                $data[$key]['team'] = $team;
                $data[$key]['user_count'] = $userCount;
                $data[$key]['users'] = $usersInTeam;

                $totalUserCount += $userCount;
            }

            $data['total_user_count'] = $totalUserCount;
            //return response()->json($data);
        } else {

            $user = Auth::user();
            $data = [];
            // $files = File::where('user_id',$user->id)->get();
            // หาจำนวนผู้ในทีมย่อยที่มีเงื่อนไข
            $subCount = User::where('sub_team_id', $user->id)
                ->where('team_id', $user->team_id)
                ->where('department_id', 14)
                ->where('active', 1)
                ->whereNull('resign_date')
                ->count();

            if ($subCount == 0) {
                return $this->show($user->id);
            }

            // ดึงข้อมูลผู้ในทีมย่อยและข้อมูลอื่นๆ
            $users = User::with('roles')
                ->where('sub_team_id', $user->id)
                ->where('team_id', $user->team_id)
                ->where('department_id', 14)
                ->where('active', 1)
                ->whereNull('resign_date')
                ->get();

            foreach ($users as $key => $value) {
                $subCount = User::where('sub_team_id', $value->id)
                    ->where('team_id', $user->team_id)
                    ->where('department_id', 14)
                    ->where('active', 1)
                    ->whereNull('resign_date')
                    ->count();

                if ($subCount == 0) {
                    $count++;
                    $data['users'][] = $value;
                    continue;
                }

                $data['subteams'][$key]['sub'] = $value;
                $data['subteams'][$key]['users'] = User::with('roles')
                    ->where('sub_team_id', $value->id)
                    ->where('team_id', $user->team_id)
                    ->where('department_id', 14)
                    ->where('active', 1)
                    ->whereNull('resign_date')
                    ->get();
                $count++;
            }

            $data['leader'] = $user;
        }
        // dd($data['users']);
        //return response()->json($data);
        return view('pages.sales.index', ['data' => $data]);
    }

    public function findSubTeam($sub_id)
    {
        $data = [];

        $data[$key]['subteams'][$sub_key]['sub'] = User::with('roles')
            ->where('department_id', 14)
            ->where('active', 1)
            ->whereNull('resign_date')
            ->find($sub_id);

        if (empty($data[$key]['subteams'][$sub_key]['sub'])) {
            $data[$key]['subteams'][$sub_key]['sub'] = User::with('roles')->where('department_id', 14)->where('team_id', $team->id)
                ->where('active', 1)
                ->whereNull('resign_date')
                ->first();
        }
        $data[$key]['subteams'][$sub_key]['users'] = $users;


        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('name', '!=', 'Admin')->where('department_id', 14)->get();

        $query = DB::connection('mysql')->table('dynamic_commission.role_user')
            ->select('dynamic_commission.role_user.*', 'hr.users.name_th', 'hr.users.active', 'hr.users.active', 'hr.tb_position.name', 'hr.tb_position.department_id', 'hr.users.agent_by')
            ->leftJoin('hr.users', 'hr.users.id', '=', 'dynamic_commission.role_user.user_id')
            ->leftJoin('hr.tb_position', 'dynamic_commission.role_user.role_id', '=', 'hr.tb_position.id')
            ->where('hr.users.active', 1)
            ->whereNull('hr.users.resign_date')
            ->wherein('dynamic_commission.role_user.role_id', [416, 433])
            ->orderBy('hr.users.name_th', 'asc');
        $adminagents = $query->get();

        $users = [];
        $member = Member::select('regis_type')->distinct()->get(); //ฐานข้อมูลจาก Register

        $teams = Team::where('team_status', "=", null)->get();
        // $provinces = DB::connection('user')->table('provinces')->get();
        $provinces = Tambon::select('province', 'province_id')->distinct()->get();
        $amphoes = Tambon::select('amphoe', 'amphoe_id')->distinct()->get();
        $tambons = Tambon::select('tambon', 'tambon_id')->distinct()->get();
        $subteam = [];
        foreach ($teams as $key => $team) {
            $name = [];


            foreach ($roles as  $role) {
                $users = User::where('team_id', $team->id)->where('department_id', 14)->where('position_id', $role->id)->where('active', 1)->whereNull('resign_date')->get();

                foreach ($users as $i =>  $user) {

                    if ($i == 0) {
                        $name[$i] = 'ไม่มีหัว';
                    }
                    $name[$user->id]  = $user->name_th;

                    // if ($user->roles) {
                    $name[$user->id] = $role->short_code . ' - ' . $user->name_th;
                    // }
                }
            }
            $subteam[$key] =  $name;
        }

        return view('pages.sales.create', compact('provinces', 'amphoes', 'tambons', 'adminagents', 'member'))
            ->withRoles(Arr::pluck($roles, 'name', 'id'))
            ->withSubTeam($subteam)
            ->withTeams(Arr::pluck($teams, 'name', 'id'))
            ->withUser(Arr::pluck(User::get(), 'name_th', 'id'))
            ->withCompanies(Arr::pluck(Company::get(), 'company_th', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $user = User::where('idcard', $request->idcard)->count();
        if ($user > 0) {
            Session::flash('status', 'เลขบัตรประชาชนซ้ำ');
            return redirect()->back();
        }

        ////// gen code agent //////
        $dateNow = date('d/m/Y', strtotime('+543 years'));
        $yearCreate = Carbon::createFromFormat('d/m/Y', $dateNow);
        $year = $yearCreate->year; //ตัดเหลือแค่ปี
        $month = str_pad($yearCreate->month, 2, '0', STR_PAD_LEFT); //ถ้าเลขเดือนไม่ถึง 2 หลักให้เติม 0 นำหน้า โดยเติมจากด้านซ้าย
        $lastTwoDigits = substr($year, -2); // ตัดให้เหลือ 2 ตัว ท้าย 2566 => 66

        ////// gen code agent //////
        // $yearCreate = Carbon::createFromFormat('d/m/Y', $request->created_at);


        $code_team = Team::where('id', $request->team_id)->first(); //ดึง code_team
        $randomStr = Str::random(15);
        //ถ้าไม่มี code_team
        if ($code_team->code_team == "") {
            Session::flash('status', 'Error! Code_team Is Null');
            return redirect()->back();
        }

        $lastAgent = User::where('code', 'like', $code_team->code_team . '%')
            ->orderBy('code', 'desc')
            ->first();
        $lastAgentMonth = $lastAgent ? substr($lastAgent->code, 6, 2) : '';
        $lastAgentCodeTeam = $lastAgent ? substr($lastAgent->code, 0, 4) : '';

        //dd($code_team->code_team);


        // เช็คว่ามีการเปลี่ยน เดือน หรือ code_team หรือไม่ ถ้าเปลี่ยนใหม่ให้เริ่มนับรหัส Agent ใหม่เป็น 1
        if ($lastAgentMonth !== $month || $lastAgentCodeTeam !== $code_team->code_team) {
            $startingCode = 1;
        } else {
            $lastAgentNumber = substr($lastAgent->code, -3);
            $startingCode = intval($lastAgentNumber) + 1;
        }

        //create patten code agent
        $userCode = $code_team->code_team . $lastTwoDigits . $month . str_pad($startingCode, 3, '0', STR_PAD_LEFT);
        //dd($userCode);
        ////////////////////////////
        $sale = new User;
        $sale->name_th = $request->name_th;
        $sale->name_eng = $request->name_eng;
        $sale->email = $request->email;
        $sale->idcard = str_replace('-', '', $request->idcard);
        $sale->lineid = $request->lineid;
        $sale->address = $request->address;
        // $sale->soi = $request->soi;
        $sale->district_id = $request->district_id;
        $sale->amphur_id = $request->amphur_id;
        $sale->province_id = $request->province_id;
        // $sale->zipcode = $request->zipcode;
        $sale->bank_name = $request->bank_name;
        $sale->bank_account = $request->bank_account;
        $sale->lineid = $request->lineid;
        $sale->phone = str_replace('-', '', $request->phone);
        $sale->department_id = 14; //id 14 = agent
        $sale->position_id = $request->position_id;
        $sale->created_at = date('Y-m-d', strtotime(str_replace('/', '-', $request->created_at)));
        $sale->team_id = $request->team_id;
        $sale->company_id = $request->company_id;
        $sale->active_agent = 1;
        $sale->password = bcrypt('123456');
        $sale->sub_team_id = $request->sub_id;
        $sale->code = $userCode;
        $sale->agent_by = $request->agent_by;
        $sale->active = 1;
        $sale->save();
        DB::table('role_user')->insert([
            'role_id' => $request->position_id,
            'user_id' => $sale->id
        ]);

        //dd($sale);  
        $sale->save();
        $log = new Log;
        $log->action = 'Store';
        $log->new = $sale;
        $log->user_id = Auth::id();
        $log->save();

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
        $insert_member = new Member;
        $insert_member->code            = $sale->code;
        $insert_member->agent_by        = $sale->agent_by;
        $insert_member->regis_type      = $request->regis_type;
        $insert_member->name_th         = $sale->name_th;
        $insert_member->name_eng        = $sale->name_eng;
        $insert_member->email           = $sale->email;
        $insert_member->idcard          = $sale->idcard;
        $insert_member->address         = $sale->address;
        $insert_member->phone           = $sale->phone;
        $insert_member->lineid          = $sale->lineid;
        $insert_member->province_id     = $sale->province_id;
        $insert_member->amphur_id       = $sale->amphur_id;
        $insert_member->district_id     = $sale->district_id;
        $insert_member->bank_name       = $sale->bank_name;
        $insert_member->postcode        = $sale->postcode;
        $insert_member->bank_account    = $sale->bank_account;
        $insert_member->file_register   = $file_register;
        $insert_member->file_legal      = $file_legal;
        $insert_member->file_contract   = $file_contract;
        $insert_member->status          = 4;
        $insert_member->save();

        $insert_file = new File;
        $insert_file->user_id           = $sale->id;
        $insert_file->file_register     = $file_register;
        $insert_file->file_legal        = $file_legal;
        $insert_file->file_contract     = $file_contract;
        $insert_file->save();

        Session::flash('status', 'Success');


        return redirect()->route('users.edit', $sale->id);
    }


    public function checkPromote($sub_team_id)
    {
        $sub_team = sub_team::find($sub_team_id);
        $user = User::find($sub_team->user_id);
        $users = User::where('sub_team_id', $sub_team->id)->get();

        $sale = 0;
        $tl = 0;
        $mg = 0;
        $sm = 0;
        $avp = 0;
        $vp = 0;
        $md = 0;

        $promote = false;

        foreach ($users as  $value) {
            $role = $value->role()->first();

            if ($role->short_code == 'AGENT') {
                $sale++;
            } elseif ($role->short_code == 'TL') {
                $tl++;
            } elseif ($role->short_code == 'MG') {
                $mg++;
            } elseif ($role->short_code == 'SM') {
                $sm++;
            } elseif ($role->short_code == 'AVP') {
                $avp++;
            } elseif ($role->short_code == 'VP') {
                $vp++;
            } elseif ($role->short_code == 'MD') {
                $md++;
            }
        }

        if (
            $sale >= $user->role()->SALE &&
            $tl >= $user->role()->TL &&
            $mg >= $user->role()->MG &&
            $sm >= $user->role()->SM &&
            $avp >= $user->role()->AVP &&
            $vp >= $user->role()->VP
        ) {
            $promote = true;
        }
        if ($promote) {
            $role_before_id = $user->role()->id;
            if ($user->role()->short_code == 'AGENT') {
                $user->roles()->sync(Role::where('name', 'Team Leader')->first()->id);
            } elseif ($user->role()->short_code == 'TL') {
                $user->roles()->sync(Role::where('name', 'Manager')->first()->id);
            } elseif ($user->role()->short_code == 'MG') {
                $user->roles()->sync(Role::where('name', 'Senior Manager')->first()->id);
            } elseif ($user->role()->short_code == 'SM') {
                $user->roles()->sync(Role::where('name', 'Assistant Vice President')->first()->id);
            } elseif ($user->role()->short_code == 'AVP') {
                $user->roles()->sync(Role::where('name', 'Vice President')->first()->id);
            } elseif ($user->role()->short_code == 'VP') {
                $user->roles()->sync(Role::where('name', 'Managing Director')->first()->id);
            }
            DB::table('role_log')->insert([
                'user_id' => $user->id,
                'role_before_id' => $role_before_id,
                'role_after_id' => $user->role()->id,
                'action' => 'up',
                'updated_at' => date('Y-m-d H:i')
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('pages.sales.show')
            ->withSale($user)
            // ->withCommissions(Commission::where('user_id', $id)->where('approved', 1)->get())
            ->withCommissions(Commission::where('user_id', $id)->get())
            ->withRole($user->role());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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
        $query = DB::connection('mysql')->table('dynamic_commission.role_user')
            ->select('dynamic_commission.role_user.*', 'hr.users.name_th', 'hr.users.active', 'hr.tb_position.name', 'hr.tb_position.department_id', 'hr.users.agent_by', 'hr.users.code')
            ->leftJoin('hr.users', 'hr.users.id', '=', 'dynamic_commission.role_user.user_id')
            ->leftJoin('hr.tb_position', 'dynamic_commission.role_user.role_id', '=', 'hr.tb_position.id')
            ->where('hr.users.active', 1)
            ->whereNull('hr.users.resign_date')
            ->wherein('dynamic_commission.role_user.role_id', [416, 433])
            ->orderBy('hr.users.name_th', 'asc');
        $adminagents = $query->get();

        $user = User::findOrfail($id); //ฐานข้อมูลจาก usersใน hr

        $member = Member::select('regis_type')->distinct()->get(); //ฐานข้อมูลจาก Register
        $provinces = Tambon::select('province', 'province_id')->distinct()->get();
        $amphoes = Tambon::select('amphoe', 'amphoe_id')->distinct()->get();
        $tambons = Tambon::select('tambon', 'tambon_id')->distinct()->get();

        if (Auth::user()->role()->name  == 'Admin' || Auth::user()->role()->name  == 'Support' || Auth::user()->role()->name  == 'AdminAgent' || Auth::user()->role()->name  == 'AdminSupport') {
            $roles = Role::where('name', '!=', 'Admin')->where('department_id', 14)->get();
            $users = [];
            $roles = $roles->toArray();

            $subteam = [];
            $teams = Team::where('team_status', "=", null)->get();
            foreach ($teams as $key => $value) {
                $users = User::where('department_id', 14)
                    ->where('team_id', $value->id)->get();

                foreach ($users as $i =>  $user) {
                    if ($i == 0) {
                        $subteam[$value->id][$i] = 'ไม่มีหัว';
                    }
                    $key = array_search($user->position_id, array_column($roles, 'id'));
                    if ($key >= 0) {

                        $subteam[$value->id][$user->id] = $roles[$key]['short_code'] . ' - ' . $user->name_th;
                    } else {
                    }
                }
            }

            $files = File::where('user_id', $id)->first();
            //dd($files);
            // $files = [];
            // foreach ($file_user as $file) {
            //     $files[] = $file;
            // }

            $userabc = [];
            $userInTeam = User::where('sub_team_id', $id)->where('department_id', 14)->get();

            foreach ($userInTeam as $userSub) {
                $userabc[] = $userSub;
                $a = User::where('sub_team_id', $userSub->id)->where('department_id', 14)->get();
                foreach ($a as $b) {
                    $userabc[] = $b;
                }
            }
            //dd($file_user);
            return view('pages.sales.edit', compact('member', 'provinces', 'amphoes', 'tambons', 'adminagents', 'files'))
                ->withSale(User::select('users.*', 'dynamic_commission.register.regis_type', 'dynamic_commission.register.file_register', 
                'dynamic_commission.register.file_legal', 'dynamic_commission.register.file_contract')
                    ->leftJoin('dynamic_commission.register as register', 'users.code', '=', 'register.code')->find($id))
                ->withRoles(Arr::pluck($roles, 'name', 'id'))
                ->withSubTeam($subteam)
                ->withTeams(Arr::pluck($teams, 'name', 'id'))
                ->withUser(Arr::pluck(User::get(), 'name_th', 'id'))
                // ->withFiles($files)
                ->withUserInTeam($userabc)
                ->withCompanies(Arr::pluck(company::get(), 'company_th', 'id'));
        } else {
            if (Auth::id() == $id) {
                $files = File::where('user_id', Auth::id())->get();
                return view('pages.users.edit')->withSale(User::find($id))->withFiles($files);
            } else {
                return abort(404);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function password(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validate->fails()) {
            Session::flash('status', 'รหัสผ่านไม่เหมือนกัน');
            return redirect()->back();
        }

        $sale = User::find($id);
        $sale->password = bcrypt($request->password);
        $sale->save();

        Session::flash('status', 'Success');
        return redirect()->route('users.index');
    }

    public function update(Request $request, $id)
    {
        $randomStr = Str::random(15);
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

        $sale = User::find($id);
        //dd($sale);
        // $member = Member::find($id);
        $log = new Log;
        $log->action = 'Update';
        $log->old = $sale;

        // $sale->update($request->all());

        $sale->name_th          = $request->name_th;
        $sale->name_eng         = $request->name_eng;
        $sale->email            = $request->email;
        $sale->idcard           = str_replace('-', '', $request->idcard);
        $sale->lineid           = $request->lineid;
        $sale->address          = $request->address;
        $sale->district_id      = $request->district_id;
        $sale->amphur_id        = $request->amphur_id;
        $sale->province_id      = $request->province_id;
        $sale->postcode         = $request->postcode;
        $sale->bank_name        = $request->bank_name;
        $sale->lineid           = $request->lineid;
        $sale->bank_account     = $request->bank_account;
        $sale->phone            = str_replace('-', '', $request->phone);
        $sale->department_id    = 14;
        $sale->position_id      = $request->position_id;
        $sale->phone            = str_replace('-', '', $request->phone);
        $sale->created_at       = date('Y-m-d', strtotime(str_replace('/', '-', $request->created_at)));
        $sale->agent_by         = $request->agent_by;
        // $sale->sub_team_id   = $request->sub_team_id;
        $sale->sub_team_id      = $request->sub_id;

        DB::table('role_user')
            ->where('user_id', $sale->id)
            ->update([
                'role_id' => $request->position_id,
            ]);

        $sale->save();
        $log->new = $sale;
        $log->user_id = Auth::id();
        $log->save();

        if ($request->sub_team_id) {
            $sale->sub_team_id = $request->sub_team_id;
            $sale->save();
        }

        $checkmember = Member::where('code', $sale->code)->count();
        $files = File::where('user_id', $sale->id)->first();
        if (!$files) {
            // If no record found, create a new one
            $insert_file = new File;
            $insert_file->user_id = $sale->id;
            $insert_file->file_register = $file_register;
            $insert_file->file_legal = $file_legal;
            $insert_file->file_contract = $file_contract;
            $insert_file->save();
        } else {
            // If record found, update existing one
            if ($request->hasFile('file_register')) {
                $files->file_register = $file_register;
            }
            if ($request->hasFile('file_legal')) {
                $files->file_legal = $file_legal;
            }
            if ($request->hasFile('file_contract')) {
                $files->file_contract = $file_contract;
            }
            $files->save();
        }
        if ($checkmember == 0) {
            $insert_member = new member;
            $insert_member->code            = $sale->code;
            $insert_member->agent_by        = $sale->agent_by;
            $insert_member->regis_type      = $request->regis_type;
            $insert_member->name_th         = $sale->name_th;
            $insert_member->name_eng        = $sale->name_eng;
            $insert_member->email           = $sale->email;
            $insert_member->idcard          = $sale->idcard;
            $insert_member->address         = $sale->address;
            $insert_member->phone           = $sale->phone;
            $insert_member->lineid          = $sale->lineid;
            $insert_member->province_id     = $sale->province_id;
            $insert_member->amphur_id       = $sale->amphur_id;
            $insert_member->district_id     = $sale->district_id;
            $insert_member->bank_name       = $sale->bank_name;
            $insert_member->postcode        = $sale->postcode;
            $insert_member->bank_account    = $sale->bank_account;
            if (!empty($files->file_register) && optional($files)->file_register != "") {
                $insert_member->file_register   = $files->file_register;
            }
            if (!empty($files->file_legal) && optional($files)->file_legal != "") {
                $insert_member->file_legal      = $files->file_legal;
            }
            if (!empty($files->file_contract) && optional($files)->file_contract != "") {
                $insert_member->file_contract   = $files->file_contract;
            }
            $insert_member->status          = 5;
            $insert_member->save();
        } else {
            $update_member = Member::where('code', $sale->code)->first();
            $update_member->agent_by        = $request->agent_by;
            $update_member->regis_type      = $request->regis_type;
            $update_member->name_th         = $request->name_th;
            $update_member->name_eng        = $request->name_eng;
            $update_member->email           = $request->email;
            $update_member->idcard          = $request->idcard;
            $update_member->address         = $request->address;
            $update_member->phone           = $request->phone;
            $update_member->lineid          = $request->lineid;
            $update_member->province_id     = $request->province_id;
            $update_member->amphur_id       = $request->amphur_id;
            $update_member->district_id     = $request->district_id;
            $update_member->bank_name       = $request->bank_name;
            $update_member->postcode        = $request->postcode;
            $update_member->bank_account    = $request->bank_account;
            if (!empty($files->file_register) && optional($files)->file_register != "") {
                $update_member->file_register   = $files->file_register;
            }
            if (!empty($files->file_legal) && optional($files)->file_legal != "") {
                $update_member->file_legal      = $files->file_legal;
            }
            if (!empty($files->file_contract) && optional($files)->file_contract != "") {
                $update_member->file_contract   = $files->file_contract;
            }
            $update_member->save();
        }

        Session::flash('status', 'Success');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $nowDate = date("Y-m-d");
        $user->active = "0";
        $user->resign_date = $nowDate;
        $user->save();


        //$user->files()->detach();
        // $user->sub_team()->detach();
        DB::table('sub_teams')->where('user_id', $id)->delete();

        $log = new Log;
        $log->user_id = Auth::id();
        $log->action = 'delete';
        $log->old = $user;
        $log->save();

        //$user->delete();
        Session::flash('status', 'Success');
        return redirect()->back();
    }

    public function reject(Request $request, $id)
    {
        $role_log = Role_Log::find($id);
        $role_log->reject = 1;
        $role_log->save();

        Session::flash('status', 'Success');
        return redirect()->back();
    }

    public function approve(Request $request, $id)
    {
        $role_log = Role_Log::find($id);
        $setting = Setting::where('name', 'approve')->first();
        $user = User::find($role_log->user_id);
        $role_log->status = $role_log->status + 1;

        if ($setting->value == $role_log->status) {
            $subteam = sub_team::find($user->sub_team_id);
            if ($user->sub_team_id != null) {
                $subteam->user_id = sub_team::find($user->sub_team_id);
                $leader = User::find($subteam->user_id)->first();

                if ($leader->role()->id  == $role_log->role_after_id) {
                    $leader->commission = 10;
                    $leader->save();
                }
            }

            $role_log->approve = 1;
            // $user->roles()->sync($role_log->role_after_id);
        }

        $role_log->save();

        Session::flash('status', 'Success');
        return redirect()->back();
    }

    public function importExcel(Request $request)
    {
        Excel::import(new UsersImport, $request->file('files'));
        return redirect()->back();
    }

    public function getimportExcel()
    {
        return view('pages.sales.import');
    }

    public function createOther()
    {
        $roles = Role::where('department_id', 0)->get();
        return view('pages.sales.other.create')
            ->withRoles(Arr::pluck($roles, 'name', 'id'));
    }

    public function storeOther(Request $request)
    {

        $user = User::where('code', $request->user_name)->count();

        if ($user > 0) {
            Session::flash('status', 'User_name ซ้ำ');

            return redirect()->back();
        }

        $user = new User;
        $user->name_th = $request->name_th;
        $user->name_eng = $request->name_eng;
        $user->code =  $request->user_name;
        $user->department_id = 0;
        $user->position_id = $request->position_id;
        $user->password = bcrypt('123456');
        $user->active = 1;
        $user->save();
        Session::flash('status', 'Success');

        return redirect('/dashboard');
    }

    public function search(Request $request)
    {

        $users = DB::connection('user')
            ->table('users')
            ->join('tb_position', 'users.position_id', 'tb_position.id')
            ->select(['users.*', 'tb_position.name as role_name'])
            ->where('users.department_id', 14)->where('active', 1)->whereNull('resign_date');

        if ($request->name) {
            $users->where('name_th', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->code) {
            $users->where('code', 'LIKE', '%' . $request->code . '%');
        }

        if ($request->idcard) {
            $users->where('idcard', 'LIKE', '%' . $request->idcard . '%');
        }
        if ($request->phone) {
            $users->where('phone', 'LIKE', '%' . $request->phone . '%');
        }

        $users = $users->get();

        return view('pages.sales.result')->withAgents($users)->withCount(count($users));

        if (count($users) == 1) {
            $user = Arr::first($users);
            return $this->show(Arr::first($user));
        }

        if (count($users) == 0) {
            return view('pages.sales.index')->withAgents([])->withCount(0);
        }

        // foreach ($users as $key => $value) {
        //     $s = User::with('roles')->where('sub_team_id', $value->id)->where('team_id', $user->team_id)->where('department_id', 14)->count();

        //     if ($s == 0) {
        //         $count++;
        //         $data['users'][] = $value;
        //         continue;
        //     }
        //     $data['subteams'][$key]['sub'] = $value;
        //     $data['subteams'][$key]['users'] = User::with('roles')->where('sub_team_id', $value->id)->where('team_id', $user->team_id)->where('department_id', 14)->get();
        //     $count++;
        // }

        // return view('pages.sales.index')->withAgents($users)->withCount(count($users));
    }
    public function getListAgents(Request $request)
    {
        if (($request->team_id)) {
            $team = Team::find($request->team_id);

            $users = DB::connection('user')
                ->table('users')
                ->join('tb_position', 'users.position_id', 'tb_position.id')
                ->select(['users.*', 'tb_position.name as role_name'])
                ->where('users.department_id', 14)
                ->where('team_id', $team->id)
                ->where('sub_team_id', 0)->where('active', 1)->whereNull('resign_date');
            return view('pages.sales.sub')->withSubs($users->get())->withCount(count($users));
        } elseif (isset($request->sub_team_id)) {

            $users = DB::connection('user')
                ->table('users')
                ->join('tb_position', 'users.position_id', 'tb_position.id')
                ->select(['users.*', 'tb_position.name as role_name'])
                ->where('users.department_id', 14)
                ->where('sub_team_id', $request->sub_team_id)->where('active', 1)->whereNull('resign_date');
            return view('pages.sales.sub')->withSubs($users->get())->withCount(count($users));
        }
    }
}
