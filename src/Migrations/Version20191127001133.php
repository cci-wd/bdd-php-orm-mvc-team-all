<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191127001133 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE businesses (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, slogan VARCHAR(255) DEFAULT NULL, min_description VARCHAR(100) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, location VARCHAR(255) NOT NULL, nb_employees INT DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, date_foundation DATE DEFAULT NULL, phone_number INT NOT NULL, email VARCHAR(255) NOT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, linkedin VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, INDEX fk_Businesses_Users1_idx (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE educations (id INT AUTO_INCREMENT NOT NULL, students_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, degree VARCHAR(255) NOT NULL, speciality VARCHAR(255) NOT NULL, school_name VARCHAR(255) NOT NULL, date_from DATE NOT NULL, date_to DATE NOT NULL, INDEX fk_Educations_Students1_idx (students_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experiences (id INT AUTO_INCREMENT NOT NULL, students_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, post VARCHAR(255) NOT NULL, date_from DATE NOT NULL, date_to DATE NOT NULL, description VARCHAR(400) NOT NULL, INDEX fk_Work_experiences_Students1_idx (students_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offers (id INT AUTO_INCREMENT NOT NULL, businesses_id INT DEFAULT NULL, sections_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, min_description VARCHAR(255) DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, location VARCHAR(255) NOT NULL, hours_week INT DEFAULT NULL, description VARCHAR(400) NOT NULL, statut TINYINT(1) NOT NULL, publish_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX fk_Offers_Businesses1_idx (businesses_id), INDEX fk_Offers_Sections1_idx (sections_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sections (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skills (id INT AUTO_INCREMENT NOT NULL, students_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, percentage INT NOT NULL, INDEX fk_Skills_Students1_idx (students_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students (id INT AUTO_INCREMENT NOT NULL, sections_id INT DEFAULT NULL, users_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, first_name VARCHAR(45) NOT NULL, last_name VARCHAR(45) NOT NULL, min_description VARCHAR(100) DEFAULT NULL, location VARCHAR(255) NOT NULL, website VARCHAR(100) DEFAULT NULL, age INT NOT NULL, phone_number INT NOT NULL, email VARCHAR(255) NOT NULL, cover_image VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, github VARCHAR(255) DEFAULT NULL, linkedin VARCHAR(255) DEFAULT NULL, INDEX fk_Students_Sections1_idx (sections_id), INDEX fk_Students_Users1_idx (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, username VARCHAR(45) NOT NULL, location VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(60) NOT NULL, roles JSON DEFAULT NULL, UNIQUE INDEX name_UNIQUE (name), UNIQUE INDEX username_UNIQUE (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE businesses ADD CONSTRAINT FK_2DCA55EC67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE educations ADD CONSTRAINT FK_730876AD1AD8D010 FOREIGN KEY (students_id) REFERENCES students (id)');
        $this->addSql('ALTER TABLE experiences ADD CONSTRAINT FK_82020E701AD8D010 FOREIGN KEY (students_id) REFERENCES students (id)');
        $this->addSql('ALTER TABLE offers ADD CONSTRAINT FK_DA4604277AC46E66 FOREIGN KEY (businesses_id) REFERENCES businesses (id)');
        $this->addSql('ALTER TABLE offers ADD CONSTRAINT FK_DA460427577906E4 FOREIGN KEY (sections_id) REFERENCES sections (id)');
        $this->addSql('ALTER TABLE skills ADD CONSTRAINT FK_D53116701AD8D010 FOREIGN KEY (students_id) REFERENCES students (id)');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB2577906E4 FOREIGN KEY (sections_id) REFERENCES sections (id)');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB267B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE offers DROP FOREIGN KEY FK_DA4604277AC46E66');
        $this->addSql('ALTER TABLE offers DROP FOREIGN KEY FK_DA460427577906E4');
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB2577906E4');
        $this->addSql('ALTER TABLE educations DROP FOREIGN KEY FK_730876AD1AD8D010');
        $this->addSql('ALTER TABLE experiences DROP FOREIGN KEY FK_82020E701AD8D010');
        $this->addSql('ALTER TABLE skills DROP FOREIGN KEY FK_D53116701AD8D010');
        $this->addSql('ALTER TABLE businesses DROP FOREIGN KEY FK_2DCA55EC67B3B43D');
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB267B3B43D');
        $this->addSql('DROP TABLE businesses');
        $this->addSql('DROP TABLE educations');
        $this->addSql('DROP TABLE experiences');
        $this->addSql('DROP TABLE offers');
        $this->addSql('DROP TABLE sections');
        $this->addSql('DROP TABLE skills');
        $this->addSql('DROP TABLE students');
        $this->addSql('DROP TABLE users');
    }
}
