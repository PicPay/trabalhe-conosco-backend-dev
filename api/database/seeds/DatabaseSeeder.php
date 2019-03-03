<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        DB::table('users')->insert([
            'email' => 'picpay@picpay.com',
            'password' => password_hash('admin', PASSWORD_BCRYPT)
        ]);
        DB::table('variables')->insert([
            'name' => 'esstatus',
            'value' => '0'
        ]);
    }
}
