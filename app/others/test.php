<?php 
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
session_start();
echo "TESTE";
echo "<BR>HU3<BR>";

$db = (new MongoDB\Client)->test;

echo extension_loaded("mongodb") ? "loaded\n" : "not loaded\n";
//require 'vendor/autoload.php'; // include Composer's autoloader

$client = new MongoDB\Client("mongodb://mongo:27017");
$dbs = $client->listDatabases();
/*
 $collection = (new MongoDB\Client("mongodb://127.0.0.1:27017"))->dbname->coll;
    try {        
        $mongo = new MongoDB\Driver\Manager("mongodb://127.0.0.1:27017");
        var_dump($mongo);
        $bulk = new MongoDB\Driver\BulkWrite;           
    
        $doc = ['_id' => new MongoDB\BSON\ObjectID, 'nome' => "Joao", 'profissao' => "Programador"];       
    
        $bulk->insert($doc);
        $mongo->executeBulkWrite('banco.usuarios', $bulk);
        //header('Location: listagem.php');    die();
    } catch (MongoDB\Driver\Exception\Exception $e) {
         $filename = basename(__FILE__);        
    
        echo "<BR>Erro no arquivo $filename.<br>";    
    
        echo "Exception:", $e->getMessage(), "<br>";    
    
        echo "Arquivo:", $e->getFile(), "<br>";
    
        echo "Linha:", $e->getLine(), "<br>";    
    
    }
    */
?>