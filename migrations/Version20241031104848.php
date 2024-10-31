<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241031104848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_section_title (article_id INT NOT NULL, section_title_id INT NOT NULL, INDEX IDX_3BBAF0AA7294869C (article_id), INDEX IDX_3BBAF0AA9AF2DDE1 (section_title_id), PRIMARY KEY(article_id, section_title_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_section_title ADD CONSTRAINT FK_3BBAF0AA7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_section_title ADD CONSTRAINT FK_3BBAF0AA9AF2DDE1 FOREIGN KEY (section_title_id) REFERENCES section_title (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_section_title DROP FOREIGN KEY FK_3BBAF0AA7294869C');
        $this->addSql('ALTER TABLE article_section_title DROP FOREIGN KEY FK_3BBAF0AA9AF2DDE1');
        $this->addSql('DROP TABLE article_section_title');
    }
}
