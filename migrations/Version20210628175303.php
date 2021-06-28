<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210628175303 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ordre_route (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, num_or VARCHAR(30) DEFAULT NULL, date_or DATETIME DEFAULT NULL, objet_mission VARCHAR(255) DEFAULT NULL, date_debut_mission VARCHAR(255) DEFAULT NULL, date_fin_mission VARCHAR(255) DEFAULT NULL, scan_or VARCHAR(255) DEFAULT NULL, status TINYINT(1) NOT NULL, duree_mission VARCHAR(20) DEFAULT NULL, decompte_or DOUBLE PRECISION DEFAULT NULL, INDEX IDX_555DCEF6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ordre_route ADD CONSTRAINT FK_555DCEF6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ordre_route');
    }
}
