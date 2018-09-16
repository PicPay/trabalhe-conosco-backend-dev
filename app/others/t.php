<?php 

// Manager Class
$manager = new MongoDB\Driver\Manager("mongodb://mongo:27017");

// Query Class
$query = new MongoDB\Driver\Query(array('joao' => "j"));

// Output of the executeQuery will be object of MongoDB\Driver\Cursor class
$cursor = $manager->executeQuery('picpay.users', $query);

// Convert cursor to Array and print result
print_r($cursor->toArray());


var_dump(manager);
$bulk = new MongoDB\Driver\BulkWrite;           

$doc = ['_id' => new MongoDB\BSON\ObjectID, 'nome' => "Jurupinga", 'profissao' => "Jacinto", "salario" => 100000000000000, "abc"=>10];       

$bulk->insert($doc);
$manager->executeBulkWrite('picpay.users', $bulk);

$regex = new MongoDB\BSON\Regex ( 'J');
$options = [
    'projection' => ['_id' => 0,'salario'=>0],
    'skip' => 5,
    'limit'=>5,
    'sort' => ['abc'=>-1]
 ];

//$cursor = $collection->find(array('street_name' => $regex));

//$query = new MongoDB\Driver\Query(array( '$or' => array('nome' => $regex, 'profissao'=> $regex), 'salario' => array('$gt' => 100)),$options);
$query = new MongoDB\Driver\Query(array( '$or' => array(array('nome' => $regex), array('profissao'=> $regex))),$options);
$cursor = $manager->executeQuery('picpay.users', $query);
//$a = $cursor->sort(array('salario'=>1));

echo "<pre>";print_r($cursor->toArray());echo "</pre>";
echo "aaaaaaaaaaaaaaa";?>