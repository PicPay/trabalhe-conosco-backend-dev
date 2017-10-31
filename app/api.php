<?php

$api = $app['controllers_factory'];

$api->get('{tokenId}/users/{q}', function ($tokenId, $q) use ($app) {

    if ($tokenId != API_TOKEN) {
        return $app->json([
            'classe' => 'Erro',
            'mensagem' => 'Voce nao tem permissao para acessar este recurso.',
        ], \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST);
    }

    $usuarios = fopen(__DIR__ . '/../res/users.csv', 'r');

    $resultado = [];
    $i = 0;

    while (!feof($usuarios)) {

        $i++;

        $linha = fgetcsv($usuarios);

        if (!is_array($linha)) {
            continue;
        }

        foreach ($linha as $item) {

            if ($i > 30) {
                //exit;
            }

            if (!stristr($item, $q)) {
                continue;
            }

            $resultado[$i] = $linha;
        }
    }

    fclose($usuarios);

    if (empty($resultado)) {
        return $app->json([
            'classe' => 'sucesso',
            'mensagem' => 'Nenhum Usuario Encontrado.',
            'data' => []
        ], \Symfony\Component\HttpFoundation\Response::HTTP_ACCEPTED);
    }

    return $app->json([
        'classe' => 'sucesso',
        'mensagem' => 'Nenhum Usuario Encontrado.',
        'data' => $resultado
    ], \Symfony\Component\HttpFoundation\Response::HTTP_ACCEPTED);

});

return $api;