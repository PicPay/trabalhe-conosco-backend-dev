<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';

$app = new \Slim\App;

$app->get('/api/busca', function (Request $request, Response $response) {

});

require '../src/routes/busca.php';

$app->run();
