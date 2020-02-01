<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200201212050 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE work_projects_project_departments ALTER project_id TYPE UUID');
        $this->addSql('ALTER TABLE work_projects_project_departments ALTER project_id DROP DEFAULT');
        $this->addSql('ALTER TABLE work_projects_projects ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE work_projects_projects ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE work_projects_projects ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE work_projects_projects ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE work_projects_project_departments ALTER project_id TYPE UUID');
        $this->addSql('ALTER TABLE work_projects_project_departments ALTER project_id DROP DEFAULT');
    }
}
