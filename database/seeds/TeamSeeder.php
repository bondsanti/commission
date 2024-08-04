<?php

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team = new Team;
        $team->name = 'Sale Internal';
        $team->save();

        $team = new Team;
        $team->name = 'Agent X';
        $team->save();

        $team = new Team;
        $team->name = 'Agent ';
        $team->save();
    }
}
