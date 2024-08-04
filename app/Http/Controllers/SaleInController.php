<?php

namespace App\Http\Controllers;

use App\Traits\ProductTrait;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SaleIn;
use App\Models\Role;
use App\Models\File;
use App\Models\Point;
use App\Models\Commission;
use App\Models\Setting;
use App\Http\Controllers\Allowance;

use Auth;
use DB;
use Carbon;


class SaleInController extends Controller
{
    //คอมเม้น
   //use ProductTrait;

    private $user;
    private $position;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->calculateCommission(); // Run Conjob every 16
        // $this->checkAllowance(); // Run Conjob every 16
        // $this->covertPointToMoney(); // Run Conjob every 16
        // DB::table('points')->whereNull('commission_id')->delete();
        // $this->checkCommissionVP();

        // $this->calculateCommissionNetwork(); // Run Conjob every 16


        $users = DB::connection('user')
            ->table('users')
            ->leftJoin('tb_position', 'tb_position.id', 'users.position_id')
            ->select('users.*', 'tb_position.name as position_name')
            ->where('users.level', '!=', 'out');

        // ->where('users.position_id', 132);

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

        if (Auth::user()->role()->name != 'Admin' && Auth::user()->role()->name != 'Account') {

            $users->where('users.code', Auth::user()->code);
            $us = $this->getSubTeam(Auth::user()->code);
            $users = $users->get()->toArray();
            $users = array_merge($users, $us);

            return view('pages.salein.index', [
                'sales' => $users
            ]);
        }

        $users->whereIn('users.department_id', [2,3,37]);
        $users->where('users.resign_date', null);
		

        if (empty($request->query)) {
            $users  = SaleIn::get();
        } else {
            $users  = $users->get()->toArray();
        }

        $i = 0;
        while ($users) {
            $user = [];
            if (empty($users[$i])) {
                break;
            }
            $user = DB::connection('user')
                ->table('users')
                ->join('tb_position', 'tb_position.id', 'users.position_id')
                ->select('users.*', 'tb_position.name as position_name')
                ->where('users.level', '!=', 'out')
				->whereIn('users.department_id', [2,3,37])
                ->where('sup_team', $users[$i]->code)
                ->orderBy('sup_team', 'asc')
                ->get();

            if (!empty($user)) {

                $users = array_merge($users, $user->toArray());
            } else {
                break;
            }
            $i++;
        }

