<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\User;
use App\Models\Commission;
use App\Models\Role;
use App\Models\Role_Log;

class checkPosition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    // ต้องมีเกณฑ์รายเดือนอย่างน้อย 1 เดือน ถ้าทำผลงานไม่ได้ตามเกณฑ์ติดต่อกัน 3 เดือน จะถูกลดตำแหน่ง

    protected $signature = 'command:potision';


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
        $users =  User::whereHas('roles', function ($q) {
            $q->whereNotIn('name', ['Admin']);
        })->get();
        $currentDate = date('Y-m-d');
        $last3Month = date('Y-m-d', strtotime(' -3 months'));
        foreach ($users as $key => $user) {
            $commission = Commission::where('user_id', $user->id)
                ->where('updated_at', '<=', $currentDate)
                ->where('updated_at', '>=', $last3Month)
                ->latest()->first();
            if ($commission == null) {
                $currantRole = $user->role()->id;
                if ($currantRole == 2) {
                    continue;
                } else {
                    $nextRole = $currantRole - 1;
                    $role_log = new Role_Log;
                    $role_log->user_id = $user->id;
                    $role_log->role_before_id = $currantRole;
                    $role_log->role_after_id = $nextRole;
                    $role_log->action = 'down';
                    $role_log->save();
                }
            }
        }
    }
}