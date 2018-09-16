<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

echo extension_loaded("mongodb") ? "loaded\n" : "not loaded\n";

$connection = new MongoDB\Driver\Manager("mongodb://mongo:27017");
//$client = new MongoDB\Client("mongodb://localhost:27017");
var_dump($connection);

//var_dump($client);


try {

    //$connection = new MongoDB\Driver\Manager( 'string de conexao' );
    $query = new MongoDB\Driver\Query([], ['sort' => [ 'nome' => 1], 'limit' => 5]);

    $rows = $connection->executeQuery("banco.clientes", $query);    

    foreach ($rows as $row) {

        echo "$row->nome : $row->profissao\n";

    }
} catch (MongoDB\Driver\Exception\Exception $e) {
   $filename = basename(__FILE__);

   echo "Erro no arquivo $filename.\n";

   echo "Exception:", $e->getMessage(), "\n";

   echo "Arquivo:", $e->getFile(), "\n";

   echo "Linha:", $e->getLine(), "\n";    

}


?>