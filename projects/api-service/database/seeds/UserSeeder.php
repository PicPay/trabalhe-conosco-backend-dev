<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Util\CsvUtil;

/**
 * Class UserSeeder
 */
class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = base_path() . '/database/seeds/imports/users.csv';
        $users = (new CsvUtil())->csv_to_array(null, $csvFile);

        foreach ($users as $row) {
            // return false if there is no data
            if (empty($row)) {
                return;
            }

            DB::table('users')->insert(
                array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'username' => $row['username'],
                    'email' => $row['username'] . '@gmail.com',
                    'password' => bcrypt('123'),
                    'created_at' => new DateTime()
                )
            );
        }
    }
}
