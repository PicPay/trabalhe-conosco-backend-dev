<?php

use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

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
        $this->table = 'user_pic_pays';
        $this->filename = app_path() . '/users.csv';
    }

    public function run()
    {
        $files = $this->fsplit();
        foreach ($files as $users) {
            echo("\n Run in file: " . $users);
            $seedData = $this->seedFromCSV($users);
            DB::table($this->table)->insert($seedData);
        }
        $file = new Filesystem;
        $file->cleanDirectory('storage/seed');
        unlink(app_path() . '/users.csv');
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
                    if (!$header) {
                        $header = $row;
                    } else {
                        $data[] = array_combine($header, $row);
                    }
                }
                fclose($handle);
            }

            return $data;
        }catch (Exception $e){
            return $data;
        }
    }

    /**
     * @param $file
     * @param int $buffer
     * @return array
     */
    private function fsplit($buffer=800000){
        if(!file_exists($this->filename)){
            // Open our files (in binary mode)
            echo("Baixando arquivo \n");
            $file = gzopen('https://s3.amazonaws.com/careers-picpay/users.csv.gz', 'rb');
            $out_file = fopen($this->filename, 'wb');

            // Keep repeating until the end of the input file
            echo("Salvando arquivo temporário \n");
            while (!gzeof($file)) {
                //Read buffer-size bytes
                //Both fwrite and gzread and binary-safe
                fwrite($out_file, gzread($file, 10000));
            }

            // Files are done, close files
            fclose($out_file);
            gzclose($file);
        }
        echo("Dividindo arquivo \n");
        //get file size
        $file_size = filesize($this->filename);
        //no of parts to split
        $parts = $file_size / $buffer;
    
        //store all the file names
        $file_parts = array();
        $file_handle = fopen($this->filename,'r');
    
        for($i=0;$i < $parts;$i++){
            //open file to read buffer sized amount from file
            $file_part = fread($file_handle, $buffer);
            //path to write the final files the filename of the part
            $file_part_path = storage_path("seed/") . "users".$i.".csv";
            //open the new file [create it] to write
            $file_new = fopen($file_part_path,'w+');
            //write the part of file
            fwrite($file_new, $file_part);
            //add the name of the file to part list [optional]
            array_push($file_parts, $file_part_path);
            //close the part file handle
            fclose($file_new);
        }    
        //close the main file handle
        fclose($file_handle);
        return $file_parts;
    }

}