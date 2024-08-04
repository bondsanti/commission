<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class SaleIn extends Model
{
    protected $table = 'users';
    protected $connection = 'user';

    protected function get()
    {
        return SaleIn::whereIn('department_id', [3, 2])->get();
    }

    protected function findSubTeam($code, $department_id)
    {

        return DB::connection('user')->table('tb_dept_group')
            ->join('users', 'tb_dept_group.code', 'users.code')
            ->where('tb_dept_group.code', $code)
            ->select('tb_dept_group.code', 'tb_dept_group.department_id', 'users.name_th', 'users.nickname_th', 'users.sup_team')
            ->get();
    }

    public function role($id)
    {
        $role = DB::connection('user')->table('tb_position')->where('id', $id)->first();
        return $role;
    }
}