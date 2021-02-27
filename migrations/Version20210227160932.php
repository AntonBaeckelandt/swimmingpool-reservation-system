<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210227160932 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admission_bracelet (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, gender VARCHAR(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registration (id INT AUTO_INCREMENT NOT NULL, bracelet_id INT NOT NULL, registered_by_id INT NOT NULL, ticket_id INT DEFAULT NULL, subscription_id INT DEFAULT NULL, check_in_timestamp DATETIME NOT NULL, check_out_timestamp DATETIME DEFAULT NULL, type INT NOT NULL, INDEX IDX_62A8A7A7EC886B8 (bracelet_id), INDEX IDX_62A8A7A727E92E18 (registered_by_id), UNIQUE INDEX UNIQ_62A8A7A7700047D2 (ticket_id), INDEX IDX_62A8A7A79A1887DC (subscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, expiration_date DATE NOT NULL, bought_on DATE NOT NULL, INDEX IDX_A3C664D39395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, price DOUBLE PRECISION NOT NULL, bought_on DATE NOT NULL, valid_on DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7EC886B8 FOREIGN KEY (bracelet_id) REFERENCES admission_bracelet (id)');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A727E92E18 FOREIGN KEY (registered_by_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A79A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D39395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A7EC886B8');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D39395C3F3');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A727E92E18');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A79A1887DC');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A7700047D2');
        $this->addSql('DROP TABLE admission_bracelet');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE registration');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE ticket');
    }
}
