<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210219110805 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admission_bracelet (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registration (id INT AUTO_INCREMENT NOT NULL, bracelet_id INT NOT NULL, registered_by_id INT NOT NULL, check_in_timestamp DATETIME NOT NULL, check_out_timestamp DATETIME DEFAULT NULL, type INT NOT NULL, INDEX IDX_62A8A7A7EC886B8 (bracelet_id), INDEX IDX_62A8A7A727E92E18 (registered_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7EC886B8 FOREIGN KEY (bracelet_id) REFERENCES admission_bracelet (id)');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A727E92E18 FOREIGN KEY (registered_by_id) REFERENCES employee (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A7EC886B8');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A727E92E18');
        $this->addSql('DROP TABLE admission_bracelet');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE registration');
    }
}
