<?php


$loader = require_once __DIR__.'/../vendor/autoload.php';

\Symfony\Component\Debug\Debug::enable();

$app = require __DIR__.'/../app/app.php';

$app['debug'] = true;

$app->run();