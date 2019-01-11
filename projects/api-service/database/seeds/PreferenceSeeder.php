<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Util\CsvUtil;

/**
 * Class PreferenceSeeder
 */
class PreferenceSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = base_path() . '/database/seeds/imports/lista_relevancia_1.csv';
        $csvFile2 = base_path() . '/database/seeds/imports/lista_relevancia_2.csv';
        $preference = (new CsvUtil())->csv_to_array('preference', $csvFile);
        $preference2 = (new CsvUtil())->csv_to_array('preference', $csvFile2);

        $this->insertSeedsPreference($preference, 10);
        $this->insertSeedsPreference($preference2, 5);
    }

    /**
     * @param int $position
     */
    private function insertSeedsPreference($array, int $position)
    {
        foreach ($array as $row) {
            // return false if there is no data
            if (empty($row)) {
                return;
            }

            DB::table('preference')->insert([
                'user_id' => $row['user_id'],
                'position' => $position,
            ]);
        }
    }
}
