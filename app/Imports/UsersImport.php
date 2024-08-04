<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Role;
use App\Models\sub_team;
use PHPExcel_Style_NumberFormat;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $sub_team  = 0;
        $tl = 0;
        if ($row[0] != '') {
            $name = $row[0];
            $user = User::where('name', $name)->first();
            if ($user) {

                $ex = explode(' ', $row[0]);
                $first_name = $ex[0];
                $last_name = isset($ex[1]) ? $ex[1] : '';
                $role = strtolower($row[2]);
                if ($role == 'manager') {
                    $position = 4;
                } elseif ($role == 'agent' || $role == 'agent  manager') {
                    $position = 2;
                } elseif ($role == 'agent team leader') {
                    $position = 4;
                } else {
                    $position = 3;
                }

                // $newCode = $row[2];

                // if ($row[3] == null || $row[3] =='') {
                //     $date = date('Y-m-d');
                // } else {
                //     $UNIX_DATE = ($row[3] - 25569) * 86400;
                //     $date = gmdate("Y-m-d", $UNIX_DATE);
                // }
                $phone = $row[1];

                $user = new User;
                $user->name = $name;
                $user->thai_name = $name;
                $user->password = '$2y$10$fRas3UiNPlCyQQJzUx2NxuGa6yUS15O50qRtr1HEkG61a0slk7HDW';

                $user->team_id = 2;
                $user->company_id = 1;
                $user->phone = $phone;
                // $user->join_date = $date;
                $user->save();
                $user
                    ->role()
                    ->attach(Role::find($position));

                $emp = str_pad($user->id, 5, '0', STR_PAD_LEFT);
                $user->code = '62022' . $emp;
                $user->save();
                $sub_team = new sub_team;
                $sub_team->name = $name;
                $sub_team->user_id = $user->id;

                $sub_team->save();
                return $user;
            } else {


                $user->lead_id = 2;
                $user->save();
            }
        }
    }
}