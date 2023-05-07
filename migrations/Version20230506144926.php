<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230506144926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE route_request (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, post_route_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_C3C4D207A76ED395 (user_id), INDEX IDX_C3C4D2078B013D47 (post_route_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE route_request ADD CONSTRAINT FK_C3C4D207A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE route_request ADD CONSTRAINT FK_C3C4D2078B013D47 FOREIGN KEY (post_route_id) REFERENCES post_route (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE route_request DROP FOREIGN KEY FK_C3C4D207A76ED395');
        $this->addSql('ALTER TABLE route_request DROP FOREIGN KEY FK_C3C4D2078B013D47');
        $this->addSql('DROP TABLE route_request');
    }
}
