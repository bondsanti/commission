<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\SaleIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
use App\Http\Controllers\SaleInController;

class CommissionSaleInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $com = DB::table('commission_salein')
            ->leftJoin('hr.users', 'hr.users.id', 'commission_salein.user_id')
            ->leftJoin('hr.tb_position', 'hr.users.position_id', 'hr.tb_position.id');
        if ($request->from) {
            $from = date('Y-m-d', strtotime(str_replace('/', '-', $request->from) . "- 543 Years"));
            $to = date('Y-m-d', strtotime(str_replace('/', '-', $request->to) . "- 543 Years"));
        } else {

            if (date('d') < 16) {
                $from = date('1/m/Y', strtotime('-1 month '));
                $to = date('16/m/Y');
            } else {
                $from = date('16/m/Y');
                $to = date('t/m/Y');
            }
        }
        // dd([$from, $to, $request->to]);
        $com->whereBetween('commission_salein.created_at', [$from, $to]);

        $mortgage = DB::table('points')->whereBetween('points.created_at', [$from, $to])->join('commission_salein', 'points.commission_id', 'commission_salein.id');
        if (Auth::user()->role()->name != 'Admin' && Auth::user()->role()->name != 'Account') {
            $SaleInController = new SaleInController();
            $users = $SaleInController->getSubTeam(Auth::user()->code);

            $id = array();
            array_push($id,   Auth::user()->id);

            foreach ($users as  $value) {
                array_push($id, $value->id);
            }

            $com->whereIn('commission_salein.user_id', $id);
            $com->where('commission_salein.approved', 1);

            $mortgage->where('commission_salein.approved', 1);
            $mortgage->where('commission_salein.code', Auth::user()->code);
        }

        $com->select('commission_salein.*', 'hr.users.code', 'hr.users.name_th', 'hr.users.id as user_id', 'hr.tb_position.name as position_name');
        $com->orderBy('commission_salein.created_at');
        $com->orderBy('hr.users.emp_id');

        $commissions = $com->get();


        $mortgage = $mortgage->groupBy('pid')->select(DB::RAW('SUM(points.point) as point'), DB::raw('MAX(points.approve_limit) as approve_limit'));
        $mortgage = $mortgage->get();


        $point = 0;
        $approve_limit = 0;

        foreach ($mortgage as $key => $value) {
            $point += $value->point;
            $approve_limit += $value->approve_limit;
        }



        return view('pages.salein.commission', [
            'commissions' => $commissions,
            'mortgage' => $mortgage,
            'point' => $point,
            'approve_limit' => $approve_limit,
            'sumMortgage' => count($mortgage),
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
        $com = DB::table('commission_salein')->where('id', $request->id)->update(['total' => $request->total]);
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

    public function approved($id)
    {
        $com = DB::table('commission_salein')->where('id', $id)->update(['approved' => 1]);
        Session::flash('status', 'Success');

        return redirect()->back();
    }

    public function setting()
    {
        return view('pages.salein.setting');
    }

    public function settingUpdate(Request $request, $id)
    {

        DB::table('hr.settings')->insert([
            'position_id' => $request->id,
            'first_value' => $request->first_value,
            'condition' => $request->condition,
            'second_value' => $request->second_value,
            'value' => $request->value,
            'key' => ($request->key),
            'description' => ($request->description),
        ]);
        Session::flash('status', 'Success');

        return redirect()->back();
    }

    public function settingPut(Request $request, $id)
    {

        DB::table('hr.settings')->where('id', $request->id)->update([
            'first_value' => $request->first_value,
            'condition' => $request->condition,
            'second_value' => $request->second_value,
            'value' => $request->value,
            'key' => $request->key,
        ]);
        Session::flash('status', 'Success');

        return redirect()->back();
    }

    public function settingDelete(Request $request, $id)
    {
        DB::table('hr.settings')->where('id', $request->id)->delete();
        Session::flash('status', 'Success');
        return redirect()->back();
    }
    public function settingPoint(Request $request, $key)
    {

        DB::table('hr.settings')->where('description', $key)->update([
            'value' => $request->points
        ]);


        Session::flash('status', 'Success');
        return redirect()->back();
    }
}
