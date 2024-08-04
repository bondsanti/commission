<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role_Log extends Model
{
    protected $table = 'tb_role_log';
    protected $connection = 'user';


    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function roleBefore()
    {
        return $this->belongsTo(Role::class, 'role_before_id');
    }

    public function roleAfter()
    {
        return $this->belongsTo(Role::class, 'role_after_id');
    }
}