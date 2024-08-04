<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\sub_team;
use App\Models\Role;
use Auth;
use DB;

class User extends Authenticatable
{

    protected $connection = 'user';
    public $timestamps = false;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'sub_team_id', 'team_id', 'created_at', 'code', 'name_th', 'name_eng', 'company_id', 'position_id', 'department_id','sup_team'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function role($user_id = null)
    {

        $id = $user_id ?? Auth::id();
        $user = DB::select(" SELECT * FROM role_user WHERE user_id = $id");
        if ($user) {
            $user = head($user);
        } else {

            DB::table('role_user')->insert(['role_id' => Auth::user()->position_id, 'user_id' => $id]);
            // Auth::logout();
            $user = DB::select(" SELECT * FROM role_user WHERE user_id = $id");
        }

        return $user->role_id ? Role::find($user->role_id) : $user;
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'position_id');
    }

    // public function authorizeRoles($roles)
    // {
    //     if (is_array($roles)) {
    //         return $this->hasAnyRole($roles) ||
    //          abort(401, 'This action is unauthorized.');
    //     }
    //     return $this->hasRole($roles) ||
    //      abort(401, 'This action is unauthorized.');
    // }

    // public function hasAnyRole($roles)
    // {
    //     return null !== $this->roles()->whereIn('name', $roles)->first();
    // }

    // public function hasRole($role)
    // {
    //     return null !== $this->roles()->where('name', $role)->first();
    // }

    // public function hasNotRole($role)
    // {
    //     return null !== $this->roles()->where('name', '!=', $role)->first();
    // }

    public function teams()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function sub_team()
    {
        return $this->belongsTo(User::class, 'sub_team_id');
        // return $this->hasOne(sub_team::class);
    }

    public function companies()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function files()
    {
        return $this->belongsToMany(File::class);
    }

    public function leader($user)
    {
        $subteam = sub_team::find($user->sub_team_id);
        if ($subteam == null) return false;
        $subteam->user_id = sub_team::find($user->sub_team_id);
        $user = User::find($subteam->user_id);
        return ($user) ? $user : '';
    }
}