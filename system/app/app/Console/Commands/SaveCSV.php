<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SaveCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //

        $handle = fopen("../storage/app/users.csv", "r");
        if ($handle) {
            $i = 0;
            while (($line = fgets($handle)) !== false) {
                // separando os itens do csv
                $data = explode(",",$line);

                // salvando no banco
                DB::table('clients')->insert([
                    'ident' => $data[0],
                    'name' => $data[1],
                    'user' => str_replace("\r\n",'',$data[2])
                ]);
                $i++;
            }

            fclose($handle);
        }
    }
}
