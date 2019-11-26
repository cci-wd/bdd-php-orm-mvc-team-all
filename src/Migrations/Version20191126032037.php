<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191126032037 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE businesses (id_businesses INT AUTO_INCREMENT NOT NULL, id_users INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slogan VARCHAR(255) DEFAULT NULL, min_description VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, location VARCHAR(255) NOT NULL, nb_employees INT DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, date_foundation DATE DEFAULT NULL, phone_number INT NOT NULL, email VARCHAR(255) NOT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, linkedin VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, description VARCHAR(400) NOT NULL, INDEX fk_Businesses_Users1_idx (id_users), PRIMARY KEY(id_businesses)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE educations (id_educations INT AUTO_INCREMENT NOT NULL, id_students INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, degree VARCHAR(255) NOT NULL, speciality VARCHAR(255) NOT NULL, school_name VARCHAR(255) NOT NULL, date_from DATE NOT NULL, date_to DATE NOT NULL, description VARCHAR(400) NOT NULL, INDEX fk_Educations_Students1_idx (id_students), PRIMARY KEY(id_educations)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experiences (id_experiences INT AUTO_INCREMENT NOT NULL, id_students INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, post VARCHAR(255) NOT NULL, date_from DATE NOT NULL, date_to DATE NOT NULL, description VARCHAR(400) NOT NULL, INDEX fk_Work_experiences_Students1_idx (id_students), PRIMARY KEY(id_experiences)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offers (id_offers INT AUTO_INCREMENT NOT NULL, id_businesses INT DEFAULT NULL, id_sections INT DEFAULT NULL, title VARCHAR(255) NOT NULL, min_description VARCHAR(255) DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, location VARCHAR(255) NOT NULL, hours_week INT DEFAULT NULL, description VARCHAR(400) NOT NULL, statut TINYINT(1) NOT NULL, INDEX fk_Offers_Businesses1_idx (id_businesses), INDEX fk_Offers_Sections1_idx (id_sections), PRIMARY KEY(id_offers)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sections (id_sections INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id_sections)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skills (id_skills INT AUTO_INCREMENT NOT NULL, id_students INT DEFAULT NULL, name VARCHAR(255) NOT NULL, percentage INT NOT NULL, INDEX fk_Skills_Students1_idx (id_students), PRIMARY KEY(id_skills)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students (id_students INT AUTO_INCREMENT NOT NULL, id_sections INT DEFAULT NULL, id_users INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, min_description VARCHAR(255) DEFAULT NULL, location VARCHAR(255) NOT NULL, website VARCHAR(255) DEFAULT NULL, age INT NOT NULL, phone_number INT NOT NULL, email VARCHAR(255) NOT NULL, cover_image VARCHAR(255) DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, github VARCHAR(255) DEFAULT NULL, INDEX fk_Students_Sections1_idx (id_sections), INDEX fk_Students_Users1_idx (id_users), PRIMARY KEY(id_students)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id_users INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX name_UNIQUE (name), PRIMARY KEY(id_users)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE businesses ADD CONSTRAINT FK_2DCA55ECFA06E4D9 FOREIGN KEY (id_users) REFERENCES users (id_users)');
        $this->addSql('ALTER TABLE educations ADD CONSTRAINT FK_730876ADF4B26127 FOREIGN KEY (id_students) REFERENCES students (id_students)');
        $this->addSql('ALTER TABLE experiences ADD CONSTRAINT FK_82020E70F4B26127 FOREIGN KEY (id_students) REFERENCES students (id_students)');
        $this->addSql('ALTER TABLE offers ADD CONSTRAINT FK_DA4604278840D53B FOREIGN KEY (id_businesses) REFERENCES businesses (id_businesses)');
        $this->addSql('ALTER TABLE offers ADD CONSTRAINT FK_DA4604277B4DAF0D FOREIGN KEY (id_sections) REFERENCES sections (id_sections)');
        $this->addSql('ALTER TABLE skills ADD CONSTRAINT FK_D5311670F4B26127 FOREIGN KEY (id_students) REFERENCES students (id_students)');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB27B4DAF0D FOREIGN KEY (id_sections) REFERENCES sections (id_sections)');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB2FA06E4D9 FOREIGN KEY (id_users) REFERENCES users (id_users)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE offers DROP FOREIGN KEY FK_DA4604278840D53B');
        $this->addSql('ALTER TABLE offers DROP FOREIGN KEY FK_DA4604277B4DAF0D');
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB27B4DAF0D');
        $this->addSql('ALTER TABLE educations DROP FOREIGN KEY FK_730876ADF4B26127');
        $this->addSql('ALTER TABLE experiences DROP FOREIGN KEY FK_82020E70F4B26127');
        $this->addSql('ALTER TABLE skills DROP FOREIGN KEY FK_D5311670F4B26127');
        $this->addSql('ALTER TABLE businesses DROP FOREIGN KEY FK_2DCA55ECFA06E4D9');
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB2FA06E4D9');
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
