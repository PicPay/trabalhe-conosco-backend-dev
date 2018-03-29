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
     * ImportUsersFromCsv constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function import(string $csvFile)
    {
        $secureFile = '/var/lib/mysql-files/' . pathinfo($csvFile, PATHINFO_BASENAME);

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
    }

}