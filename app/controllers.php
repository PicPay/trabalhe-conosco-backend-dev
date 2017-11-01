<?php

$app->mount('/api', require __DIR__ . '/api.php');

$app->get('/', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

    $pesquisa = $request->query->get('q');
    $registros = [];
    $msg = "";

    try {

        if (!empty($pesquisa)) {
            $resultado = $app['guzzle']->get("http://172.20.1.54:8050/api/" . API_TOKEN . "/users/" . $pesquisa);
            $users = json_decode($resultado->getBody()->getContents(), true);
            $registros = $users['data'];
        }

    } catch (Exception $e) {
        $msg = $e->getMessage();
    }

    return $app['twig']->render('index.html.twig', [
        'users' => $registros, 'msg' => $msg
    ]);

})->bind('find');