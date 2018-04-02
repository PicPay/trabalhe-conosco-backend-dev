<?php
namespace App\Service;
use Doctrine\DBAL\Connection;

/**
 * Class ImportUsersFromCsv
 * @package App\Service
 */
class ImportUsersFromCsv
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var UpdateUsersPriority
     */
    protected $updatePriority;

    /**
     * ImportUsersFromCsv constructor.
     * @param Connection $connection
     * @param UpdateUsersPriority $updatePriority
     */
    public function __construct(Connection $connection, UpdateUsersPriority $updatePriority)
    {
        $this->connection = $connection;
        $this->updatePriority = $updatePriority;
    }

    public function import(string $csvFile)
    {
        $secureFile = '/var/lib/mysql-files/' . pathinfo($csvFile, PATHINFO_BASENAME);

        $this->connection->exec('TRUNCATE TABLE user');

        $sql = <<<SQL
LOAD DATA INFILE "{$secureFile}"
INTO TABLE user
COLUMNS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '\r'
ESCAPED BY ''
LINES TERMINATED BY '\n'
(id, name, username)
SQL;

        $this->connection->exec($sql);

        $this->updatePriority->update();
    }

}