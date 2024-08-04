<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\User;
use App\Models\Commission;

class checkCommission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkCommission';

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
        $report = DB::connection('report')
        ->select("SELECT DISTINCT(product.pid) FROM sub_sale JOIN product ON product.sid = 36 WHERE product.ApprovalLimit1 > 0 AND product.status = 'Mortgaged' AND resultdate BETWEEN '2019-01-01' AND NOW() AND calculate = 0 ");

        $data = [];
        foreach ($report as $key => $value) {
            $value->report = DB::connection('report')
            ->select("SELECT * FROM product WHERE pid = $value->pid ")[0];

            $value->user = User::where('code', $value->report->subid)->first();
            if ($value->user == null) {
                $user = DB::connection('sub_sale')
                        ->select("SELECT DISTINCT(product.pid) FROM sub_sale JOIN product ON product.sid = 36 WHERE product.ApprovalLimit1 > 0 AND product.status = 'Mortgaged' AND resultdate BETWEEN '2019-01-01' AND NOW() AND calculate = 0 ");
                $user = new User;
            }
        }
    }
}
