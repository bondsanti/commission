<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Commission;
use App\Models\sub_team;
use App\Models\Role;
use App\Models\User;
use Auth;

class StatController extends Controller
{
    private $color = ['red', 'black', 'gray', 'orange', 'green', 'blue', 'purple', 'yellow', 'brown', 'pink', 'gold', 'biege'];
    public function stackedBarChart()
    {
        // $commission = Commission::get();

        $stat = [
            [
                'key' => 'Stream 1',
                'color' => 'red',
                'values' => [
                    [
                        'x' => 1,
                        'y' => 10
                    ], [
                        'x' => 2,
                        'y' => 15
                    ], [
                        'x' => 3,
                        'y' => 16
                    ], [
                        'x' => 4,
                        'y' => 17
                    ], [
                        'x' => 5,
                        'y' => 18
                    ]
                ]
            ], [
                'key' => 'Stream 2',
                'color' => 'orange',
                'values' => [
                    [
                        'x' => 1,
                        'y' => 10
                    ], [
                        'x' => 2,
                        'y' => 15
                    ], [
                        'x' => 3,
                        'y' => 16
                    ], [
                        'x' => 4,
                        'y' => 17
                    ], [
                        'x' => 5,
                        'y' => 18
                    ]
                ]
            ], [
                'key' => 'Stream 3',
                'color' => 'black',
                'values' => [
                    [
                        'x' => 1,
                        'y' => 10
                    ], [
                        'x' => 2,
                        'y' => 15
                    ], [
                        'x' => 3,
                        'y' => 16
                    ], [
                        'x' => 4,
                        'y' => 17
                    ], [
                        'x' => 5,
                        'y' => 18
                    ]
                ]
            ]
        ];

        return response()->json($stat);
    }

    public function handleBarChart(Request $request)
    {

        $user = User::find($request->user);
        $commission = [];
        $role = $user->role($request->user);
        $barChartData = [
            [
                'key' => 'Cumulative Return',
                'values' => []
            ]
        ];
        if ($role->OUT == 1) {

            if ($role->name == 'Admin') {
                $commission = DB::select(" SELECT sum(total) as total, MONTH(updated_at) as MONTH FROM commissions GROUP BY MONTH ");
            } else {
                $commission = DB::select(" SELECT sum(total) as total, MONTH(updated_at) as MONTH FROM commissions WHERE user_id = $user->id GROUP BY MONTH");
            }
        } elseif ($role->IN == 1) {
            $commission = DB::select(" SELECT sum(total) as total, MONTH(updated_at) as MONTH FROM commission_salein WHERE user_id = $user->id GROUP BY MONTH");
        }

        foreach ($commission as $key => $value) {
            $barChartData[0]['values'][$key]['label'] =  date('F', mktime(0, 0, 0, $value->MONTH, 10));
            $barChartData[0]['values'][$key]['value'] = $value->total;
            $barChartData[0]['values'][$key]['color'] = $this->color[$key];
        }



        return response()->json($barChartData);
    }

    public function handlePieAndDonutChart()
    {

        $sale = DB::connection('user')->select("  SELECT
	count(tb_position.id) AS count, tb_position.name
FROM
	tb_position
	JOIN users ON users.position_id = tb_position.id
WHERE
	tb_position.department_id = 14
	GROUP BY users.position_id ");

        $donutChartData = [];
        $i = 0;
        foreach ($sale as $key => $value) {
            // if ($value->role_id == 1 || $value->role_id == 10 || $value->role_id == 9) {
            //     continue;
            // }
            // $name = Role::find($value->role_id);
            $donutChartData[$i]['label'] = $value->name;
            $donutChartData[$i]['value'] = $value->count;
            $donutChartData[$i]['color'] = $this->color[$i];
            $i++;
        }

        return response()->json($donutChartData);
    }
}