<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211094210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE responsable ADD quotient_familial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D07C8D8BF3D FOREIGN KEY (quotient_familial_id) REFERENCES quotient_familial (id)');
        $this->addSql('CREATE INDEX IDX_52520D07C8D8BF3D ON responsable (quotient_familial_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D07C8D8BF3D');
        $this->addSql('DROP INDEX IDX_52520D07C8D8BF3D ON responsable');
        $this->addSql('ALTER TABLE responsable DROP quotient_familial_id');
    }
}
