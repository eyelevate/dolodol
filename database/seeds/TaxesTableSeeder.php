<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TaxesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taxes')->insert([
            'rate' => 0.0825,
            'status' => 1,
            'end' => NULL,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
