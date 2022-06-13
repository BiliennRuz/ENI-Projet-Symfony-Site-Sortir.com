<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613134811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lieux CHANGE villes_no_ville villes_no_ville INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participants CHANGE sites_no_site sites_no_site INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sorties CHANGE organisateur organisateur INT DEFAULT NULL, CHANGE lieux_no_lieu lieux_no_lieu INT DEFAULT NULL, CHANGE etats_no_etat etats_no_etat INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscriptions DROP date_inscription');
        $this->addSql('ALTER TABLE inscriptions RENAME INDEX inscriptions_participants_fk TO IDX_74E0281CEF759E07');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE inscriptions ADD date_inscription DATETIME NOT NULL');
        $this->addSql('ALTER TABLE inscriptions RENAME INDEX idx_74e0281cef759e07 TO inscriptions_participants_fk');
        $this->addSql('ALTER TABLE lieux CHANGE villes_no_ville villes_no_ville INT NOT NULL');
        $this->addSql('ALTER TABLE participants CHANGE sites_no_site sites_no_site INT NOT NULL');
        $this->addSql('ALTER TABLE sorties CHANGE etats_no_etat etats_no_etat INT NOT NULL, CHANGE organisateur organisateur INT NOT NULL, CHANGE lieux_no_lieu lieux_no_lieu INT NOT NULL');
    }
}
