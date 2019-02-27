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

        $importFileStatusPath = "/var/www/html/storage/app/importStatus.json";
        $importFileStatus = fopen($importFileStatusPath, 'w');
        fwrite($importFileStatus, json_encode(array("status" => 0)));
        fclose($importFileStatus);

        set_time_limit(0);
        $filePath = "/var/www/html/users.csv";
        $numberRowsCsv = shell_exec("wc -l ".$filePath);
        $numberRowsCsv = explode(" ", $numberRowsCsv);
        $numberRowsCsv = intval($numberRowsCsv[0]);
        $host = [
            'esServer'
        ];

        $client = ClientBuilder::create()->setHosts($host)->build();
        
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
        
        try{
            $response = $client->indices()->stats($params);
            $dbDocsNumber = $response["indices"]["pic"]["total"]["docs"]["count"];
        }catch(Exception $ex){
        }
        
        echo "CSV: $numberRowsCsv\nDB: $dbDocsNumber\n";
        
        if(($dbDocsNumber < $numberRowsCsv))
        {
            echo "exec import";        

            $importFileStatus = fopen($importFileStatusPath, 'w');
            fwrite($importFileStatus, json_encode(array("status" => 1)));
            fclose($importFileStatus);
            
            $f = fopen($filePath, 'r');
            $i = 0;
            $j = 0;
            $importlimit = 10000;
            while($row = fgetcsv($f)){
                $i++;
                $params['body'][] = [
                    'index' => [
                        '_index' => 'pic',
                        '_type' => 'pay',
                        '_id' => $row[0],
                    ]
                ];
                
                $params['body'][] = [
                    'name' => $row[1],
                    'username' => $row[2]
                ];
                if($i >= $importlimit){
                    $client->bulk($params);
                    echo ++$j*$importlimit."\n";
                    $i = 0;
                    
                    $params = ['body' =>    []];
                }
            }
            if($i > 0){
                $client->bulk($params);
                echo ($j*$importlimit)+$i." imports\n";
            }
            fclose($f);
        }else{
            echo "No import require\n";
        }

        $importFileStatus = fopen($importFileStatusPath, 'w');
        fwrite($importFileStatus, json_encode(array("status" => 2)));
        fclose($importFileStatus);

        return 0;
    }

}