<?php

namespace App\Service\Elastic;

use Elasticsearch\Client;

/**
 * Class UserManager
 *
 * @package App\Service\Elastic
 */
class UserManager
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var ElasticManager
     */
    protected $elasticManager;

    /**
     * @var PicPayManager
     */
    protected $picPayManager;

    /**
     * UserManager constructor.
     *
     * @param Client $client
     * @param ElasticManager $elasticManager
     * @param PicPayManager $picPayManager
     */
    public function __construct(Client $client, ElasticManager $elasticManager, PicPayManager $picPayManager)
    {
        $this->client = $client;
        $this->elasticManager = $elasticManager;
        $this->picPayManager = $picPayManager;
    }

    /**
     *
     */
    public function reset()
    {
        $params = [];
        $params['index'] = \App\Entity\Elastic\PicPay::INDEX;

        $this->picPayManager->reset();

        $mappingType = \App\Entity\Elastic\User::TYPE;
        $params['type'] = $mappingType;
        if ($this->client->indices()->existsType($params)) {
            $this->client->indices()->deleteMapping($params);
        }
        $params['body'][$mappingType] = \App\Entity\Elastic\User::getProperties();
        $this->client->indices()->putMapping($params);
    }

    /**
     * @param string $id
     *
     * @return array
     */
    public function get(string $id)
    {
        return $this->elasticManager->get(\App\Entity\Elastic\PicPay::INDEX, \App\Entity\Elastic\User::TYPE, $id);
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function query(array $options = [])
    {
        return $this->elasticManager->query(\App\Entity\Elastic\PicPay::INDEX, \App\Entity\Elastic\User::TYPE, $options);
    }

    /**
     * @param array $options
     *
     * @return mixed
     */
    public function count(array $options = [])
    {
        return $this->elasticManager->count(\App\Entity\Elastic\PicPay::INDEX, \App\Entity\Elastic\User::TYPE, $options);
    }

    /**
     * @param array $options
     *
     * @throws \Exception
     */
    public function update(array $options = [])
    {
        $this->elasticManager->update(\App\Entity\Elastic\PicPay::INDEX, \App\Entity\Elastic\User::TYPE, $options);
    }
}
