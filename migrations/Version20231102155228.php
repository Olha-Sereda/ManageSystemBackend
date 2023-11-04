<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231102155228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE server_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE service_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE test_result_log_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tests_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE server (id INT NOT NULL, server_name VARCHAR(100) DEFAULT NULL, fqdn VARCHAR(255) DEFAULT NULL, ip_address VARCHAR(15) DEFAULT NULL, login VARCHAR(100) DEFAULT NULL, password_key VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE service (id INT NOT NULL, server_id_id INT NOT NULL, service_name VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E19D9AD2DFC5FC5E ON service (server_id_id)');
        $this->addSql('CREATE TABLE test_result_log (id INT NOT NULL, user_id_id INT NOT NULL, service_id_id INT NOT NULL, test_id_id INT NOT NULL, datetime_execution TIME(0) WITHOUT TIME ZONE DEFAULT NULL, execution_answer TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_700A01F39D86650F ON test_result_log (user_id_id)');
        $this->addSql('CREATE INDEX IDX_700A01F3D63673B0 ON test_result_log (service_id_id)');
        $this->addSql('CREATE INDEX IDX_700A01F3749A385C ON test_result_log (test_id_id)');
        $this->addSql('CREATE TABLE tests (id INT NOT NULL, user_id_id INT NOT NULL, test_name VARCHAR(255) NOT NULL, test_code TEXT DEFAULT NULL, expected_answer TEXT DEFAULT NULL, datetime_update TIME(0) WITHOUT TIME ZONE DEFAULT NULL, enabled BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1260FC5E9D86650F ON tests (user_id_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, user_name VARCHAR(50) DEFAULT NULL, user_surname VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2DFC5FC5E FOREIGN KEY (server_id_id) REFERENCES server (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE test_result_log ADD CONSTRAINT FK_700A01F39D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE test_result_log ADD CONSTRAINT FK_700A01F3D63673B0 FOREIGN KEY (service_id_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE test_result_log ADD CONSTRAINT FK_700A01F3749A385C FOREIGN KEY (test_id_id) REFERENCES tests (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tests ADD CONSTRAINT FK_1260FC5E9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE server_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE service_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE test_result_log_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tests_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE service DROP CONSTRAINT FK_E19D9AD2DFC5FC5E');
        $this->addSql('ALTER TABLE test_result_log DROP CONSTRAINT FK_700A01F39D86650F');
        $this->addSql('ALTER TABLE test_result_log DROP CONSTRAINT FK_700A01F3D63673B0');
        $this->addSql('ALTER TABLE test_result_log DROP CONSTRAINT FK_700A01F3749A385C');
        $this->addSql('ALTER TABLE tests DROP CONSTRAINT FK_1260FC5E9D86650F');
        $this->addSql('DROP TABLE server');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE test_result_log');
        $this->addSql('DROP TABLE tests');
        $this->addSql('DROP TABLE "user"');
    }
}
