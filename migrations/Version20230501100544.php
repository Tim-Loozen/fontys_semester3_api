<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230501100544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }


    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD post_office_id INT DEFAULT NULL, ADD position VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495ECEBCD3 FOREIGN KEY (post_office_id) REFERENCES post_office (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6495ECEBCD3 ON user (post_office_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495ECEBCD3');
        $this->addSql('DROP INDEX IDX_8D93D6495ECEBCD3 ON user');
        $this->addSql('ALTER TABLE user DROP post_office_id, DROP position');
    }
}
