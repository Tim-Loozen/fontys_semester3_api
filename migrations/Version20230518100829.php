<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230518100829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE route_request ADD post_office_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE route_request ADD CONSTRAINT FK_C3C4D2075ECEBCD3 FOREIGN KEY (post_office_id) REFERENCES post_office (id)');
        $this->addSql('CREATE INDEX IDX_C3C4D2075ECEBCD3 ON route_request (post_office_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE route_request DROP FOREIGN KEY FK_C3C4D2075ECEBCD3');
        $this->addSql('DROP INDEX IDX_C3C4D2075ECEBCD3 ON route_request');
        $this->addSql('ALTER TABLE route_request DROP post_office_id');
    }
}
