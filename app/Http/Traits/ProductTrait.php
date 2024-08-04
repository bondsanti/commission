<?php

namespace App\Traits;


use DB;

/**
 *
 */
trait ProductTrait
{
    public function getMortgage()
    {
        return  DB::select(" SELECT U.name_th, U.code , U.position_id , P.*  FROM vbeyond_report.product P LEFT JOIN hr.users U ON P.subid = U.code WHERE U.department_id = 3 AND P.status = 'Mortgaged' AND P.ApprovalLimit1 > 0 AND resultdate BETWEEN '" . date('Y-07-01') . "'  AND '" . date('Y-m-31') . "' ");
    }

    public function getMortgageNetwork()
    {
        return  DB::select(" SELECT U.name_th, U.code , U.position_id , P.*  FROM vbeyond_report.product P LEFT JOIN hr.users U ON P.subid = U.code WHERE U.department_id = 3 AND P.status = 'Mortgaged' AND P.ApprovalLimit1 > 0 AND resultdate BETWEEN '" . date('Y-07-01') . "'  AND '" . date('Y-m-31') . "' ");
    }

    public function getOwnerProduct($pid = 0)
    {

        return  DB::select(" SELECT U.name_th, U.code , U.position_id , P.*  FROM vbeyond_report.product P LEFT JOIN hr.users U ON P.subid = U.code WHERE U.department_id = 3 AND P.status = 'Mortgaged' AND P.ApprovalLimit1 > 0 AND resultdate BETWEEN '" . date('Y-07-01') . "'  AND '" . date('Y-m-31') . "' ");
    }

    public function checkProductIsNetwork($pid)
    {
        return  DB::select(" SELECT U.name_th, U.code , U.position_id , P.*  FROM vbeyond_report.product P LEFT JOIN hr.users U ON P.subid = U.code WHERE U.department_id = 3 AND P.status = 'Mortgaged' AND P.ApprovalLimit1 > 0 AND resultdate BETWEEN '" . date('Y-07-01') . "'  AND '" . date('Y-m-31') . "' ");
    }
}