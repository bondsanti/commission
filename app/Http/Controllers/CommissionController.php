<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;
use App\Models\User;
use App\Models\sub_team;
use Session;
use DB;
use Auth;

use Illuminate\Support\Arr;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $this->getDataFromReportByDate();
        $type = 1;
        if (date('d') < 20) {
            $from = date('Y-m-21', strtotime('-1 month +543 years'));
            $to = date('Y-m-20', strtotime('+543 years'));
        } else {
            $from = date('Y-m-21', strtotime('+543 years'));
            $to = date('Y-m-20', strtotime('+1 month +543 years'));
        }

        if (Auth::user()->role()->name == 'Admin' || Auth::user()->role()->name == 'Account'  || Auth::user()->role()->name == 'Authorizer') {
            $data = [];

            $sub_teams = DB::select("SELECT DISTINCT(sub_team_id) FROM  commissions ORDER BY sub_team_id");

            foreach ($sub_teams as $i => $sub_team) {
                if ($sub_team->sub_team_id == null) {


                    $commissions = DB::select("SELECT DISTINCT(user_id),  sum(total) as sum,
            		sum(approve_limit) as sum_approve_limit,
            		sum(mortgage) as sum_mortgage ,
            		sum(status) as status
            		FROM commissions LEFT JOIN users ON users.id = commissions.user_id
            		WHERE commissions.sub_team_id is null
					AND commissions.updated_at >= '$from'
					AND commissions.updated_at <= '$to'
            		GROUP By commissions.user_id
            		");
                } else {

                    $commissions = DB::select("SELECT DISTINCT(user_id),  sum(total) as sum,
            		sum(approve_limit) as sum_approve_limit,
            		sum(mortgage) as sum_mortgage ,
            		sum(status) as status
            		FROM commissions LEFT JOIN users ON users.id = commissions.user_id
            		WHERE commissions.sub_team_id = $sub_team->sub_team_id
					AND commissions.updated_at >= '$from'
					AND commissions.updated_at <= '$to'
            		GROUP By commissions.user_id
            		");
                }
                foreach ($commissions as $key => $value) {
                    $data[$value->user_id]['commission'][] = $value;
                    $data[$value->user_id]['user'] = User::find($value->user_id);
                }
            }


            $commissions = $data;
        } else {
            $user = Auth::user();

            $count = User::where('sub_team_id', $user->id)->count();

            if ($count == 0) {
                $commissions = Commission::where('user_id', $user->id)
                    ->where('updated_at', '>=', $from)
                    ->where('updated_at', '<=', $to)
                    ->where('approved', 0)
                    ->get();
                $type = 2;
            } else {

                $data = [];
                $commissions = DB::select(" SELECT DISTINCT(user_id), sum(total) as sum,
						sum(approve_limit) as sum_approve_limit,
						sum(mortgage) as sum_mortgage ,
						sum(status) as status
						FROM commissions LEFT JOIN users ON users.id = commissions.user_id
						WHERE commissions.updated_at >= '$from'
                        AND commissions.sub_team_id = $user->id
						AND commissions.updated_at <= '$to'
                        AND commissions.approved = 1
                        GROUP By commissions.user_id ");


                foreach ($commissions as $key => $value) {
                    $data[$value->user_id]['commission'][] = $value;
                    $data[$value->user_id]['user'] = User::find($value->user_id);
                }

                $commissions = $data;
            }
        }

        return view('pages.commissions.index')
            ->withCommissions($commissions)->withFrom($from)->withTo($to)->withType($type);
    }

    public function getDataFromReportByDate()
    {

        // $report = DB::connection('report')
        //     ->select("SELECT DISTINCT(product.pid), name FROM sub_sale JOIN product ON product.sid = 36 WHERE product.ApprovalLimit1 > 0 AND product.status = 'Mortgaged'  ");

        $report = DB::connection('report')
            ->select(" SELECT * FROM product WHERE product.status = 'Mortgaged' AND product.ApprovalLimit1 > 0 and calculate = 0 ");


        // resultdate

        $data = [];
        foreach ($report as $key => $value) {
            $product = DB::connection('report')
                ->select("SELECT * FROM product WHERE pid = $value->pid ")[0];
            $user = User::where('code', $product->subid)->orWhere('old_code', $product->subid)->first();
            // $user = User::where('code', $product->subid)->orWhere('name_th', $)->orWhere()->first();
            if ($user == null) {

                // $user = new User;
                // $user->code = '';
                // $user->password = bcrypt('123456');
                // $user->save();

            } else {

                $commission = Commission::where('pid', $value->pid)->first();
                $this->store($user, $product->ApprovalLimit1, $value);
                dd($commission);

                if ($commission == null) {
                    $this->store($user, $product->ApprovalLimit1, $value);
                }

                $value->report = $product;
                $value->user = $user;
            }

            $product = DB::connection('report')->table('product')->where('pid', $value->pid)->update(['calculate' => 1]);
        }

        return $report;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sales = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['Agent']);
        })->get();

        return view('pages.commissions.create')
            ->withUsers(Arr::pluck($sales, 'thai_name', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($user, $approve_limit, $value)
    {

        // $user = User::find($user->id);
        $percent = 0;
        $total = 0;
        $sale_id = $user->id;
        if ($user->commission > 0) {
            $percent =  $user->commission;
        } else {
            $percent =  $user->role($user->id)->commission;
        }
        $percent = 3;
        // resultdate
        $total =  $approve_limit * ($percent / 100);
        $sub_team_id = $user->sub_team_id;
        $commission = new Commission;
        $commission->name = str_random(8);
        $commission->approve_limit = $approve_limit;
        $commission->user_id = $user->id;
        $commission->sub_team_id = $sub_team_id;
        $commission->team_id = $user->team_id;
        $commission->total = $total - (($total * 3) / 100);
        $commission->pid = ($value->pid) ? $value->pid : null;
        $commission->commission = $percent;
        $commission->mortgage = 1;
        $commission->sale_id = $sale_id;
        $commission->customer_name = $value->name;
        $commission->out = 1;
        $commission->save();

        $id = str_pad($commission->id, 5, '0', STR_PAD_LEFT);
        $commission->name = date('Y', strtotime('+543 years')) . $user->code . $id;
        $commission->updated_at = date('Y-m-d', strtotime($value->resultdate . ' +543 years'));
        $commission->created_at = date('Y-m-d', strtotime($value->resultdate . ' +543 years'));
        $commission->save();

        $z = 1;

        $owner = $user;


        for ($i = 0; $i < $z; $i++) {

            // if (isset($user->sub_team()->first()->id)) {
            if (isset($user->sub_team_id) && $user->sub_team_id > 0) {

                $user = User::find($user->sub_team_id);

                if ($owner->position_id ==  $user->position_id) {
                    $z++;
                    continue;
                }

                if ($user->commission > 0) {
                    $percent =  $user->commission;
                } else {
                    $percent =  $user->role($user->id)->commission;
                }


                $total = $approve_limit * ($percent / 100);
                $z++;

                $commission = new Commission;
                $commission->name = str_random(8);
                $commission->approve_limit = $approve_limit;
                $commission->user_id = $user->id;
                $commission->sub_team_id = $sub_team_id;
                $commission->team_id = $user->team_id;
                $commission->total = $total - (($total * 3) / 100);
                $commission->commission = $percent;
                $commission->customer_name = $value->name;
                $commission->mortgage = 1;
                $commission->sale_id = $sale_id;
                $commission->out = 1;
                $commission->pid = ($value->pid) ? $value->pid : null;
                $commission->save();
                $id = str_pad($commission->id, 5, '0', STR_PAD_LEFT);
                $commission->name = date('Y', strtotime('+543 years')) . $user->code . $id;
                $commission->updated_at = date('Y-m-d', strtotime($value->resultdate . ' +543 years'));
                $commission->created_at = date('Y-m-d', strtotime($value->resultdate . ' +543 years'));
                $commission->save();
            }
        }

        DB::table('vbeyond_report.product')->where('pid', $commission->pid)->update(['calculate', 1]);
        return;
        // Session::flash('status', 'Success');
        // return redirect()->back();
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $commission = Commission::findOrFail($request->id);
        $commission->update($request->all());

        Session::flash('status', 'Success');

        return redirect()->back();
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

    public function search(Request $request)
    {
        $from = date('Y-m-d', strtotime(str_replace('/', '-', $request->from)));
        $to = date('Y-m-d', strtotime(str_replace('/', '-', $request->to)));

        if (
            Auth::user()->role()->name == 'Admin' ||
            Auth::user()->role()->name == 'Authorizer' ||
            Auth::user()->role()->name == 'Account'

        ) {
            $data = [];
            $sub_teams = DB::select("SELECT DISTINCT(sub_team_id) FROM commissions ORDER BY sub_team_id");
            // $users = DB::select("SELECT * FROM  commissions  GROUP BY user_id");
            foreach ($sub_teams as $i => $sub_team) {

                if ($sub_team->sub_team_id == null) {
                    // continue; // erorr

                    $commissions = DB::select("SELECT DISTINCT(user_id),  sum(total) as sum,
            		sum(approve_limit) as sum_approve_limit,
            		sum(mortgage) as sum_mortgage ,
            		sum(status) as status
            		FROM commissions LEFT JOIN users ON users.id = commissions.user_id
                    WHERE commissions.sub_team_id is null
					AND commissions.updated_at >= '$from'
					AND commissions.updated_at <= '$to'
            		GROUP By commissions.user_id
            		");
                } else {
                    $commissions = DB::select("SELECT DISTINCT(user_id),  sum(total) as sum,
            		sum(approve_limit) as sum_approve_limit,
            		sum(mortgage) as sum_mortgage ,
            		sum(status) as status
            		FROM commissions LEFT JOIN users ON users.id = commissions.user_id
            		WHERE commissions.sub_team_id = $sub_team->sub_team_id
					AND commissions.updated_at >= '$from'
					AND commissions.updated_at <= '$to'
            		GROUP By commissions.user_id
            		");
                }

                foreach ($commissions as $key => $value) {
                    $data[$value->user_id]['commission'][] = $value;
                    $data[$value->user_id]['user'] = User::find($value->user_id);
                }
            }

            // dd($data);

            $commissions = $data;
            // $commissions = DB::select("SELECT DISTINCT(user_id), sum(total) as sum,
            // sum(approve_limit) as sum_approve_limit,
            // sum(mortgage) as sum_mortgage ,
            // sum(status) as status
            // FROM commissions LEFT JOIN users ON users.id = commissions.user_id
            // WHERE commissions.updated_at >= '$from'
            // AND commissions.updated_at <= '$to'
            // GROUP By commissions.user_id");

            // foreach ($commissions as $key => $value) {
            //     $commissions[$key]->user = User::find($value->user_id);
            // }
            $type = 1;
        } else {

            $user = Auth::user();
            $sub_team_id = $user->sub_team_id;

            // if ($sub_team_id == null) {
            $commissions = Commission::where('user_id', Auth::id())
                ->where('updated_at', '>=', $from)
                ->where('updated_at', '<=', $to)
                ->get();
            $type = 2;
            // } else {

            // 	$data = [];
            //     $commissions = DB::select("SELECT DISTINCT(user_id), sum(total) as sum,
            // 			sum(approve_limit) as sum_approve_limit,
            // 			sum(mortgage) as sum_mortgage ,
            // 			sum(status) as status
            // 			FROM commissions LEFT JOIN users ON users.id = commissions.user_id
            // 			WHERE commissions.updated_at >= '$from'
            // 			AND commissions.updated_at <= '$to'
            // 			GROUP By commissions.user_id");

            //    foreach ($commissions as $key => $value) {
            //         $data[$value->user_id]['commission'][] = $value;
            //         $data[$value->user_id]['user'] = User::find($value->user_id);
            //     }
            // 	$commissions = $data;
            //     $type = 1;


            // }
        }


        return view('pages.commissions.index')
            ->withCommissions($commissions)
            ->withFrom($from)
            ->withTo($to)
            ->withType($type);
    }

    public function paid(Request $request, $id)
    {
        if (Auth::user()->role()->name == 'Admin' || Auth::user()->role()->name == 'Account') {
            $commission = Commission::find($id);
            $commission->status = 1;
            $commission->save();
            Session::flash('status', 'จ่ายเงินแล้ว');
            return redirect()->back();
        } else {
            return abort(404);
        }
    }

    public function approved(Request $request, $id)
    {
        if (Auth::user()->role()->name == 'Admin' || Auth::user()->role()->name == 'Account') {
            $commission = Commission::find($id);
            $commission->approved = 1;
            $commission->save();
            Session::flash('status', 'อนุมัติแล้ว');
            return redirect()->back();
        } else {
            return abort(404);
        }
    }

    public function postAllowance(Request $request, $id)
    {
        $condition = $request->condition == 0 ? Null : $request->condition;


        DB::table('hr.settings_test')->insert([
            'key' => $request->key,
            'value' => $request->value.$request->value_num,
            'condition' => $condition,
            'value2' => $request->value2.$request->value_num2,
            'first_value' => $request->first_value,
            'description' => $request->description,
            'position_id' =>  $id,
        ]);
        Session::flash('status', 'เพิ่มข้อมูลแล้ว');
        return redirect()->back();
    }

    public function putAllowance(Request $request, $id)
    {


        $condition = $request->condition == 0 ? Null : $request->condition;

        $value = $request->value_num == ''? null : $request->value.$request->value_num;
        $value2 = $request->value_num2 == '' ? null : $request->value2.$request->value_num2 ;


        DB::table('hr.settings_test')->where('id', $id)->update([
            'key' => $request->key,
            'value' => $value,
            'condition' => $request->condition,
            'value2' => $value2,
            'first_value' => $request->first_value,
        ]);
        Session::flash('status', 'เพิ่มข้อมูลแล้ว');
        return redirect()->back();
    }


}