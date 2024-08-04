<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_employee = new Role();
        $role_employee->name = 'Admin';
        $role_employee->short_code = 'Admin';
        $role_employee->description = 'Admin';
        $role_employee->save();

        $role_employee = new Role();
        $role_employee->name = 'Sale';
        $role_employee->short_code = 'SALE';
        $role_employee->description = 'Sales';
        $role_employee->save();

        $role_manager = new Role();
        $role_manager->name = 'Team Leader';
        $role_employee->short_code = 'TL';
        $role_manager->description = 'Team Leader';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = 'Manager';
        $role_employee->short_code = 'MG';
        $role_manager->description = 'Manager';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = 'Senior Manager';
        $role_employee->short_code = 'SM';
        $role_manager->description = 'Senior Manager';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = 'Assistant Vice President';
        $role_employee->short_code = 'AVP';
        $role_manager->description = 'Assistant Vice President';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = 'Vice President';
        $role_employee->short_code = 'VP';
        $role_manager->description = 'Vice President';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = 'Managing Director';
        $role_employee->short_code = 'MD';
        $role_manager->description = 'Managing Director';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = 'Authorizer';
        $role_employee->short_code = 'AH';
        $role_manager->description = 'Authorizer';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = 'Account';
        $role_employee->short_code = 'AC';
        $role_manager->description = 'Account';
        $role_manager->save();

		$role_manager = new Role();
        $role_manager->name = 'Support';
        $role_employee->short_code = 'SP';
        $role_manager->description = 'Support';
        $role_manager->save();
    }
}
