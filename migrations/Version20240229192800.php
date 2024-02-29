<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229192800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE configuration (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, value LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_message (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, name VARCHAR(255) DEFAULT NULL, surname VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, compagny_name VARCHAR(100) NOT NULL, post_name VARCHAR(100) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, compangy_logo_url LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience_project (experience_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_6A983B7C46E90E27 (experience_id), INDEX IDX_6A983B7C166D1F9C (project_id), PRIMARY KEY(experience_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, priority SMALLINT NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, skill_groups_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, badge_url LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_5E3DE4775CC60692 (skill_groups_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_formation (skill_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_13B11AE25585C142 (skill_id), INDEX IDX_13B11AE25200282E (formation_id), PRIMARY KEY(skill_id, formation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_experience (skill_id INT NOT NULL, experience_id INT NOT NULL, INDEX IDX_10191D715585C142 (skill_id), INDEX IDX_10191D7146E90E27 (experience_id), PRIMARY KEY(skill_id, experience_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_project (skill_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_35464EC75585C142 (skill_id), INDEX IDX_35464EC7166D1F9C (project_id), PRIMARY KEY(skill_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_group (id INT AUTO_INCREMENT NOT NULL, custom_name VARCHAR(100) DEFAULT NULL, acquired_percentage SMALLINT NOT NULL, priority SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE experience_project ADD CONSTRAINT FK_6A983B7C46E90E27 FOREIGN KEY (experience_id) REFERENCES experience (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE experience_project ADD CONSTRAINT FK_6A983B7C166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE4775CC60692 FOREIGN KEY (skill_groups_id) REFERENCES skill_group (id)');
        $this->addSql('ALTER TABLE skill_formation ADD CONSTRAINT FK_13B11AE25585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_formation ADD CONSTRAINT FK_13B11AE25200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_experience ADD CONSTRAINT FK_10191D715585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_experience ADD CONSTRAINT FK_10191D7146E90E27 FOREIGN KEY (experience_id) REFERENCES experience (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_project ADD CONSTRAINT FK_35464EC75585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_project ADD CONSTRAINT FK_35464EC7166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experience_project DROP FOREIGN KEY FK_6A983B7C46E90E27');
        $this->addSql('ALTER TABLE experience_project DROP FOREIGN KEY FK_6A983B7C166D1F9C');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE4775CC60692');
        $this->addSql('ALTER TABLE skill_formation DROP FOREIGN KEY FK_13B11AE25585C142');
        $this->addSql('ALTER TABLE skill_formation DROP FOREIGN KEY FK_13B11AE25200282E');
        $this->addSql('ALTER TABLE skill_experience DROP FOREIGN KEY FK_10191D715585C142');
        $this->addSql('ALTER TABLE skill_experience DROP FOREIGN KEY FK_10191D7146E90E27');
        $this->addSql('ALTER TABLE skill_project DROP FOREIGN KEY FK_35464EC75585C142');
        $this->addSql('ALTER TABLE skill_project DROP FOREIGN KEY FK_35464EC7166D1F9C');
        $this->addSql('DROP TABLE configuration');
        $this->addSql('DROP TABLE contact_message');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE experience_project');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skill_formation');
        $this->addSql('DROP TABLE skill_experience');
        $this->addSql('DROP TABLE skill_project');
        $this->addSql('DROP TABLE skill_group');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
