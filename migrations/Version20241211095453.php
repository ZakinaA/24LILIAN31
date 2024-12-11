<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211095453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E5DAC5993');
        $this->addSql('DROP INDEX IDX_B1DC7A1E5DAC5993 ON paiement');
        $this->addSql('ALTER TABLE paiement CHANGE inscription_id responsable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E53C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E53C59D72 ON paiement (responsable_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E53C59D72');
        $this->addSql('DROP INDEX IDX_B1DC7A1E53C59D72 ON paiement');
        $this->addSql('ALTER TABLE paiement CHANGE responsable_id inscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E5DAC5993 ON paiement (inscription_id)');
    }
}
