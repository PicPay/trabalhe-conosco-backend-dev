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
    protected $signature = 'save:relevance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Relevance';

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

        //DB::table('clients')->update(['relevance' => 3]);

        $handle = fopen("storage/app/lista_relevancia_1.txt", "r");
        if ($handle) {
            $i = 0;
            while (($line = fgets($handle)) !== false) {

                DB::table('clients')->where('ident',$line)->update(['relevance' => 2]);
            }

            fclose($handle);
        }

        $handle = fopen("storage/app/lista_relevancia_2.txt", "r");
        if ($handle) {
            $i = 0;
            while (($line = fgets($handle)) !== false) {

                DB::table('clients')->where('ident',$line)->update(['relevance' => 1]);
            }

            fclose($handle);
        }
    }
}
