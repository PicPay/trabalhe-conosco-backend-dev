<?php
/**
 * Created by PhpStorm.
 * User: joaopaulodunder
 * Date: 19/12/18
 * Time: 11:26
 */

require "vendor/autoload.php";
use Basemkhirat\Elasticsearch\Connection;
$connection = Connection::create([
    'servers' => [
        [
            "host" => '127.0.0.1',
            "port" => 9200,
            'user' => '',
            'pass' => '',
            'scheme' => 'http',
        ]
    ],
    'index' => 'my_index'
]);
/*
$connection->type("users")->id('TAj7xmcB52qOqqnQx7Ae')->update([
    "relevancia" => 2
]);*/
//
$documents = $connection->type('users')->insert([
    "id_documento" => "Test document",
    "name" => "Name content",
    "username" => "Username content"
]);

/*# access the query builder using created connection
$documents = $connection->search("hello")->get();*/

var_dump($documents);