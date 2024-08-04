<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Commission;

use App\Models\User;
use Auth;

class CommissionController extends Controller
{

    public function Commission($id)
    {
        $commission = Commission::findOrFail($id);

        return response()->json($commission);
    }

    public function commissionsalein($id)
    {
        $commission = DB::table('commission_salein')->where('id', $id)->first();

        return response()->json($commission);
    }

    public function point($id)
    {


        $point = DB::table('points')->leftJoin('hr.users', 'hr.users.id', 'points.user_id')->where('points.commission_id', $id)->select('points.*', 'hr.users.name_th as sale_name')->get();

        foreach ($point as   $value) {
            $value->created_at = date('d/m/Y', strtotime($value->created_at));
            $value->approve_limit = number_format($value->approve_limit, 2);
        }
        return response()->json($point);
    }
    public function pointVP($id)
    {

        $com = DB::table('commission_salein')->where('id', $id)->first();


        if (date('d', strtotime($com->created_at)) == 16) {
            //
            $from = date('Y-m-01', strtotime($com->created_at));
            $to =  date('Y-m-17', strtotime($com->created_at));
        } else {
            $from = date('Y-m-17', strtotime($com->created_at));
            $to =  date('Y-m-t', strtotime($com->created_at));
        }


        $point = DB::select("SELECT DISTINCT
                    points.pid,
                    points.point,
                    points.approve_limit,
                    points.customer_name,
                    points.created_at,
                    points.updated_at,
                    -- hr.users.name_th AS sale_name,
                    L.name_th as sale_name
                FROM points
                LEFT JOIN hr.users ON hr.users.id = points.user_id
                LEFT JOIN hr.users as L ON L.code = hr.users.sup_team
                WHERE points.created_at BETWEEN '$from' and '$to'
                ");

        foreach ($point as  $value) {
            $value->created_at = date('d/m/Y', strtotime($value->created_at));
            $value->approve_limit = number_format($value->approve_limit, 2);
        }
        return response()->json($point);
    }

    public function pointDaily(Request $request, $id)
    {
        $com = DB::table('commission_salein')->where('id', $id)->first();
        $user = DB::table('hr.users')->where('code', $com->code)->first();

        $from = date('Y-m-1', strtotime($com->created_at));
        $to =  date('Y-m-31', strtotime($com->created_at));
        $point = DB::select("SELECT DISTINCT
                    *
                FROM vbeyond_report.product as report
                WHERE report.resultdate BETWEEN '$from' and '$to'
                AND subid = $com->code
                ");

        foreach ($point as  $value) {
            $value->created_at = date('d/m/Y', strtotime($value->resultdate));
            $value->approve_limit = number_format($value->ApprovalLimit1, 2);
            $value->sale_name = $user->name_th;
            $value->customer_name = $value->name;
            $value->point = 0;
        }


        return response()->json($point);
    }
}