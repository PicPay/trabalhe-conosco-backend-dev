<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UsersSearch;

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

    private function file_get_contents_chunked($file,$chunk_size,$callback)
    {
        try
        {
            $handle = fopen($file, "r");
            $i = 0;
            while (!feof($handle))
            {
                call_user_func_array($callback,array(fread($handle,$chunk_size),&$handle,$i));
                $i++;
            }

            fclose($handle);

        }
        catch(Exception $e)
        {
             trigger_error("file_get_contents_chunked::" . $e->getMessage(),E_USER_NOTICE);
             return false;
        }

        return true;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Aguarde a importacao de dados. Horario de inicio: ".date("H:i:s").PHP_EOL;
        echo "Este procedimento levará vários minutos. Jogue Candy Crush ou faça um café para passar o tempo :)".PHP_EOL;
        
        $primeiroLoop = true;
        $primeiroElemento = '';
        $ultimoElemento = '';
        
        UsersSearch::truncate();
        
        $file = $this->file_get_contents_chunked("http://www.vgusmao.com.br/picpay/users.csv",50000,function($chunk,&$handle,$iteration) use(&$str, &$primeiroLoop, &$primeiroElemento, &$ultimoElemento )
        {   
            $result = explode("\r\n",$chunk);
            
            if (!$primeiroLoop)
                $primeiroElemento = array_shift($result);  

            if (!empty($primeiroElemento) && !empty($ultimoElemento)):
                array_unshift($result,$ultimoElemento.$primeiroElemento);
            endif;

            $ultimoElemento = array_pop($result); 

            $prepareSql = [];
            array_walk($result,function($item, $key) use(&$prepareSql){
                $v = explode(',',$item);
                $prepareSql[] = array(
                    "id"    =>  $v[0],
                    "nome"    =>  $v[1],
                    "username"    =>  $v[2]
                );
                
            });
            UsersSearch::insert($prepareSql);
            $primeiroLoop = false;

        });
        
        echo "Importacao finalizada com sucesso. Horario fim: ".date("H:i:s").PHP_EOL;
    }
}
