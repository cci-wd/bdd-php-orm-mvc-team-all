<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191126031331 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE businesses CHANGE id_users id_users INT DEFAULT NULL');
        $this->addSql('ALTER TABLE educations CHANGE id_students id_students INT DEFAULT NULL');
        $this->addSql('ALTER TABLE experiences CHANGE id_students id_students INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offers CHANGE id_sections id_sections INT DEFAULT NULL, CHANGE id_businesses id_businesses INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skills CHANGE id_students id_students INT DEFAULT NULL');
        $this->addSql('ALTER TABLE students CHANGE id_sections id_sections INT DEFAULT NULL, CHANGE id_users id_users INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE businesses CHANGE id_users id_users INT NOT NULL');
        $this->addSql('ALTER TABLE educations CHANGE id_students id_students INT NOT NULL');
        $this->addSql('ALTER TABLE experiences CHANGE id_students id_students INT NOT NULL');
        $this->addSql('ALTER TABLE offers CHANGE id_businesses id_businesses INT NOT NULL, CHANGE id_sections id_sections INT NOT NULL');
        $this->addSql('ALTER TABLE skills CHANGE id_students id_students INT NOT NULL');
        $this->addSql('ALTER TABLE students CHANGE id_sections id_sections INT NOT NULL, CHANGE id_users id_users INT NOT NULL');
    }
}
