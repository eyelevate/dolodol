<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'K',
            'last_name' => 'Huh',
            'role_id' => 1,
            'phone' => '6824723039',
            'email' => 'info@freyasfinejewelry.com',
            'password' => bcrypt('ilovepasta'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('users')->insert([
            'first_name' => 'Wondo',
            'last_name' => 'Choung',
            'role_id' => 1,
            'phone' => '2069315327',
            'email' => 'onedough83@gmail.com',
            'password' => bcrypt('0987poiu'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'first_name' => 'eddie ',
            'last_name' => 'Kim',
            'role_id' => 1,
            'phone' => '2145857776',
            'email' => 'woosshie@gmail.com',
            'password' => bcrypt('123456'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'first_name' => 'Richard ',
            'last_name' => 'Baek',
            'role_id' => 1,
            'phone' => '2014464811',
            'email' => 'Richard@cmleon.com',
            'password' => bcrypt('00000'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
