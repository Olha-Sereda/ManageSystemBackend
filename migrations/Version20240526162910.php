<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240526162910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test_result_log DROP CONSTRAINT fk_700a01f39d86650f');
        $this->addSql('DROP INDEX idx_700a01f39d86650f');
        $this->addSql('ALTER TABLE test_result_log DROP user_id_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE test_result_log ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE test_result_log ADD CONSTRAINT fk_700a01f39d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_700a01f39d86650f ON test_result_log (user_id_id)');
    }
}
