<?php

namespace App\Console\Commands;

use App\Http\Controllers\CommissionController;
use Illuminate\Console\Command;
use DB;
use App\Http\Controllers\SaleInController;

class runCommission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    // ต้องมีเกณฑ์รายเดือนอย่างน้อย 1 เดือน ถ้าทำผลงานไม่ได้ตามเกณฑ์ติดต่อกัน 3 เดือน จะถูกลดตำแหน่ง

    protected $signature = 'command:runCommission';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $c = new SaleInController;
        $c->calculateCommission(); // Run Conjob every 16
        $c->covertPointToMoney(); // Run Conjob every 16
        $c->checkAllowance(); // Run Conjob every 16
        DB::table('points')->whereNull('commission_id')->delete();
        $c->checkCommissionVP();

        // outsource
        $com = new CommissionController;
        $com->getDataFromReportByDate();
    }
}