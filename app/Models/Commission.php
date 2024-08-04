<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = ['name', 'commission', 'mortgage', 'total', 'status', 'approve_limit', 'customer_name', 'sale_id', 'sub_team_id', 'user_id', 'team_id', 'approved'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sales()
    {
        return $this->belongsTo(User::class, 'sale_id');
    }

    public function teams()
    {
        return $this->belongsTo(User::class, 'team_id');
    }

    public function sub_team()
    {
        return $this->belongsTo(Sub_team::class, 'sub_team_id');
    }
}