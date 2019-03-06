<?php

namespace App\Service\Elastic;

use Elasticsearch\Client;

/**
 * Class PicPayManager
 *
 * @package App\Service\Elastic
 */
class PicPayManager
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * PicPayManager constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     *
     */
    public function reset()
    {
        $params = [];
        $params['index'] = \App\Entity\Elastic\PicPay::INDEX;
        if ($this->client->indices()->exists($params)) {
            $this->client->indices()->delete($params);
        }

        $params['body']['index'] = \App\Entity\Elastic\PicPay::getSettings();
        $this->client->indices()->create($params);
    }
}
