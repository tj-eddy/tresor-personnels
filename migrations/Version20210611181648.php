<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210611181648 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE document_recrutement (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, num_doc VARCHAR(255) NOT NULL, type_doc VARCHAR(255) NOT NULL, date_doc VARCHAR(255) DEFAULT NULL, corps VARCHAR(255) DEFAULT NULL, indice VARCHAR(255) DEFAULT NULL, categorie VARCHAR(255) DEFAULT NULL, grade VARCHAR(255) DEFAULT NULL, INDEX IDX_A7421473A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document_recrutement ADD CONSTRAINT FK_A7421473A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE date_start_service date_start_service DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE document_recrutement');
        $this->addSql('ALTER TABLE user CHANGE date_start_service date_start_service DATETIME DEFAULT NULL');
    }
}
