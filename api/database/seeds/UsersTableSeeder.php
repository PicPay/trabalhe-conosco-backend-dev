<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * DB table name
     *
     * @var string
     */
    protected $table;

    /**
     * CSV filename
     *
     * @var string
     */
    protected $filename;

    public function __construct()
    {

        $this->table = 'users';
        $this->filename = app_path() . '/users.csv';

    }

    public function run()
    {
        DB::table($this->table)->delete();
        $seedData = $this->seedFromCSV($this->filename);
        print_r($seedData[0]);
        DB::table($this->table)->insert($seedData);
    }

    /**
     * Collect data from a given CSV file and return as array
     *
     * @param $filename
     * @return array|bool
     */
    private function seedFromCSV($filename)
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return FALSE;
        }
    $count = 0;
        $header = [
            0 => "id",
            1 => "name",
            2 => "username"
        ];
        $data = array();
        try
        {
            if (($handle = fopen($filename, 'r')) !== FALSE) {
                while (($row = fgetcsv($handle)) !== FALSE) {
                    $count++;
                    if (!$header) {
                        $header = $row;
                    } else {
                        $data[] = array_combine($header, $row);
                    }
                }
                dd($count);
                fclose($handle);
            }
            dd(count($data));
            return $data;
        }catch (Exception $e){
            return $data;
        }
    }

}