<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220504102824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car ADD user_car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DA694EDA2 FOREIGN KEY (user_car_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_773DE69DA694EDA2 ON car (user_car_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DA694EDA2');
        $this->addSql('DROP INDEX IDX_773DE69DA694EDA2 ON car');
        $this->addSql('ALTER TABLE car DROP user_car_id');
    }
}
