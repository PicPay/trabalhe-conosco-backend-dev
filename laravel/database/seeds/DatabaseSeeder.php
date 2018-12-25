<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        /**
         * If you uncomment the block below, you can seed the customer table with the DB provided in the TEST it will take more than 4 hours to completely seed it.
         * It was a insane try, to populate it, since is a setup approach, I do think is something valid, but commented out for obvious reasons.
         * The seeder will download, unzip and seed the DB with the 8 million customers.
         */

//        $this->call(CustomerTableSeeder::class);
//        $this->command->info('Customer table seeded!');


        $this->call(MainListScoreTableSeeder::class);
        $this->command->info('Main list score table seeded!');

        $this->call(SecondaryListScoreTableSeeder::class);
        $this->command->info('Secondary list score table seeded!');

        Model::reguard();
    }
}
