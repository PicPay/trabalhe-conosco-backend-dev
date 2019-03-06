<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190215003733 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("
            CREATE TABLE picpay.user (
              pk int(11) NOT NULL AUTO_INCREMENT,
              id varchar(50) NOT NULL,
              name varchar(100) NOT NULL,
              username varchar(100) NOT NULL,
              priority int(11) NOT NULL DEFAULT '999999',
              PRIMARY KEY (pk),
              KEY id (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("
            DROP TABLE picpay.user;
        ");
    }
}
