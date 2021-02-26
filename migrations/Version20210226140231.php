<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210226140231 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, expiration_date DATE NOT NULL, bought_on DATE NOT NULL, INDEX IDX_A3C664D39395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, price DOUBLE PRECISION NOT NULL, bought_on DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D39395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE registration ADD subscription_id INT DEFAULT NULL, ADD ticket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A79A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id)');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62A8A7A79A1887DC ON registration (subscription_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62A8A7A7700047D2 ON registration (ticket_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D39395C3F3');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A79A1887DC');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A7700047D2');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP INDEX UNIQ_62A8A7A79A1887DC ON registration');
        $this->addSql('DROP INDEX UNIQ_62A8A7A7700047D2 ON registration');
        $this->addSql('ALTER TABLE registration DROP subscription_id, DROP ticket_id');
    }
}
