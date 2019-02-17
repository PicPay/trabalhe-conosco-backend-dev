<?php

namespace MyApp;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \MyApp\controllers\HomeController;
use \MyApp\controllers\ApiController;

require 'vendor/autoload.php';
require 'config/config.inc.php';

$app = new \Slim\App(['settings' => $config]);

$container = $app->getContainer();

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new \PDO(
        'mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'],
        $db['pass']
    );
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    return $pdo;
};

$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('./templates', [
        'cache' => false
    ]);
    
    // Instantiate and add Slim specific extension
    $router = $c->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

//Authentication
$app->add(new \Tuupola\Middleware\HttpBasicAuthentication([
    "path" => "/api",
    "realm" => "Protected",
    "users" => [
        $config['api']['authentication']['user'] => $config['api']['authentication']['password']
    ]
]));

//Front-end
$app->get('/', HomeController::class . ':home');

//API
$app->get('/api/users', ApiController::class . ':getUsers');
$app->get('/api/user/[{id}]', ApiController::class . ':getUser');

$app->run();
