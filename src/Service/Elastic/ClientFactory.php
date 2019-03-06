<?php

namespace App\Service\Elastic;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

/**
 * Class ClientFactory
 *
 * @package App\Service\Elastic
 */
class ClientFactory
{
    /**
     * @param string $baseUri
     * @return Client
     */
    public function createClient(string $baseUri)
    {
        return ClientBuilder::create()->setHosts([$baseUri])->build();
    }
}