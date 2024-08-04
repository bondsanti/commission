<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new Setting;
        $setting->name = 'approve';
        $setting->description = 'How many people need to accept the role?';
        $setting->value = 1;
        $setting->save();
    }
}
