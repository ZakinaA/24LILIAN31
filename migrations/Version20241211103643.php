<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211103643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_cours_tarif DROP FOREIGN KEY FK_750ED78E357C0A59');
        $this->addSql('ALTER TABLE type_cours_tarif DROP FOREIGN KEY FK_750ED78EB3305F4C');
        $this->addSql('DROP TABLE type_cours_tarif');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E5DAC5993');
        $this->addSql('DROP INDEX IDX_B1DC7A1E5DAC5993 ON paiement');
        $this->addSql('ALTER TABLE paiement CHANGE inscription_id responsable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E53C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E53C59D72 ON paiement (responsable_id)');
        $this->addSql('ALTER TABLE professionnel DROP chemin_image');
        $this->addSql('ALTER TABLE quotient_familial ADD quotient_max VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE responsable ADD quotient_familial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D07C8D8BF3D FOREIGN KEY (quotient_familial_id) REFERENCES quotient_familial (id)');
        $this->addSql('CREATE INDEX IDX_52520D07C8D8BF3D ON responsable (quotient_familial_id)');
        $this->addSql('ALTER TABLE tarif ADD type_cours_id INT DEFAULT NULL, ADD quotient_familial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tarif ADD CONSTRAINT FK_E7189C9B3305F4C FOREIGN KEY (type_cours_id) REFERENCES type_cours (id)');
        $this->addSql('ALTER TABLE tarif ADD CONSTRAINT FK_E7189C9C8D8BF3D FOREIGN KEY (quotient_familial_id) REFERENCES quotient_familial (id)');
        $this->addSql('CREATE INDEX IDX_E7189C9B3305F4C ON tarif (type_cours_id)');
        $this->addSql('CREATE INDEX IDX_E7189C9C8D8BF3D ON tarif (quotient_familial_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_cours_tarif (type_cours_id INT NOT NULL, tarif_id INT NOT NULL, INDEX IDX_750ED78E357C0A59 (tarif_id), INDEX IDX_750ED78EB3305F4C (type_cours_id), PRIMARY KEY(type_cours_id, tarif_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE type_cours_tarif ADD CONSTRAINT FK_750ED78E357C0A59 FOREIGN KEY (tarif_id) REFERENCES tarif (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_cours_tarif ADD CONSTRAINT FK_750ED78EB3305F4C FOREIGN KEY (type_cours_id) REFERENCES type_cours (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E53C59D72');
        $this->addSql('DROP INDEX IDX_B1DC7A1E53C59D72 ON paiement');
        $this->addSql('ALTER TABLE paiement CHANGE responsable_id inscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E5DAC5993 ON paiement (inscription_id)');
        $this->addSql('ALTER TABLE professionnel ADD chemin_image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE quotient_familial DROP quotient_max');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D07C8D8BF3D');
        $this->addSql('DROP INDEX IDX_52520D07C8D8BF3D ON responsable');
        $this->addSql('ALTER TABLE responsable DROP quotient_familial_id');
        $this->addSql('ALTER TABLE tarif DROP FOREIGN KEY FK_E7189C9B3305F4C');
        $this->addSql('ALTER TABLE tarif DROP FOREIGN KEY FK_E7189C9C8D8BF3D');
        $this->addSql('DROP INDEX IDX_E7189C9B3305F4C ON tarif');
        $this->addSql('DROP INDEX IDX_E7189C9C8D8BF3D ON tarif');
        $this->addSql('ALTER TABLE tarif DROP type_cours_id, DROP quotient_familial_id');
    }
}
