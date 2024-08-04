<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use DB;
use App\Models\Role;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getRole()
    {
        $id = Auth::id();
        $user = DB::select(" SELECT * FROM role_user WHERE user_id = $id");
        if ($user) {
            $user = head($user);
        } else {
            return null;
        }
        return Role::find($user->role_id);
    }
}