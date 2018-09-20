<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use Elasticsearch\ClientBuilder;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
      $hosts = [
        'elasticsearch'
      ];

      $clientBuilder = ClientBuilder::create();
      $clientBuilder->setHosts($hosts);
      $client = $clientBuilder->build();

      $params = [
        'index' => 'users',
        'type' => 'user',
        'body' => [
          'query' => [
            'match_all' => (object)[]
          ]
        ]
      ];
    
      $results = $client->search($params);

      return response()->json($results);
    }

    public function show($id)
    {
      $hosts = [
        'elasticsearch'
      ];

      $clientBuilder = ClientBuilder::create();
      $clientBuilder->setHosts($hosts);
      $client = $clientBuilder->build();

      $params = [
        'index' => 'users',
        'type' => 'user',
        'id' => $id
      ];
    
      $response = $client->get($params);

      return response()->json($response);
    }

    public function search($query) {
      $hosts = [
        'elasticsearch'
      ];

      $clientBuilder = ClientBuilder::create();
      $clientBuilder->setHosts($hosts);
      $client = $clientBuilder->build();

      $params = [
        'index' => 'users',
        'type' => 'user',
        'body' => [
          'query' => [
            'match' => [
              'username' => $query
            ]
          ]
        ]
      ];
    
      $results = $client->search($params);

      return response()->json($results);
    }

    //
}
