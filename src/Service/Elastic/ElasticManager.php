<?php

namespace App\Service\Elastic;

use Elasticsearch\Client;
use \Elasticsearch\Common\Exceptions\Missing404Exception;

/**
 * Class ElasticManager
 *
 * @package App\Service\Elastic
 */
class ElasticManager
{
    const MAX_RESULT_WINDOW = 10000;

    /**
     * @var Client
     */
    protected $client;

    /**
     * ElasticManager constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $elasticIndex
     * @param string $elasticType
     * @param string $id
     *
     * @return array
     */
    public function get(string $elasticIndex, string $elasticType, string $id)
    {
        try {
            $params = [];
            $params['index'] = $elasticIndex;
            $params['type'] = $elasticType;
            $params['id'] = $id;
            $response = $this->client->get($params);

            return \array_merge(['id' => $id], $response['_source']);
        }
        catch(Missing404Exception $exception) {
            return [];
        }
    }

    /**
     * @param string $elasticIndex
     * @param string $elasticType
     * @param array $options
     *
     * @return array
     */
    public function query(string $elasticIndex, string $elasticType, array $options = [])
    {
        if ($elasticIndex == "") {
            throw new \InvalidArgumentException("The elasticsearch index can't be empty");
        }

        if ($elasticType == "") {
            throw new \InvalidArgumentException("The elasticsearch type can't be empty");
        }

        $result = [];

        $from = 0;
        $size = 10;

        $params = [];
        $params['index'] = $elasticIndex;
        $params['type'] = $elasticType;
        if (isset($options['criteria'])) {
            if (\is_array($options['criteria'])) {
                foreach ($options['criteria'] as $criterion) {
                    $params['body']['query']['bool']['must'][] = $criterion;
                }
            }
        }
        if (isset($options['sort'])) {
            if (\is_array($options['sort'])) {
                foreach ($options['sort'] as $criterion) {
                    $params['body']['sort'][] = $criterion;
                }
            }
        }

        $size = isset($options['size']) ? $options['size'] : $size;
        $from = isset($options['page']) ? ($options['page'] * $size) : $from;
        $firstItemIndex = $from;
        $lastItemIndex = $from + $size - 1;
        if($lastItemIndex <= self::MAX_RESULT_WINDOW) {
            $params['body']['size'] = $size;
            $params['body']['from'] = $from;
            $response = $this->client->search($params);
        } else {
            $params['scroll'] = '5s';
            $params['size'] = $size * ((int) (self::MAX_RESULT_WINDOW / $size));

            $response = $this->client->search($params);

            $qtItems = \count($response['hits']['hits']);
            while ($firstItemIndex > $qtItems && \count($response['hits']['hits']) > 0) {
                $response = $this->client->scroll([
                    "scroll_id" => $response['_scroll_id'],
                    "scroll" => '5s'
                ]);
                $qtItems += \count($response['hits']['hits']);
            }

            if(($firstItemIndex % $params['size']) <= \count($response['hits']['hits']) && \count($response['hits']['hits']) > 0) {
                $response['hits']['hits'] = \array_slice($response['hits']['hits'], $firstItemIndex % $params['size'], $size);
            } else {
                $response['hits']['hits'] = [];
            }
        }

        if (\count($response['hits']['hits']) > 0) {
            foreach ($response['hits']['hits'] as $hit) {
                $result[] = \array_merge(['id' => $hit['_id']], $hit['_source']);
            }
        }

        return $result;
    }

    /**
     * @param string $elasticIndex
     * @param string $elasticType
     * @param array $options
     *
     * @return mixed
     */
    public function count(string $elasticIndex, string $elasticType, array $options = [])
    {
        if ($elasticIndex == "") {
            throw new \InvalidArgumentException("The elasticsearch index can't be empty");
        }

        if ($elasticType == "") {
            throw new \InvalidArgumentException("The elasticsearch type can't be empty");
        }

        $params = [];
        $params['index'] = $elasticIndex;
        $params['type'] = $elasticType;
        if (isset($options['criteria'])) {
            if (\is_array($options['criteria'])) {
                foreach ($options['criteria'] as $criterion) {
                    $params['body']['query']['bool']['must'][] = $criterion;
                }
            }
        }
        $response = $this->client->count($params);

        return $response['count'];
    }

    /**
     * @param string $elasticIndex
     * @param string $elasticType
     * @param array $data
     *
     * @throws \Exception
     */
    public function update(string $elasticIndex, string $elasticType, array $data)
    {
        if ($elasticIndex == "") {
            throw new \InvalidArgumentException("The elasticsearch index can't be empty");
        }

        if ($elasticType == "") {
            throw new \InvalidArgumentException("The elasticsearch type can't be empty");
        }

        try {
            $params = [];
            $params['index'] = $elasticIndex;
            $params['type'] = $elasticType;
            $params['id'] = $data['id'];
            unset($data['id']);
            $params['body'] = [
                'doc' => $data
            ];
            $this->client->update($params);
            $this->client->indices()->flush(['index' => $elasticIndex]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
