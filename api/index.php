<?php

// armazena o diretório ROOT do sistema
define('ROOT', __DIR__);

require 'App/Controller.php';

// Instancia o objeto controller pai
$request = new Controller();
// retorna informações conforme requisição e informações passadas
echo $request->run();