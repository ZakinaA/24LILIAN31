<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241113100153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cours_jour (cours_id INT NOT NULL, jour_id INT NOT NULL, INDEX IDX_961E62A7ECF78B0 (cours_id), INDEX IDX_961E62A220C6AD0 (jour_id), PRIMARY KEY(cours_id, jour_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instrument_modele (instrument_id INT NOT NULL, modele_id INT NOT NULL, INDEX IDX_24B48610CF11D9C (instrument_id), INDEX IDX_24B48610AC14B70A (modele_id), PRIMARY KEY(instrument_id, modele_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur_type_instrument (professeur_id INT NOT NULL, type_instrument_id INT NOT NULL, INDEX IDX_1E1989D6BAB22EE9 (professeur_id), INDEX IDX_1E1989D67C1CAAA9 (type_instrument_id), PRIMARY KEY(professeur_id, type_instrument_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_cours_tarif (type_cours_id INT NOT NULL, tarif_id INT NOT NULL, INDEX IDX_750ED78EB3305F4C (type_cours_id), INDEX IDX_750ED78E357C0A59 (tarif_id), PRIMARY KEY(type_cours_id, tarif_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cours_jour ADD CONSTRAINT FK_961E62A7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours_jour ADD CONSTRAINT FK_961E62A220C6AD0 FOREIGN KEY (jour_id) REFERENCES jour (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE instrument_modele ADD CONSTRAINT FK_24B48610CF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE instrument_modele ADD CONSTRAINT FK_24B48610AC14B70A FOREIGN KEY (modele_id) REFERENCES modele (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professeur_type_instrument ADD CONSTRAINT FK_1E1989D6BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professeur_type_instrument ADD CONSTRAINT FK_1E1989D67C1CAAA9 FOREIGN KEY (type_instrument_id) REFERENCES type_instrument (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_cours_tarif ADD CONSTRAINT FK_750ED78EB3305F4C FOREIGN KEY (type_cours_id) REFERENCES type_cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_cours_tarif ADD CONSTRAINT FK_750ED78E357C0A59 FOREIGN KEY (tarif_id) REFERENCES tarif (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE accessoire ADD instrument_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE accessoire ADD CONSTRAINT FK_8FD026ACF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id)');
        $this->addSql('CREATE INDEX IDX_8FD026ACF11D9C ON accessoire (instrument_id)');
        $this->addSql('ALTER TABLE cours ADD type_cours_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CB3305F4C FOREIGN KEY (type_cours_id) REFERENCES type_cours (id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CB3305F4C ON cours (type_cours_id)');
        $this->addSql('ALTER TABLE inscription ADD cours_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D67ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D67ECF78B0 ON inscription (cours_id)');
        $this->addSql('ALTER TABLE instrument ADD type_instrument_id INT DEFAULT NULL, ADD marque_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE instrument ADD CONSTRAINT FK_3CBF69DD7C1CAAA9 FOREIGN KEY (type_instrument_id) REFERENCES type_instrument (id)');
        $this->addSql('ALTER TABLE instrument ADD CONSTRAINT FK_3CBF69DD4827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('CREATE INDEX IDX_3CBF69DD7C1CAAA9 ON instrument (type_instrument_id)');
        $this->addSql('CREATE INDEX IDX_3CBF69DD4827B9B2 ON instrument (marque_id)');
        $this->addSql('ALTER TABLE paiement ADD inscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E5DAC5993 ON paiement (inscription_id)');
        $this->addSql('ALTER TABLE type_instrument ADD classe_instrument_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_instrument ADD CONSTRAINT FK_21BCBFF8CE879FB1 FOREIGN KEY (classe_instrument_id) REFERENCES classe_instrument (id)');
        $this->addSql('CREATE INDEX IDX_21BCBFF8CE879FB1 ON type_instrument (classe_instrument_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours_jour DROP FOREIGN KEY FK_961E62A7ECF78B0');
        $this->addSql('ALTER TABLE cours_jour DROP FOREIGN KEY FK_961E62A220C6AD0');
        $this->addSql('ALTER TABLE instrument_modele DROP FOREIGN KEY FK_24B48610CF11D9C');
        $this->addSql('ALTER TABLE instrument_modele DROP FOREIGN KEY FK_24B48610AC14B70A');
        $this->addSql('ALTER TABLE professeur_type_instrument DROP FOREIGN KEY FK_1E1989D6BAB22EE9');
        $this->addSql('ALTER TABLE professeur_type_instrument DROP FOREIGN KEY FK_1E1989D67C1CAAA9');
        $this->addSql('ALTER TABLE type_cours_tarif DROP FOREIGN KEY FK_750ED78EB3305F4C');
        $this->addSql('ALTER TABLE type_cours_tarif DROP FOREIGN KEY FK_750ED78E357C0A59');
        $this->addSql('DROP TABLE cours_jour');
        $this->addSql('DROP TABLE instrument_modele');
        $this->addSql('DROP TABLE professeur_type_instrument');
        $this->addSql('DROP TABLE type_cours_tarif');
        $this->addSql('ALTER TABLE accessoire DROP FOREIGN KEY FK_8FD026ACF11D9C');
        $this->addSql('DROP INDEX IDX_8FD026ACF11D9C ON accessoire');
        $this->addSql('ALTER TABLE accessoire DROP instrument_id');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CB3305F4C');
        $this->addSql('DROP INDEX IDX_FDCA8C9CB3305F4C ON cours');
        $this->addSql('ALTER TABLE cours DROP type_cours_id');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D67ECF78B0');
        $this->addSql('DROP INDEX IDX_5E90F6D67ECF78B0 ON inscription');
        $this->addSql('ALTER TABLE inscription DROP cours_id');
        $this->addSql('ALTER TABLE instrument DROP FOREIGN KEY FK_3CBF69DD7C1CAAA9');
        $this->addSql('ALTER TABLE instrument DROP FOREIGN KEY FK_3CBF69DD4827B9B2');
        $this->addSql('DROP INDEX IDX_3CBF69DD7C1CAAA9 ON instrument');
        $this->addSql('DROP INDEX IDX_3CBF69DD4827B9B2 ON instrument');
        $this->addSql('ALTER TABLE instrument DROP type_instrument_id, DROP marque_id');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E5DAC5993');
        $this->addSql('DROP INDEX IDX_B1DC7A1E5DAC5993 ON paiement');
        $this->addSql('ALTER TABLE paiement DROP inscription_id');
        $this->addSql('ALTER TABLE type_instrument DROP FOREIGN KEY FK_21BCBFF8CE879FB1');
        $this->addSql('DROP INDEX IDX_21BCBFF8CE879FB1 ON type_instrument');
        $this->addSql('ALTER TABLE type_instrument DROP classe_instrument_id');
    }
}
