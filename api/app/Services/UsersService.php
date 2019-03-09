<?php
namespace App\Services;

use Elasticsearch\ClientBuilder;

class UsersService
{

    private $index = 'pic';
    private $type = 'pay';
    private $host = ['esServer'];
    //quantidade de itens por pagina
    private $sizeResult = 15;

    //From - OffSet da busca, utilizado na paginação
    public function get($keyword = null, $from = 0)
    {
        $client = ClientBuilder::create()->setHosts($this->host)->build();

        //parametos da busca, onde buscar...
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'size' => $this->sizeResult,
            'from' => $from
        ];

        //se houver keyword aplica-se um filtro na busca
        if ($keyword != null) {
            $_keyword = explode(" ", $keyword);
            $keyword = "";
            //adiciona * depois de cada palavra para melhorar o resutado da busca
            foreach ($_keyword as $n) {
                $keyword = $keyword . $n . "*";
            }

            //parametros do filtro, tipo um where
            $params['body'] = [
                'query' => [
                    'query_string' => [
                        'fields' => [
                            'name',
                            'username'
                        ],
                        'query' => "$keyword"
                    ]
                ],
                'sort' =>
                ['weight' => 'desc']
            ];
        } else {
            $params['body'] = [
                'sort' =>
                ['weight' => 'desc']
            ];
        }

        //recupera o corpo do resultado que ficam dentro de hits
        $result = $client->search($params)['hits'];

        //recupera o total de resultados
        $return["header"] = array('total' => $result["total"]);

        //dentro do outro hits estao os resultados em si
        foreach ($result["hits"] as $row) {
            $return["content"][] = array("id" => $row["_id"], "name" => $row['_source']['name'], "username" => $row['_source']['username'], "weight" => $row['_source']["weight"]);
        }
        return $return;
    }
}