        return view('pages.salein.index', [
            'sales' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $this->user = SaleIn::find($id);
        // $commissions = Commission::where('sale_id', $this->user->id)->get();

        $com = DB::table('commission_salein')
            ->leftJoin('hr.users', 'hr.users.id', 'commission_salein.user_id')
            ->leftJoin('hr.tb_position', 'hr.users.position_id', 'hr.tb_position.id');

        if ($request->from) {
            $from = date('Y-m-d', strtotime(str_replace('/', '-', $request->from) . "- 543 Years"));
            $to = date('Y-m-d', strtotime(str_replace('/', '-', $request->to) . "- 543 Years"));
        } else {
            $from = date('Y-m-1');
            $to = date('Y-m-d');
        }

        $com->whereBetween('commission_salein.created_at', [$from, $to]);

        $com->where('commission_salein.user_id', $this->user->id);
        $com->select('commission_salein.*', 'hr.users.code', 'hr.users.name_th', 'hr.users.id as user_id', 'hr.tb_position.name as position_name');

        // $mortgage = DB::table('points')->where('code', $this->user->code)->groupBy('pid')->select(DB::RAW('SUM(point) as point'), DB::raw('MAX(approve_limit) as approve_limit'))->get();
        $mortgage = DB::table('commission_salein')
            ->where('code', $this->user->code)
            ->whereBetween('created_at', [$from, $to])
            ->select(DB::RAW('SUM(point) as point'), DB::raw('MAX(approve_limit) as approve_limit'), DB::raw('SUM(mortgage) as mortgage'))
            ->get();

        $point = 0;
        $approve_limit = 0;
        $countMortgage = 0;
        foreach ($mortgage as $key => $value) {

            $point += $value->point;
            $approve_limit += $value->approve_limit;
            $countMortgage += $value->mortgage;
        }

        $com = $com->get();

        // $mortgage

        return view('pages.salein.edit', [
            'sale' => $this->user,
            'roles' => array_pluck(Role::get(), 'name', 'id'),
            'files' => File::where('user_id', $id)->get(),
            'commissions' => $com,
            'sumMortgage' => $countMortgage,
            'point' => $point,
            'approve_limit' => $approve_limit,
            'mortgage' => count($mortgage),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // public function commissions(Request $request)
    public function commissions(Request $request, $users)
    {
        $user = SaleIn::find($users);
        $point = Point::where('points.code', $user->code)
            ->leftJoin('hr.users', 'hr.users.id', 'points.user_id')
            ->whereMonth('points.created_at', $request->month)
            ->whereYear('points.created_at', $request->year)
            ->get();
        return view('pages.salein.commission', ['commission' => $point]);
    }

    public function calculateCommission()
    {

        // $com = DB::select(" SELECT U.name_th, U.code , U.position_id , P.*  FROM vbeyond_report.product P LEFT JOIN hr.users U ON P.subid = U.code WHERE U.department_id = 3 AND P.status = 'Mortgaged' AND P.ApprovalLimit1 > 0 AND U.code = '$code' ");

        $com = DB::select(" SELECT U.name_th, U.code , U.position_id , P.*  FROM vbeyond_report.product P LEFT JOIN hr.users U ON P.subid = U.code WHERE U.department_id in (2,3,37) AND P.status = 'Mortgaged' AND P.ApprovalLimit1 > 0  AND calculate = 0 ");
        //  AND resultdate BETWEEN '" . date('Y-07-01') . "'  AND '" . date('Y-m-31') . "'

        foreach ($com as $key => $value) {
            DB::connection('report')->table('product')->where('pid', $value->pid)->update(['calculate' => 1]);
            $sale = SaleIn::where('code', $value->code)->first();
            $position = DB::connection('user')->table('tb_position')->where('id', $value->position_id)->first();
            $this->conditionCommission($sale, $value, $position);
        }
    }

    public function conditionCommission($sale, $value, $position)
    {
        $approve_limit = $value->ApprovalLimit1;
        // $position_name = strtolower(str_replace(' ', '-', $position->name));
        $point = $this->calculatePoint($sale, $approve_limit);

        if ($point > 0) {
            $this->savePoint($sale, $point, $value);
        }
    }

    public function setCalCommission()
    {
        $this->position =  DB::connection('user')->table('tb_position')->where('id', $this->user->position_id)->first();
    }

    public function saveCommission($user, $value, $commission_rate)
    {
        $approve_limit = $value->ApprovalLimit1;
        $total =  $approve_limit * ($commission_rate / 100);

        $commission = new Commission;
        $commission->name = str_random(8);
        $commission->approve_limit = $approve_limit;
        $commission->user_id = $user->id;
        $commission->sub_team_id = $value->sub_team;
        $commission->team_id = $user->team_id;
        $commission->total = $total - (($total * 3) / 100); // minus Vat 3%
        $commission->pid = ($value->pid) ? $value->pid : null;
        $commission->commission = $commission_rate;
        $commission->mortgage = 1;
        $commission->sale_id = $user->id;
        $commission->customer_name = $value->name;
        $commission->in = 1;
        $commission->save();

        $id = str_pad($commission->id, 5, '0', STR_PAD_LEFT);
        $commission->name = date('Y', strtotime('+543 years')) . $user->code . $id;
        $commission->updated_at = date('Y-m-d', strtotime($value->resultdate . ' +543 years'));
        $commission->created_at = date('Y-m-d', strtotime($value->resultdate . ' +543 years'));
        $commission->save();
    }

    public function commissionTelesaleStaff($sale, $value, $position, $type = "loan_size")
    {
        if ($type == "loan_size") { } elseif ($type == "range_point") { }
    }

    public function calculatePoint($sale, $loan)
    {
        // $emp = $this->getEMP($sale->emp_id);
        $point = 0;
        $pointPerBath = Setting::where('position_id', 12)
        ->where('key', 'commission')
        ->where('condition', 5)
        ->where('first_value','<=', $loan)
        ->where('second_value','>',$loan)
        ->first();

        $point = $pointPerBath->value ?? 0;


        // if ($loan >= '1750000' && $loan <= '1990000') {
        //     $point = 0.5;
        // } else if ($loan >= '2000000' && $loan <= '2490000') {
        //     $point = 0.75;
        // } else if ($loan >= '2500000' && $loan <= '2990000') {
        //     $point = 1;
        // } else if ($loan >= '3000000' && $loan <= '3490000') {
        //     $point = 1.25;
        // } else if ($loan >= '3500000' && $loan <= '3990000') {
        //     $point = 1.50;
        // } else if ($loan >= '4000000' && $loan <= '4500000') {
        //     $point = 1.75;
        // } else if ($loan >= '4500000') {
        //     $point = 2;
        // }


        return $point;
    }

    public function savePoint($sale, $point, $value)
    {
        $currentPoint = $sale->commission_point;
        DB::connection('user')->table('users')->where('code', $sale->code)->update(['commission_point' => ($point + $currentPoint)]);
        $emp = $this->getEmp($sale->emp_id);

        if ($emp->name_eng == 'coo') {
            return;
        }

        // $position = DB::connection('user')->table('tb_position')->where('id', $sale->position_id)->first();

        // $this->saveCommission($sale, $value, $position->commission);
        $objPoint = new Point;
        $objPoint->user_id = $sale->id;
        $objPoint->code = $sale->code;
        $objPoint->point = $point;
        $objPoint->pid = $value->pid;
        $objPoint->approve_limit = $value->ApprovalLimit1;
        $objPoint->customer_name = $value->name;
        $objPoint->created_at = $value->resultdate;
        $objPoint->updated_at = $value->resultdate;
        $objPoint->save();

        if ($emp->name_eng == 'under') {
            $s = 1;
            $sup_team = $sale->sup_team;
            for ($i = 0; $i < $s; $i++) {
                $leader = DB::connection('user')->table('users')->where('code', $sup_team)->first();

                DB::connection('user')->table('users')->where('code', $sup_team)->update(['commission_point' => ($leader->commission_point + $point)]);

                // $position = DB::connection('user')->table('tb_position')->where('id', $sale->position_id)->first();

                // $this->saveCommission($leader, $value,  $position->commission);
                $objPoint = new Point;
                $objPoint->user_id = $sale->id;
                $objPoint->code = $leader->code;
                $objPoint->pid = $value->pid;
                $objPoint->point = $point;
                $objPoint->approve_limit = $value->ApprovalLimit1;
                $objPoint->customer_name = $value->name;
                $objPoint->created_at = $value->resultdate;
                $objPoint->updated_at = $value->resultdate;
                $objPoint->save();

                if ($leader->sup_team != null) {
                    $s++;
                    $sup_team = $leader->sup_team;
                }
            }
        }
    }

    public function getEMP($emp_id)
    {
        return DB::connection('user')->table('tb_status')->where('id', $emp_id)->first();
    }


    public function covertPointToMoney()
    {
        $users = DB::connection('user')->table('users')->where('commission_point', '>', 0)->get();

        foreach ($users as $key => $user) {
            $emp = $this->getEMP($user->emp_id);

            $pointPerBath = Setting::where('position_id', $user->position_id)->where('key', 'point')->first();
            $pointPerBath = $pointPerBath->value ?? 1;

            $bath = 0;

            // $q = DB::table('points')->where('code', $user->code)->whereNull('commission_id')->get();
            $q = DB::select(" SELECT SUM(point) AS point, MONTH(created_at) as month, SUM(approve_limit) as approve_limit, count(*) as count FROM points WHERE code = $user->code AND commission_id IS NULL GROUP BY MONTH(created_at) ");
            foreach ($q as $key => $value) {


                if ($emp->name_eng == 'upper') {

                    if ($emp->name == 'VP') {
                        continue;
                    }
                    $bath = $this->getBathFromSetting($user->emp_id, $value->point, 'commission'); // use emp_id
                } else if ($emp->name_eng == 'under') {

                    $bath = $value->point * $pointPerBath;
                } else {
                    continue;
                }

                $count =  $value->count;
                $point = $value->point;
                $approve_limit = $value->approve_limit;

                $month = strlen($value->month) == 2 ? $value->month : '0' . $value->month;
                $date = "Y-$month-d";
                $created_at = date($date);
                $created_at = \Carbon\Carbon::parse($created_at)->format('Y-m-d');
                $from = \Carbon\Carbon::parse(date("Y-$month-01"))->format('Y-m-d');
                $to = \Carbon\Carbon::parse(date("Y-$month-31"))->format('Y-m-d');

                if($user->commission > 0){
                    $bath = $approve_limit * ( $user->commission /100);
                }

                $id = DB::table('commission_salein')->insertGetId([
                    'user_id' => $user->id,
                    'code' => $user->code,
                    'total' => $bath,
                    'mortgage' => $count,
                    'point' => $point,
                    'approve_limit' => $approve_limit,
                    'created_at' => $created_at,
                    'updated_at' => $created_at,
                ]);

                DB::table('points')->where('code', $user->code)->whereBetween('created_at', [$from, $to])->update(['commission_id' => $id]);
            }

            DB::connection('user')->table('users')->where('code', $user->code)->update(['commission_point' => 0]);
        }
    }

    public function checkAllowance()
    {
        $users = DB::connection('user')->table('users')->whereIn('position_id', [131, 137])->whereIn('department_id', [2,3,19,37])->get();

        foreach ($users as $key => $value) {
            $product = DB::select(" SELECT U.name_th, U.code , U.position_id , P.*  FROM vbeyond_report.product P LEFT JOIN hr.users U ON P.subid = U.code WHERE U.department_id in (2,3,19,37)  AND U.position_id = $value->position_id AND U.code = $value->code AND calculate = 0 AND month(resultdate) = '" . date('m') . "' ");

            $mortgage = DB::select(" SELECT U.name_th, U.code , U.position_id , P.*  FROM vbeyond_report.product P LEFT JOIN hr.users U ON P.subid = U.code WHERE U.department_id in (2,3,19,37) AND P.status = 'Mortgaged' AND P.ApprovalLimit1 > 0  AND U.position_id = $value->position_id AND U.code = $value->code AND calculate = 0 AND month(resultdate) = '" . date('m') . "' ");

            if ($product) {
                $position = DB::connection('user')->table('tb_position')->where('id', $value->position_id)->first();

                $allowance = new Allowance($position->name);

                $bath = $allowance->calculate($value, $product, $mortgage);
                DB::table('commission_salein')->insert([
                    'user_id' => $value->id,
                    'code' => $value->code,
                    'total' => $bath,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

    public function checkCommissionVP($user = [])
    {

        // $users = DB::connection('user')->table('users')->where('emp_id', 5)->where('department_id', 3)->get();
        // foreach ($users as $key => $user) {
        $bath = 0;
        $user = DB::connection('user')->table('users')->where('id', 1256)->first();
        $points = Point::groupBy('month')->select(DB::raw("MONTH(created_at) as month"))->get();
        foreach ($points as $key => $value) {
            $mortgage = 0;
            $approve_limit = 0;
            $point = Point::whereMonth('created_at', $value->month)->where('calculate', 0)->groupBy('pid')->select(DB::RAW("sum(point) as point"), DB::RAW("MAX(approve_limit) as approve_limit"))->count();

            if($point == 0){
                continue;
            }
             $point = Point::whereMonth('created_at', $value->month)->where('calculate', 0)->groupBy('pid')->select(DB::RAW("sum(point) as point"), DB::RAW("MAX(approve_limit) as approve_limit"))->get();

            foreach ($point as $key => $_val) {
                $approve_limit += $_val->approve_limit;
            }

            Point::whereMonth('created_at', $value->month)->where('calculate', 0)->update(['calculate' => 1]);

            $mortgage = count($point);

            $month = date("Y-$value->month-d");
            $created_at = date($month);
            $created_at = \Carbon\Carbon::parse($created_at)->format('Y-m-d');

            $set = DB::table('hr.settings')->where('position_id', $user->emp_id)->where('first_value', '<=', $mortgage)->where('second_value', '>', $mortgage)->first();

            if ($set) {
                $bath = $set->value;
            } else {
                $bath = 0;
            }

            DB::table('commission_salein')->insert([
                'user_id' => $user->id,
                'code' => $user->code,
                'total' => ($bath * $mortgage),
                'mortgage' => $mortgage,
                'point' => 0,
                'approve_limit' => $approve_limit,
                'created_at' => $created_at,
                'updated_at' => $created_at
            ]);
        }
    }

    public function getSubTeam($code = 0)
    {
        $users = DB::connection('user')->table('users')
            ->join('tb_position', 'tb_position.id', 'users.position_id')
            ->select('users.*', 'tb_position.name as position_name')
            ->where('users.level', '!=', 'out')
            ->where('sup_team', $code)->whereIn('users.department_id', [2,3,19,37])->get()->toArray();
        $i = 0;
        if (empty($users)) {
            return $users;
        }
        while (true) {
            if ($i == count($users)) {
                break;
            }
            $lists = DB::connection('user')
                ->table('users')
                ->join('tb_position', 'tb_position.id', 'users.position_id')
                ->select('users.*', 'tb_position.name as position_name')
                ->where('users.level', '!=', 'out')
                ->where('sup_team', $users[$i]->code)->whereIn('users.department_id', [2,3,19,37])->get()->toArray();

            $users = array_merge($users, $lists);

            $i++;
        }
        return $users;
    }
    public function getBathFromSetting($position_id, $point, $key = '')
    {
        $bath = 0;
        $set = DB::table('hr.settings')
            ->where('position_id', $position_id)
            ->where('first_value', '<=', $point)
            ->where('second_value', '>', $point)
            ->where('key',  $key)
            ->first();

        if ($set) {
            $bath = $set->value;
        } else {
            dd([$position_id, $point, $key]);
        }

        return $bath;
    }

    public function calculateCommissionNetwork()
    {
        $com = DB::select(" SELECT U.name_th, U.code , U.position_id , P.*  FROM vbeyond_report.product P LEFT JOIN hr.users U ON P.subid = U.code WHERE U.department_id IN (2,3,19,37) AND P.status = 'Mortgaged' AND P.ApprovalLimit1 > 0  AND calculate = 0 ");

        //  AND resultdate BETWEEN '" . date('Y-07-01') . "'  AND '" . date('Y-m-31') . "'

        foreach ($com as $key => $value) {
            // DB::connection('report')->table('product')->where('pid', $value->pid)->update(['calculate' => 1]);
            $sale = SaleIn::where('code', $value->code)->first();
            $position = DB::connection('user')->table('tb_position')->where('id', $sale->position_id)->first();

            $this->conditionCommissionNetwork($sale, $value, $position);

            $s = 1;
            $sup_team = $sale->sup_team;
            for ($i = 0; $i < $s; $i++) {
                $leader = DB::connection('user')->table('users')->where('code', $sup_team)->first();
                $position = DB::connection('user')->table('tb_position')->where('id', $leader->position_id)->first();
                $emp = $this->getEMP($leader->emp_id);

                if ($emp->name_eng == 'upper' || $emp->name_eng == 'under') {
                    $this->conditionCommissionNetwork($leader, $value, $position);
                }

                if ($leader->sup_team != null) {
                    $s++;
                    $sup_team = $leader->sup_team;
                }
            }
        }
    }

    public function conditionCommissionNetwork($sale = '', $value = '', $position = '')
    {
        $bath = 0;

        $emp = $this->getEMP($sale->emp_id);
        $lead = $this->checkLead($value->tel);

        $emp->name = strtolower(str_replace(' ', '', $emp->name));
        $query = DB::table('hr.settings');
        if ($lead) {
            // 1. Lead Online (FB,Google,Web)
            // 2. Lead Affiliate (Partner)
            if (strtolower($lead->List_Type) == 'online') {
                $query->where('key', 'network-online');
            } else if (strtolower($lead->List_Type) == 'affiliate') {
                $query->where('key', 'network-affiliate');
            }
        } else {
            $query->where('key', 'network-direct');
            // $query->where('description', $emp->name);
            // // Lead Agent Customer (ปิดขายเอง)
            // if ($emp->name == 'officer') { // staff
            //     $bath = 500;
            // } elseif ($emp->name == 'tl') { // TL
            //     $bath = 1000;
            // } elseif ($emp->name == 'manager') { // MNG
            //     $bath = 1500;
            // }
        }
        $query->where('description', $emp->name);

        $query = $query->first();
        if ($query) {
            $bath = $query->value;
        }

        $id = DB::table('commission_salein')->insertGetId([
            'user_id' => $sale->id,
            'code' => $value->subid,
            'total' => $bath,
            'mortgage' => 1,
            'point' => 0,
            'approve_limit' => $value->ApprovalLimit1,
            'created_at' => $value->resultdate,
            'updated_at' => $value->resultdate,
        ]);

        // DB::table('points')->where('code', $user->code)->whereBetween('created_at', [$from, $to])->update(['commission_id' => $id]);

        return;
    }

    public function checkLead($phone)
    {
        $lead = DB::table('vbeyond_vconnex.marketing_list')->where('phone', $phone)->orderBy('id', 'desc')->first();

        return $lead;
    }
}
