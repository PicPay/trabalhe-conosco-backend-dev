<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ImportPicPayFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'picpay:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar arquivos para o teste do picpay';

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
        $this->info("Atualizando configurações...");
        Artisan::call("config:clear");

        $this->info("Rodando migrações..");
        Artisan::call("migrate");

        $path_users_csv = storage_path('app/users.csv');
        $path_users_csv_gz = storage_path('app/users.csv.gz');
        $path_lista_relevancia_1 = storage_path('app/lista_relevancia_1.txt');
        $path_lista_relevancia_2 = storage_path('app/lista_relevancia_2.txt');

        // limpo as tabelas antes do teste
        $this->info('Limpando tabelas (caso já estejam popupadas)...');
        DB::statement('TRUNCATE TABLE contacts');
        DB::statement('TRUNCATE TABLE suggestions');


        //
        $this->info('');
        $this->info('Iniciando a importação de arquivos');

        // lista 1
        $this->info("Verificando arquivo '$path_lista_relevancia_1'...");
        if(file_exists($path_lista_relevancia_1) == false) {
            $this->info("Baixando '$path_users_csv'...");
            $this->download('https://raw.githubusercontent.com/jgcl/trabalhe-conosco-backend-dev/master/lista_relevancia_1.txt', $path_lista_relevancia_1);
        }
        $this->info("Importando '$path_lista_relevancia_1'...");
        $sql = "LOAD DATA LOCAL INFILE '$path_lista_relevancia_1' INTO TABLE imports FIELDS TERMINATED by ',' LINES TERMINATED BY '\n'";
        DB::statement('TRUNCATE TABLE imports');
        DB::connection()->getpdo()->exec($sql);
        DB::statement('insert into suggestions (id, token, level) select null as id, token, 1 as level from imports');
        DB::statement('TRUNCATE TABLE imports');

        $this->info('');


        // lista 2
        $this->info("Verificando arquivo '$path_lista_relevancia_2'...");
        if(file_exists($path_lista_relevancia_2) == false) {
            $this->info("Baixando '$path_users_csv'...");
            $this->download('https://raw.githubusercontent.com/jgcl/trabalhe-conosco-backend-dev/master/lista_relevancia_2.txt', $path_lista_relevancia_2);
        }
        $this->info("Importando '$path_lista_relevancia_2'...");
        $sql = "LOAD DATA LOCAL INFILE '$path_lista_relevancia_2' INTO TABLE imports FIELDS TERMINATED by ',' LINES TERMINATED BY '\n'";
        DB::statement('TRUNCATE TABLE imports');
        DB::connection()->getpdo()->exec($sql);
        DB::statement('insert into suggestions (id, token, level) select null as id, token, 2 as level from imports');
        DB::statement('TRUNCATE TABLE imports');

        // usuarios
        $this->info('');
        $this->info("Verificando arquivo '$path_users_csv'...");
        if(file_exists($path_users_csv) == false) {
            $this->info("Baixando e descompactando '$path_users_csv'...");
            $this->download('https://s3.amazonaws.com/careers-picpay/users.csv.gz', $path_users_csv_gz);
            $this->descompactar($path_users_csv_gz);
        }
        $this->info("Importando '$path_users_csv'...");
        $this->info("Truncando tabela...");
        DB::statement('TRUNCATE TABLE contacts');
        $this->info("Importando csv...");
        $sql = "LOAD DATA LOCAL INFILE '$path_users_csv' INTO TABLE contacts FIELDS TERMINATED by ',' LINES TERMINATED BY '\n'";
        DB::connection()->getpdo()->exec($sql);
        $this->info("Criando indices...");
        DB::statement("ALTER TABLE `contacts`  ADD FULLTEXT (`nome`, `username`);");

        // importando cadastros para o elasticsearch
        //$this->info('');
        //$this->info("Importando cadastros para o elastic search...");
        //Artisan::call("scout:import", ['model' => 'App\Contact']);

        $this->info('');
        $this->info("Fim");

    }



    public function descompactar($path)
    {
        $process = new Process("gzip -d $path");
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        //echo $process->getOutput();
        return true;
    }

    public function download($url, $path)
    {
        $process = new Process("curl $url > $path");
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        //echo $process->getOutput();
        return true;
    }
}
