<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        \DB::table('admins')->insert([
            'f_name' => 'Super',
            'f_name' => 'Super',
            'email' => 'superadmin@gmail.com',
            'phone' => '123456789',
            'type' => 'superadmin',
            'code' => '349534',
            'password' => \Hash::make('secret'),
        ]);
    }
}
