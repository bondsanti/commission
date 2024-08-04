<?php

namespace App\Http\Controllers;

use DB;

class Allowance
{
    private $method = '';

    public function __construct($method = '')
    {
        // telesales-daily ID 131
        // direct-sale-daily ID 137
        $method = strtolower(str_replace(' ', '-', $method));

        $this->method = $method;
    }

    public function calculate($sale, $product, $mortgage)
    {
        $bath = 0;
        $mortgage = count($mortgage);
        $app = count($product);
        $point = $sale->commission_point;
        $setting = DB::SELECT(DB::raw("SELECT `department_id`, `position_id`, `key`,left(value,1) as s,right(value,2) as  value ,left(value2,1) as s2,right(value2,2) as `value2`, `condition`,
            case 
            when `key`='Mortgage' and left(value,1) ='m' and  $mortgage  >= substr(`value`,2) and ifnull(`condition`,'') ='' then first_value  
            when `key`='Mortgage' and left(value,1) ='l' and  $mortgage  < substr(`value`,2) and ifnull(`condition`,'') ='App-in' and left(value2,1) ='m' and $app >=substr(value2,2)   then first_value
            when `key`='Mortgage' and left(value,1) ='l' and  $mortgage  < substr(`value`,2) and ifnull(`condition`,'') ='App-in' and left(value2,1) ='l' and $app < substr(value2,2)   then first_value 
            when `key`='Point' and left(value,1) ='m' and  $point  >= substr(`value`,2) and ifnull(`condition`,'') ='' then first_value  
            when `key`='Point' and left(value,1) ='m' and  $point  >= substr(`value`,2) and ifnull(`condition`,'') ='Point' and left(value2,1) = 'l' and $point < substr(value2,2)   then first_value
            else 0 end as val 
            FROM hr.settings_test
        WHERE position_id = '" . $sale->emp_id . "' 
        AND  description = '" . $this->method . "' "));
        if ($setting) {
            foreach ($setting as $key => $value) {
                $bath += $value->val;
            }
        }
        return $bath;
    }
}
