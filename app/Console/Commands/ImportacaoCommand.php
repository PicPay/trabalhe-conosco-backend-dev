<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UsersPicpay;
use App\User;
use DB;
use Hash;

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
    protected $description = 'Comando que importa os dados do csv para o banco de dados';

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
        UsersPicpay::truncate();
        User::truncate();
        
        echo "Começou em: ".date("H:i:s").PHP_EOL;
        echo "Aguarde a importacao dos dados. Este procedimento levará vários minutos.".PHP_EOL;        
        echo "Etapa 1 de 5 - Importando o .csv para o banco de dados".PHP_EOL;        
       
        $file = "http://www.vgusmao.com.br/picpay/users.csv";
        DB::connection()->getpdo()->exec("LOAD DATA LOCAL INFILE '".$file."' INTO TABLE users_picpays FIELDS TERMINATED BY ',' LINES TERMINATED BY '\r\n' (codigo, name, login) ");
      
        echo "Etapa 2 de 5 - Configurando registros com relevância".PHP_EOL; 
        $handle = fopen("http://www.vgusmao.com.br/picpay/lista_relevancia_1.txt", "rb");
        $contents = stream_get_contents($handle);
        fclose($handle);
        $vetRelevancia1 = array_chunk(explode("\n",$contents), 30);
        foreach($vetRelevancia1 as $v):
            $v_mod = array_map(function($v){ return "'".$v."'"; }, $v);
            $query = implode(',',$v_mod);
            DB::update("UPDATE users_picpays SET relevancia = 2 WHERE codigo IN ($query)");    
        endforeach;

        $handle = fopen("http://www.vgusmao.com.br/picpay/lista_relevancia_2.txt", "rb");
        $contents = stream_get_contents($handle);
        fclose($handle);
        $vetRelevancia2 = array_chunk(explode("\n",$contents), 30);
        foreach($vetRelevancia2 as $v):
            $v_mod = array_map(function($v){ return "'".$v."'"; }, $v);
            $query = implode(',',$v_mod);
            DB::update("UPDATE users_picpays SET relevancia = 1 WHERE codigo IN ($query)");    
        endforeach;
        
        echo "Etapa 3 de 5 - Indexando as colunas para pesquisa com o elasticsearch".PHP_EOL; 
        
        $fator_incr = 15000;
        $chunk_inicial = 1;
        $chunk_final = $fator_incr;        
        $query = UsersPicpay::where('id_sis', '<',$chunk_final)->get()->count();
        while($query > 0):
            $users = UsersPicpay::where('id_sis', '>=' ,$chunk_inicial)->where('id_sis', '<',$chunk_final)->get();
            $users->addToIndex();
            $chunk_inicial += $fator_incr;
            $chunk_final += $fator_incr;
            $query = UsersPicpay::where('id_sis','>',$chunk_inicial)->where('id_sis', '<',$chunk_final)->get()->count();
        endwhile;

        echo "Etapa 4 de 5 - Criando usuário para logar no sistema.".PHP_EOL;

        $user = new User();
        $user->name = "DevPHP Picpay";
        $user->password = Hash::make('chamaeupicpay');
        $user->email = 'picpay@picpay.com';
        $user->save();
        
        echo "Etapa 5 de 5 - Importação concluída com sucesso.".PHP_EOL;
        echo "Finalizou em: ".date("H:i:s").PHP_EOL;
        
    }
}
