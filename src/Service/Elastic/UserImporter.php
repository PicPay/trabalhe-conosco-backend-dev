<?php

namespace App\Service\Elastic;

set_time_limit(0);

use Elasticsearch\Client;

/**
 * Class UserImporter
 *
 * @package App\Service\Elastic
 */
class UserImporter
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @var string
     */
    protected $usersFilePath;

    /**
     * @var array
     */
    protected $priorityFilesPath;

    /**
     * UserImporter constructor.
     *
     * @param Client $client
     * @param UserManager $userManager
     * @param string $usersFilePath
     * @param string $priority1FilePath
     * @param string $priority2FilePath
     */
    public function __construct(Client $client, UserManager $userManager, string $usersFilePath, string $priority1FilePath, string $priority2FilePath)
    {
        $this->client = $client;
        $this->userManager = $userManager;
        $this->usersFilePath = $usersFilePath;
        $this->priorityFilesPath[] = $priority1FilePath;
        $this->priorityFilesPath[] = $priority2FilePath;
    }

    /**
     * @throws \Exception
     */
    public function import(): void
    {
        $batchSize = 10000;

        $this->client->indices()->putSettings([
            'index' => \App\Entity\Elastic\PicPay::INDEX,
            'body' => [
                'settings' => [
                    'refresh_interval' => -1,
                    'number_of_replicas' => 0
                ]
            ]
        ]);

        $params = [];
        if (($handle = \fopen($this->usersFilePath, "r")) !== FALSE) {
            $i = 1;
            while (($data = \fgetcsv($handle, 1000, ",")) !== FALSE) {
                $user = $this->buildUser($data);
                $params['body'][] = [
                    'index' => [
                        '_index' => \App\Entity\Elastic\PicPay::INDEX,
                        '_type' => \App\Entity\Elastic\User::TYPE,
                        '_id' => $user['id'],
                    ]
                ];
                unset($user['id']);
                $params['body'][] = $user;

                if (($i % $batchSize) === 0) {
                    $this->client->bulk($params);
                    $params = [];
                }
                ++$i;
            }
            \fclose($handle);

            if (\count($params) > 0) {
                $this->client->bulk($params);
            }
            $this->client->indices()->flush(['index' => \App\Entity\Elastic\PicPay::INDEX]);
        }

        $priority = 0;
        foreach($this->priorityFilesPath as $priorityFilePath) {
            if (($handle = \fopen($priorityFilePath, "r")) !== FALSE) {
                while (($data = \fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $user = $this->userManager->get($data[0]);
                    if (\count($user) > 0) {
                        $user['priority'] = $priority;
                        $this->userManager->update($user);
                    }
                }
                \fclose($handle);
                ++$priority;
            }
        }

        $this->client->indices()->putSettings([
            'index' => \App\Entity\Elastic\PicPay::INDEX,
            'body' => [
                'settings' => [
                    'refresh_interval' => '1s',
                    'number_of_replicas' => 1
                ]
            ]
        ]);
    }

    /**
     * @param array $data
     * @param int $priority
     *
     * @return array
     */
    private function buildUser(array $data, int $priority = \App\Entity\Elastic\User::PRIORITY_DEFAULT): array
    {
        return [
            'id' => $data[0] ?? '',
            'name' => $data[1] ?? '',
            'username' => $data[2] ?? '',
            'priority' => $priority
        ];
    }
}