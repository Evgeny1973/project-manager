<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200131220559 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE work_project_roles (id UUID NOT NULL, name VARCHAR(255) NOT NULL, permissions JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E5B65E6D5E237E06 ON work_project_roles (name)');
        $this->addSql('COMMENT ON COLUMN work_project_roles.id IS \'(DC2Type:work_projects_role_id)\'');
        $this->addSql('COMMENT ON COLUMN work_project_roles.permissions IS \'(DC2Type:work_projects_role_permissions)\'');
        $this->addSql('ALTER TABLE work_projects_project_departments ALTER project_id TYPE UUID');
        $this->addSql('ALTER TABLE work_projects_project_departments ALTER project_id DROP DEFAULT');
        $this->addSql('ALTER TABLE work_projects_projects ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE work_projects_projects ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE work_project_roles');
        $this->addSql('ALTER TABLE work_projects_projects ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE work_projects_projects ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE work_projects_project_departments ALTER project_id TYPE UUID');
        $this->addSql('ALTER TABLE work_projects_project_departments ALTER project_id DROP DEFAULT');
    }
}
