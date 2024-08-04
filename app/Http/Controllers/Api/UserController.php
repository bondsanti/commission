<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\sub_team;
use App\Models\Commission;
use Illuminate\Support\Arr;
use DB;

class UserController extends Controller
{
    public function getUsersFromTeam($id)
    {
        $users = [];
        $sub = [];
        $users = User::where('team_id', $id)->get();
        // $sub = sub_team::get();

        return response()->json($users);
    }

    public function getUsersFromSub_Team($id)
    {
        $users = [];
        $users = User::where('sub_team_id', $id)->get();
        return response()->json($users);
    }

    public function getListUsersPromote($id)
    {
        $sub = sub_team::where('user_id', $id)->first();
        $users = User::where('sub_team_id', $sub->id)->get();
        foreach ($users as $key => $user) {
            $user->role = $user->role();
            $user->mortgage = Commission::where('user_id', $user->id)->sum('mortgage');
        }
        return response()->json($users);
    }

    public function updateCommission(Request $request, $id)
    {

        $user = User::find($id);

        $user->commission = $request->commission;
        $user->save();
        return response()->json($user);

    }
}
