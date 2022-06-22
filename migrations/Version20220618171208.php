<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220618171208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AB281BE2E');
        $this->addSql('DROP INDEX IDX_5F9E962AB281BE2E ON comments');
        $this->addSql('ALTER TABLE comments CHANGE status status TINYINT(1) NOT NULL, CHANGE trick_id tricks_id INT NOT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A3B153154 FOREIGN KEY (tricks_id) REFERENCES tricks (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962A3B153154 ON comments (tricks_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A3B153154');
        $this->addSql('DROP INDEX IDX_5F9E962A3B153154 ON comments');
        $this->addSql('ALTER TABLE comments CHANGE status status TINYINT(1) DEFAULT 1 NOT NULL, CHANGE tricks_id trick_id INT NOT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AB281BE2E FOREIGN KEY (trick_id) REFERENCES tricks (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5F9E962AB281BE2E ON comments (trick_id)');
    }
}
