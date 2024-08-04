<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'user';
    protected $table = 'tb_position';


    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}