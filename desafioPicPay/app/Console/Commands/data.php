<?php

namespace App\Console\Commands;

use App\Prioridade;
use App\User;
use App\UserPriority;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;

class Data extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import data from files';

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
        if (!file_exists("storage/files/lista_relevancia_1.txt")) {
            $this->info("O arquivo storage/files/lista_relevancia_1.txt não existe");
            return false;
        }
        if (!file_exists("storage/files/lista_relevancia_2.txt")) {
            $this->info("O arquivo storage/files/lista_relevancia_2.txt não existe");
            return false;
        }
        if (!file_exists("storage/files/users.csv")) {
            $this->info("O arquivo storage/files/users.csv não existe");
            return false;
        }

        $handle = fopen("storage/files/lista_relevancia_1.txt", "r");
        while ($line = fgets($handle, 1000)) {
            try {
                UserPriority::create([
                    "id" => str_replace("\n", "", $line),
                    "priority" => 1,
                ]);
                $this->info("$line importado com sucesso.");
            } catch (\Illuminate\Database\QueryException $e) {
                $this->warn("$line Já existe no banco.");
            }
        }
        fclose($handle);

        $handle = fopen("storage/files/lista_relevancia_2.txt", "r");
        while ($line = fgets($handle, 1000)) {
            try {

                UserPriority::create([
                    "id" => str_replace("\n", "", $line),
                    "priority" => 2,
                ]);
                $this->info("$line importado com sucesso.");
            } catch (\Illuminate\Database\QueryException $e) {
                $this->warn("$line Já existe no banco.");
            }
        }
        fclose($handle);
    }
}
