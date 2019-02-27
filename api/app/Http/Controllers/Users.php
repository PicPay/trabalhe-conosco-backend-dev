<?php

namespace App\Http\Controllers;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;


class Users extends Controller
{
    public function getAll(Resquest $request){

        $host = ['esServer'];
        $client = ClientBuilder::create()->setHosts($host)->build();
        
        $from = 0;

        if($request->has("from")){
            $from = $request->input('from');
        }

        $params = [
            'index' => 'pic',
            'type' => 'pay',
            'size' => 15,
            'from' => $from
        ];

        print_r($client->search($params));
    }
}
