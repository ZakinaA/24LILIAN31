<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241130160943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE responsable_user (responsable_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_7749679753C59D72 (responsable_id), INDEX IDX_77496797A76ED395 (user_id), PRIMARY KEY(responsable_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE responsable_user ADD CONSTRAINT FK_7749679753C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE responsable_user ADD CONSTRAINT FK_77496797A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE responsable_user DROP FOREIGN KEY FK_7749679753C59D72');
        $this->addSql('ALTER TABLE responsable_user DROP FOREIGN KEY FK_77496797A76ED395');
        $this->addSql('DROP TABLE responsable_user');
    }
}
