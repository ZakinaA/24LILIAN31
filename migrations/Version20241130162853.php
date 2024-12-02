<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241130162853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE responsable_user DROP FOREIGN KEY FK_77496797A76ED395');
        $this->addSql('ALTER TABLE responsable_user DROP FOREIGN KEY FK_7749679753C59D72');
        $this->addSql('DROP TABLE responsable_user');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D07C8D8BF3D');
        $this->addSql('DROP INDEX IDX_52520D07C8D8BF3D ON responsable');
        $this->addSql('ALTER TABLE responsable DROP mail, CHANGE quotient_familial_id compte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D07F2C56620 FOREIGN KEY (compte_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_52520D07F2C56620 ON responsable (compte_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE responsable_user (responsable_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_7749679753C59D72 (responsable_id), INDEX IDX_77496797A76ED395 (user_id), PRIMARY KEY(responsable_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE responsable_user ADD CONSTRAINT FK_77496797A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE responsable_user ADD CONSTRAINT FK_7749679753C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D07F2C56620');
        $this->addSql('DROP INDEX UNIQ_52520D07F2C56620 ON responsable');
        $this->addSql('ALTER TABLE responsable ADD mail VARCHAR(255) NOT NULL, CHANGE compte_id quotient_familial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D07C8D8BF3D FOREIGN KEY (quotient_familial_id) REFERENCES quotient_familial (id)');
        $this->addSql('CREATE INDEX IDX_52520D07C8D8BF3D ON responsable (quotient_familial_id)');
    }
}
