<?php

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = new Company;
        $company->name = 'Vbyond';
        $company->save();

        $company = new Company;
        $company->name = 'Vbland';
        $company->save();

        $company = new Company;
        $company->name = 'Dynamic';
        $company->save();
    }
}
