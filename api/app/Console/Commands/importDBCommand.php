<?php

namespace App\Console\Commands;
use App\Post;

use Exception;
use Illuminate\Console\Command;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\Storage;


class importDBCommand extends Command{
    protected $signature = "import:DB";

    protected $description = "";
    
    public function handle(){
        //escreve em um arquivo o estado da importação
        $importFileStatusPath = "/var/www/html/storage/app/importStatus.json";
        $importFileStatus = fopen($importFileStatusPath, 'w');
        fwrite($importFileStatus, json_encode(array("status" => 0, 'n' => 0)));
        fclose($importFileStatus);

        //variaveis
        set_time_limit(0);
        ini_set('memory_limit','1024M');
        $filePath = "/var/www/users.csv";
        $numberRowsCsv = shell_exec("wc -l ".$filePath);
        $numberRowsCsv = explode(" ", $numberRowsCsv);
        $numberRowsCsv = intval($numberRowsCsv[0]);
        $host = [
            'esServer'
        ];

        $client = ClientBuilder::create()->setHosts($host)->build();
        
        //fica tentando conectar ao elasticsearch, pois o mesmo demora a subir
        while(true){
            try{
                $client->nodes()->stats();
                break;
            }catch(Exception $e){
                echo "\n\nFailed connect, try again\n\n";
                sleep(10);
            }
        }

        $params['index'] = "pic";
        $dbDocsNumber = 0;
        
        //verifica se o indice existe e pega o numero de registros dele
        try{
            $response = $client->indices()->stats($params);
            $dbDocsNumber = $response["indices"]["pic"]["total"]["docs"]["count"];
        }catch(Exception $ex){
        }
        
        echo "CSV: $numberRowsCsv\nDB: $dbDocsNumber\n";
        
        //verifica se todos os registro do csv estâo no ES
        if(($dbDocsNumber < $numberRowsCsv))
        {
            echo "exec import\n";        

            //seta estado importando no arquivo
            $importFileStatus = fopen($importFileStatusPath, 'w');
            fwrite($importFileStatus, json_encode(array("status" => 1, 'n' => 0)));
            fclose($importFileStatus);
            
            //carrega as lista de prioridade na memoria
            $list1 = [];
            $list2 = [];
            $fl = fopen("/var/www/lista_relevancia_1.txt", 'r');
            while($row = fgets($fl)){
                $list1[trim($row)] = true;
            }
            fclose($fl);

            $fl = fopen("/var/www/lista_relevancia_2.txt", 'r');
            while($row = fgets($fl)){
                $list2[trim($row)] = true;
            }
            fclose($fl);

            //o i é quantos registros no bloco e o j a quantidade de blocos importados
            $f = fopen($filePath, 'r');
            $i = 0;
            $j = 0;
            $importlimit = 100000;
            while($row = fgetcsv($f)){
                $i++;
                $params['body'][] = [
                    'index' => [
                        '_index' => 'pic',
                        '_type' => 'pay',
                        '_id' => $row[0],
                    ]
                ];

                //define peso para fazer a busca ranqueada
                $weight = 0;
                if(array_key_exists(trim($row[0]), $list1)){
                    $weight = 2;
                    echo "lista2\n";
                }
                if(array_key_exists(trim($row[0]), $list2)){
                    $weight = 1;
                    echo "lista1\n";
                }
                
                
                $params['body'][] = [
                    'name' => $row[1],
                    'username' => $row[2],
                    'weight' => $weight
                ];
                if($i >= $importlimit){
                    $client->bulk($params);
                    $n = ++$j*$importlimit;
                    echo $n."\n";
                    $i = 0;
                    $importFileStatus = fopen($importFileStatusPath, 'r');
                    fwrite($importFileStatus, json_encode(array("status" => 1, 'n' => $n)));
                    fclose($importFileStatus);
                    $params = ['body' =>    []];
                }
            }
            if($i > 0){
                $client->bulk($params);
                $n = ($j*$importlimit)+$i;
                echo $n." imports\n";
            }
            fclose($f);
        }else{
            echo "No import require\n";
        }

        //escreve no arquivo que a importação foi concluida
        $importFileStatus = fopen($importFileStatusPath, 'w');
        fwrite($importFileStatus, json_encode(array("status" => 2)));
        fclose($importFileStatus);
        echo "\n\n\n\nImport Finish\n\n\n\n";
        return 0;
    }

}