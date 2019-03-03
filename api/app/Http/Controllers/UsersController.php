<?php

namespace App\Http\Controllers;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
//use App\Providers\UsersServiceProvider as UserService;
use App\User;

class UsersController extends Controller
{
    public function get(Request $request){

        $host = ['esServer'];
        $client = ClientBuilder::create()->setHosts($host)->build();
        
        //from é o offset da busca
        $from = 0;

        if($request->has("from")){
            $from = $request->input('from');
        }

        //o tamanho maximo de itens por request foi definida em size via hardcode
        $params = [
            'index' => 'pic',
            'type' => 'pay',
            'size' => 15,
            'from' => $from
        ];

        //se houver uma palavra chave na request ele iria aplica-la como filtro, caso n tenha simplesmente faz a request sem filtro
        //name é utilizado pra busca tanto em name quando em username
        if($request->has("name")){
            $name = $request->input('name');
            $_name = explode(" ", $name);
            $name = "";
            //adiciona * depois de cada palavra, isso melhorou muito a qualidade das buscas
            foreach($_name as $n){
                $name = $name.$n."*";
            }

            //como foi adicionado pesos ao registro, o ranqueamento eh possivel com um simples sort
            $params['body'] = ['query' => [
                                    'query_string' => [
                                        'fields' => [
                                            'name',
                                            'username'
                                        ],
                                        'query' => "$name"
                                    ]
                                ],
                                'sort' =>
                                    ['weight' => 'desc']
                            ];
        }else{
            $params['body'] = [
                'sort' =>
                    ['weight' => 'desc']
            ];
        }

        $result = $client->search($params)['hits'];

        $return["header"] = Array('total' => $result["total"]);

        foreach($result["hits"] as $row){
            $return["content"][] = Array("id" => $row["_id"], "name" => $row['_source']['name'], "username" => $row['_source']['username'], "weight" => $row['_source']["weight"]);
        }
        return (new Response(json_encode($return), 200))->header('Content-Type', "application/json");
    }
}
