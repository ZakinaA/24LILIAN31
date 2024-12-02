<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241202092357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE metier (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metier_professionnel (metier_id INT NOT NULL, professionnel_id INT NOT NULL, INDEX IDX_FA14296CED16FA20 (metier_id), INDEX IDX_FA14296C8A49CC82 (professionnel_id), PRIMARY KEY(metier_id, professionnel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professionnel (id INT AUTO_INCREMENT NOT NULL, num_rue INT NOT NULL, rue VARCHAR(255) NOT NULL, copos VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quotient_familial (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, quotien_mini VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE metier_professionnel ADD CONSTRAINT FK_FA14296CED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE metier_professionnel ADD CONSTRAINT FK_FA14296C8A49CC82 FOREIGN KEY (professionnel_id) REFERENCES professionnel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eleve ADD responsable_id INT DEFAULT NULL, CHANGE num_rue num_rue INT NOT NULL');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F753C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
        $this->addSql('CREATE INDEX IDX_ECA105F753C59D72 ON eleve (responsable_id)');
        $this->addSql('ALTER TABLE pret ADD CONSTRAINT FK_52ECE979A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE responsable ADD compte_id INT DEFAULT NULL, DROP mail');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D07F2C56620 FOREIGN KEY (compte_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_52520D07F2C56620 ON responsable (compte_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D07F2C56620');
        $this->addSql('ALTER TABLE metier_professionnel DROP FOREIGN KEY FK_FA14296CED16FA20');
        $this->addSql('ALTER TABLE metier_professionnel DROP FOREIGN KEY FK_FA14296C8A49CC82');
        $this->addSql('DROP TABLE metier');
        $this->addSql('DROP TABLE metier_professionnel');
        $this->addSql('DROP TABLE professionnel');
        $this->addSql('DROP TABLE quotient_familial');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F753C59D72');
        $this->addSql('DROP INDEX IDX_ECA105F753C59D72 ON eleve');
        $this->addSql('ALTER TABLE eleve DROP responsable_id, CHANGE num_rue num_rue VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE pret DROP FOREIGN KEY FK_52ECE979A6CC7B2');
        $this->addSql('DROP INDEX UNIQ_52520D07F2C56620 ON responsable');
        $this->addSql('ALTER TABLE responsable ADD mail VARCHAR(255) NOT NULL, DROP compte_id');
    }
}
