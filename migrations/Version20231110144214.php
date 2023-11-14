<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231110144214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_tests (service_id INT NOT NULL, tests_id INT NOT NULL, PRIMARY KEY(service_id, tests_id))');
        $this->addSql('CREATE INDEX IDX_BB1211B9ED5CA9E6 ON service_tests (service_id)');
        $this->addSql('CREATE INDEX IDX_BB1211B9F5D80971 ON service_tests (tests_id)');
        $this->addSql('ALTER TABLE service_tests ADD CONSTRAINT FK_BB1211B9ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_tests ADD CONSTRAINT FK_BB1211B9F5D80971 FOREIGN KEY (tests_id) REFERENCES tests (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE service_tests DROP CONSTRAINT FK_BB1211B9ED5CA9E6');
        $this->addSql('ALTER TABLE service_tests DROP CONSTRAINT FK_BB1211B9F5D80971');
        $this->addSql('DROP TABLE service_tests');
    }
}
