<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327183325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }


    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact_detail (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, number INT NOT NULL, additive VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, phone_number INT NOT NULL, email VARCHAR(255) NOT NULL, coc INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery_address (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, number INT NOT NULL, additive VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE package_compenstaion (id INT AUTO_INCREMENT NOT NULL, base_compensation DOUBLE PRECISION NOT NULL, weight_compenstation DOUBLE PRECISION NOT NULL, size_compensation DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parcel (id INT AUTO_INCREMENT NOT NULL, width DOUBLE PRECISION NOT NULL, height DOUBLE PRECISION NOT NULL, depth DOUBLE PRECISION NOT NULL, weight DOUBLE PRECISION NOT NULL, insured TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_office_user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, phone_number INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD license_plate VARCHAR(255) NOT NULL, ADD hourly_rate DOUBLE PRECISION DEFAULT NULL, ADD work_area VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contact_detail');
        $this->addSql('DROP TABLE delivery_address');
        $this->addSql('DROP TABLE package_compenstaion');
        $this->addSql('DROP TABLE parcel');
        $this->addSql('DROP TABLE post_office_user');
        $this->addSql('ALTER TABLE user DROP license_plate, DROP hourly_rate, DROP work_area');
    }
}
