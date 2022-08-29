<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220826140242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE newsletter_names (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_subscribers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_subscribers_newsletter_names (newsletter_subscribers_id INT NOT NULL, newsletter_names_id INT NOT NULL, INDEX IDX_53B91365AF0C356E (newsletter_subscribers_id), INDEX IDX_53B9136555B21B32 (newsletter_names_id), PRIMARY KEY(newsletter_subscribers_id, newsletter_names_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE newsletter_subscribers_newsletter_names ADD CONSTRAINT FK_53B91365AF0C356E FOREIGN KEY (newsletter_subscribers_id) REFERENCES newsletter_subscribers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE newsletter_subscribers_newsletter_names ADD CONSTRAINT FK_53B9136555B21B32 FOREIGN KEY (newsletter_names_id) REFERENCES newsletter_names (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE newsletter_subscribers_newsletter_names DROP FOREIGN KEY FK_53B91365AF0C356E');
        $this->addSql('ALTER TABLE newsletter_subscribers_newsletter_names DROP FOREIGN KEY FK_53B9136555B21B32');
        $this->addSql('DROP TABLE newsletter_names');
        $this->addSql('DROP TABLE newsletter_subscribers');
        $this->addSql('DROP TABLE newsletter_subscribers_newsletter_names');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
