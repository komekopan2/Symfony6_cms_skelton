<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230810083855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inquiry_visit_reservation_inquiry (id INT AUTO_INCREMENT NOT NULL, name_sei VARCHAR(48) DEFAULT NULL, name_mei VARCHAR(48) DEFAULT NULL, phone VARCHAR(32) DEFAULT NULL, hope_date1 DATE DEFAULT NULL, hope_hour1 INT DEFAULT NULL, hope_minute1 INT DEFAULT NULL, hope_date2 DATE DEFAULT NULL, hope_hour2 INT DEFAULT NULL, hope_minute2 INT DEFAULT NULL, hope_date3 DATE DEFAULT NULL, hope_hour3 INT DEFAULT NULL, hope_minute3 INT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, email VARCHAR(255) NOT NULL, ip VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE inquiry_visit_reservation_inquiry');
    }
}
