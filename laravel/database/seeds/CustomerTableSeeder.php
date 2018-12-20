<?php

use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //First we need to download and prepare the DB dump that will seed the DB
        $this->downloadAndPrepareDBDump();

        //Once the download and zip is done we start to seed the DB
        $file = base_path().'/database/temp/Tmpfile.csv';
        $handle = fopen($file, "r");
        print_R("Seeding the customer table, this will take a long while");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                // process the line read.
                $line_arr = explode(',', $line);
                $line_arr[2] = preg_replace('/\s+/', '',$line_arr[2]);
                print_r("Inserting customer: " . $line_arr[1] . "\n");
                \DB::table('customer')->insert(
                    array(
                        'token' => $line_arr[0],
                        'name' => $line_arr[1],
                        'username' => $line_arr[2],
                        'created_at' => date('Y-m-d H:i:s',time()),
                        'updated_at' => date('Y-m-d H:i:s',time()),
                    )
                );
            }

            fclose($handle);
        } else {
            // error opening the file.
            print_r("error opening file");
        }

    }

    private function downloadGzFile($url){
        return file_put_contents("database/temp/Tmpfile.csv.gz", fopen($url, 'r'));
    }

    private function downloadAndPrepareDBDump(){
        $flag = true;
        print_r("\n\033[1;33mPlease wait while we download the DB file \033[0m \n");

//        $this->downloadGzFile("https://s3.amazonaws.com/careers-picpay/users.csv.gz");
        print_r("\033[1;32mDownload finished \033[0m\n");
        print_r("\n\033[1;33mStarting Decompression \033[0m\n");
        flush();
//        $this->unzip_gz();
        print_r("\033[1;32mFinished Decompression \033[0m\n");

        flush();
        return true;

    }

    private function unzip_gz(){
        //This input should be from somewhere else, hard-coded in this example
        $file_name = '/database/temp/Tmpfile.csv.gz';

        // Raising this value may increase performance
        $buffer_size = 10240; // read 4kb at a time
        $out_file_name = str_replace('.gz', '', $file_name);

        // Open our files (in binary mode)
        $file = gzopen($file_name, 'rb');
        $out_file = fopen($out_file_name, 'wb');

        // Keep repeating until the end of the input file
        while (!gzeof($file)) {
            // Read buffer-size bytes
            // Both fwrite and gzread and binary-safe
            fwrite($out_file, gzread($file, $buffer_size));
        }

        // Files are done, close files
        fclose($out_file);
        gzclose($file);
    }


}
