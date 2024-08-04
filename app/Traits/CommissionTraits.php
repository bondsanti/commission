<?php

namespace App\Traits;

trait CommissionTraits
{
    public function commissionSaleIn($users)
    {

        DB::connection('report')->table('production');
        return $users;
    }
}