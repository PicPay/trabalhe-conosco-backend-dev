<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Cache;
use DB;

class ImportacaoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando de importa os dados do csv para o banco de dados';

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
        Cache::flush();
        echo "Aguarde a importacao de dados. Horario de inicio: ".date("H:i:s").PHP_EOL;
        echo "Este procedimento levará vários minutos. Faça um café para passar o tempo :)".PHP_EOL;
        
        // IMPORTAÇÃO DOS DADOS
        $file = 'http://www.vgusmao.com.br/picpay/users.csv';
        DB::connection()->getpdo()->exec("LOAD DATA LOCAL INFILE '".$file."' INTO TABLE users_picpays FIELDS TERMINATED BY ',' LINES TERMINATED BY '\r\n'");

        $handle = fopen("http://www.vgusmao.com.br/picpay/lista_relevancia_1.txt", "rb");
        $contents = stream_get_contents($handle);
        fclose($handle);
        $vetRelevancia1 = explode("\n",$contents);
        Cache::forever('relevancia1', $vetRelevancia1);

        $handle = fopen("http://www.vgusmao.com.br/picpay/lista_relevancia_2.txt", "rb");
        $contents = stream_get_contents($handle);
        fclose($handle);
        $vetRelevancia2 = explode("\n",$contents);
        Cache::forever('relevancia2', $vetRelevancia2);
        // -------------------------
        $user = new User;
        $user->name = "Picpay";
        $user->email = "picpay@picpay.com";
        $user->name = md5("chamaeupicpay");
        $user->save();
        // -------------------------
        echo "Importacao finalizada com sucesso. Horario fim: ".date("H:i:s").PHP_EOL;
    }
}
