<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create(['id' => 1, 'name' => 'Admin', 'email' => 'admin@admin.com', 'password' => '$2y$10$g1xF0s0kZTPmKo.r89sjJ.oWpteVxOUL.ZchYxDUv2HYH30ImLk4.', 'remember_token' => '',]);
    }
}
