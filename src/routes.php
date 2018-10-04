<?php

use Usuarios\Controllers\UsersController;
use Produtos\Controllers\ProductsController;
use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/products', function (Request $request, Response $response, array $args) {
	
	// Render index view
	$args["api"] = "products";
	
	return $this->renderer->render($response, 'fancy_api.phtml', $args);
});

$app->get('/products/json', function () {
	if(!file_exists("../swagger_products.json")) {
		$openapi = \OpenApi\scan('../src/Produtos');
		header('Content-Type: application/json');
		file_put_contents("../swagger_products.json", $openapi->toJson());
	}
	
	echo file_get_contents("../swagger_products.json");
});

$app->get('/users/findByName/{name}', function (Request $request, Response $response, array $args) {
	ini_set('display_errors', 0);
	// Render index view
	$users = new UsersController($response);
	return $response->withJson($users->findByName($args["name"]));

});

$app->get('/users/teste/{name}', function (Request $request, Response $response, array $args) {
	ini_set('display_errors', 0);
	// Render index view
	$users = new UsersController($response);
	return $response->withJson($users->teste($args["name"]));

});

$app->get('/users', function (Request $request, Response $response, array $args) {
	
	// Render index view
	$args["api"] = "users";
	
	return $this->renderer->render($response, 'fancy_api.phtml', $args);
});

$app->get('/users/json', function () {
	if(!file_exists("../swagger_users.json")) {
		$openapi = \OpenApi\scan('../src/Usuarios');
		header('Content-Type: application/json');
		file_put_contents("../swagger_users.json", $openapi->toJson());
	}
	
	echo file_get_contents("../swagger_users.json");
});

$app->get('/destruct/json/{file_json}', function (Request $request, Response $response, array $args) {
	
	$json_path = "../";
	$json_file = $args["file_json"].".json";
	
	if(file_exists($json_path.$json_file)) {
		unlink($json_path.$json_file);
		return $response->withJson(["File $json_file removed"]);
	}
	
	return $response->withJson(["File $json_file doesn't exist"]);
});