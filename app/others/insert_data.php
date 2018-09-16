<?php
    $manager = new MongoDB\Driver\Manager("mongodb://mongo:27017");

    $bulk = new MongoDB\Driver\BulkWrite;           

    //Ler Arquivo
    $doc = ['_id' => new MongoDB\BSON\ObjectID, 
            'nome' => "Joao", 
            'profissao' => "Programador", 
            "salario" => 100000000
        ];       

    $bulk->insert($doc);
    $manager->executeBulkWrite('picpay.users', $bulk);

?>