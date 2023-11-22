<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231018074425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participante ADD leader_id INT NOT NULL');
        $this->addSql('ALTER TABLE participante ADD CONSTRAINT FK_85BDC5C373154ED4 FOREIGN KEY (leader_id) REFERENCES leader (id)');
        $this->addSql('CREATE INDEX IDX_85BDC5C373154ED4 ON participante (leader_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participante DROP FOREIGN KEY FK_85BDC5C373154ED4');
        $this->addSql('DROP INDEX IDX_85BDC5C373154ED4 ON participante');
        $this->addSql('ALTER TABLE participante DROP leader_id');
    }
}
