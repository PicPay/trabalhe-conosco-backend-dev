<?php

namespace App\Http\Controllers;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;


class Users extends Controller
{
    public function getAll(Request $request){

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

        if($request->has("name")){
            $name = $request->input('name');
            $params['body'] = ['query' => [
                                    'query_string' => [
                                        'fields' => [
                                            'name',
                                            'username'
                                        ],
                                        'query' => "$name*"
                                    ]
                                ],
                            ];
        }

        $result = $client->search($params)['hits'];

        $return["data"] = Array('total' => $result["total"]);

        foreach($result["hits"] as $row){
            $return["content"][] = Array("id" => $row["_id"], "name" => $row['_source']['name'], "username" => $row['_source']['username']);
        }

        print_r(json_encode($return));
    }
}
