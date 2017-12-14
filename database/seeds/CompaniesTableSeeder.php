<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'name' => "Dolodol",
            'nick_name' => '',
            'street' => '4144 Bennett Ave',
            'suite' => NULL,
            'city' => 'Corona',
            'state' => 'CA',
            'country' => 'US',
            'zipcode' => '92883',
            'phone' => '2064304696',
            'email' => 'blessue@gmail.com',
            'phone_option' => '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
