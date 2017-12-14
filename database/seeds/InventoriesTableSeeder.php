<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InventoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('inventories')->insert([
            'name' => "Pouches",
            'desc' => 'All pouches',
            'ordered' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('inventories')->insert([
            'name' => "Bags",
            'desc' => 'All bags',
            'ordered' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

    }
}
