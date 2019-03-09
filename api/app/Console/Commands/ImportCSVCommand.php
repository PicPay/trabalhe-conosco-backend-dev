<?php

namespace App\Console\Commands;

define("ES_NOT_READY", 0);
define("ES_IMPORTING", 1);
define("ES_READY", 2);

use Exception;
use Illuminate\Console\Command;
use Elasticsearch\ClientBuilder;
use App\Variables;

class ImportCSVCommand extends Command
{
    protected $signature = "import:CSV";

    protected $description = "";

    private $host = [
        'esServer'
    ];

    public function handle()
    {
        //Seta o status do Elastic Search para consultas do frontend
        $this->setESStatus(ES_NOT_READY);

        //Previne ultrapassar o tempo e o limite de memoria
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $client = $this->getESConnection();

        //fica tentando conectar ao elasticsearch, pois o mesmo demora a subir
        $this->waitES($client);

        $numberRowsCsv = $this->getCsvNumRows("/var/www/users.csv");
        $dbDocsNumber = $this->getIndexNumRows($client, 'pic');

        echo "CSV: $numberRowsCsv\nDB: $dbDocsNumber\n";

        //verifica se todos os registro do csv estâo no ES por uma checagem simples de numeros
        //para tomar a decisao de importar ou não importar o CSV
        if (($dbDocsNumber < $numberRowsCsv)) {
            echo "exec import\n";

            $this->setESStatus(ES_IMPORTING);

            //carrega as lista de prioridade na memoria
            $priorityList1 =  $this->getPriotityList("/var/www/lista_relevancia_1.txt");
            $priorityList2 = $this->getPriotityList("/var/www/lista_relevancia_2.txt");

            $this->doImport($client, $priorityList1, $priorityList2, "/var/www/users.csv");
        } else {
            echo "No import require\n";
        }

        $this->setESStatus(ES_READY);
        echo "\n\n\n\nImport Finish\n\n\n\n";
        return 0;
    }

    private function setESStatus($status)
    {
        $esstatus = Variables::where("name", 'esstatus')->first();
        $esstatus->value = "$status";
        $esstatus->save();
        return;
    }

    private function waitES($client)
    {
        while (true) {
            try {
                $client->nodes()->stats();
                break;
            } catch (Exception $e) {
                echo "\n\nFailed connect, I Will try again\n\n\n";
                sleep(10);
            }
        }
    }

    private function getESConnection()
    {

        return ClientBuilder::create()->setHosts($this->host)->build();
    }

    private function getCsvNumRows($csvFilePath)
    {
        $numberRowsCsv = shell_exec("wc -l " . $csvFilePath);
        $numberRowsCsv = explode(" ", $numberRowsCsv);
        $numberRowsCsv = intval($numberRowsCsv[0]);
        return $numberRowsCsv;
    }

    //recupera o numero atual de documentos no index
    private function getIndexNumRows($client, $indice)
    {
        $params['index'] = $indice;
        try {
            $response = $client->indices()->stats($params);
            return $response["indices"][$indice]["total"]["docs"]["count"];
        } catch (Exception $ex) { }
        return 0;
    }

    private function getPriotityList($path)
    {
        $list = [];
        $fl = fopen($path, 'r');
        while ($row = fgets($fl)) {
            $list[trim($row)] = true;
        }
        fclose($fl);
        return $list;
    }

    public function doImport($client, $priorityList1, $priorityList2, $filePath)
    {
        $f = fopen($filePath, 'r');
        $nLastBloco = 0;
        $Blocos = 0;
        $importlimit = 100000;
        while ($row = fgetcsv($f)) {
            $nLastBloco++;
            $params['body'][] = [
                'index' => [
                    '_index' => 'pic',
                    '_type' => 'pay',
                    '_id' => $row[0],
                ]
            ];

            //define peso para fazer a busca ranqueada
            $weight = 0;
            if (array_key_exists(trim($row[0]), $priorityList1)) {
                $weight = 2;
                echo "lista1\n";
            }
            if (array_key_exists(trim($row[0]), $priorityList2)) {
                $weight = 1;
                echo "lista2\n";
            }


            $params['body'][] = [
                'name' => $row[1],
                'username' => $row[2],
                'weight' => $weight
            ];
            if ($nLastBloco >= $importlimit) {
                $client->bulk($params);
                $n = ++$Blocos * $importlimit;
                echo $n . "\n";
                $nLastBloco = 0;
                $params = ['body' => []];
            }
        }
        if ($nLastBloco > 0) {
            $client->bulk($params);
            $n = ($Blocos * $importlimit) + $nLastBloco;
            echo $n . " imports\n";
        }
        fclose($f);
    }
}
