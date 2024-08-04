<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sub_team extends Model
{
    public function leader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
