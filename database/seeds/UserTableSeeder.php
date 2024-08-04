<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'Admin';
        $user->thai_name = 'Admin';
        $user->eng_name = 'Admin';
        $user->email = 'admin@test.com';
        $user->password = bcrypt('123456');

        $user->save();
        $user
       ->roles()
       ->attach(Role::where('name', 'Admin')->first());
    }
}
