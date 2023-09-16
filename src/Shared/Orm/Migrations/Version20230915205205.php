<?php

declare(strict_types=1);

namespace App\Shared\Orm\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230915205205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE connexion (id INT AUTO_INCREMENT NOT NULL, ligne_id INT NOT NULL, depart_id INT NOT NULL, arrive_id INT NOT NULL, INDEX IDX_ACF9FF645A438E76 (ligne_id), INDEX IDX_ACF9FF64AE02FE4B (depart_id), INDEX IDX_ACF9FF64F4028648 (arrive_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gare (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, longitude DOUBLE PRECISION NOT NULL, latitude DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, speed DOUBLE PRECISION NOT NULL, spacing DOUBLE PRECISION NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE connexion ADD CONSTRAINT FK_936BF99C5A438E76 FOREIGN KEY (ligne_id) REFERENCES ligne (id)');
        $this->addSql('ALTER TABLE connexion ADD CONSTRAINT FK_936BF99CAE02FE4B FOREIGN KEY (depart_id) REFERENCES gare (id)');
        $this->addSql('ALTER TABLE connexion ADD CONSTRAINT FK_936BF99CF4028648 FOREIGN KEY (arrive_id) REFERENCES gare (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE connexion DROP FOREIGN KEY FK_936BF99C5A438E76');
        $this->addSql('ALTER TABLE connexion DROP FOREIGN KEY FK_936BF99CAE02FE4B');
        $this->addSql('ALTER TABLE connexion DROP FOREIGN KEY FK_936BF99CF4028648');
        $this->addSql('DROP TABLE connexion');
        $this->addSql('DROP TABLE gare');
        $this->addSql('DROP TABLE ligne');
    }
}
