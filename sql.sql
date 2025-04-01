-- Script d'insertion de données pour la base de données Emusic

-- Insertion des données dans la table classe_instrument
INSERT INTO `classe_instrument` (`id`, `libelle`) VALUES
(1, 'Cordes'),
(2, 'Vents'),
(3, 'Percussions'),
(4, 'Claviers'),
(5, 'Électroniques');

-- Insertion des données dans la table type_instrument
INSERT INTO `type_instrument` (`id`, `classe_instrument_id`, `libelle`) VALUES
(1, 1, 'Guitare'),
(2, 1, 'Violon'),
(3, 1, 'Violoncelle'),
(4, 1, 'Contrebasse'),
(5, 2, 'Flûte'),
(6, 2, 'Clarinette'),
(7, 2, 'Saxophone'),
(8, 2, 'Trompette'),
(9, 3, 'Batterie'),
(10, 3, 'Percussions'),
(11, 4, 'Piano'),
(12, 4, 'Synthétiseur'),
(13, 5, 'Guitare électrique'),
(14, 5, 'Basse électrique');

-- Insertion des données dans la table marque
INSERT INTO `marque` (`id`, `libelle`) VALUES
(1, 'Yamaha'),
(2, 'Roland'),
(3, 'Fender'),
(4, 'Gibson'),
(5, 'Steinway'),
(6, 'Selmer'),
(7, 'Pearl'),
(8, 'Ibanez'),
(9, 'Korg'),
(10, 'Martin');

-- Insertion des données dans la table modele
INSERT INTO `modele` (`id`, `nom`) VALUES
(1, 'Stratocaster'),
(2, 'Telecaster'),
(3, 'Les Paul'),
(4, 'SG'),
(5, 'YFL-222'),
(6, 'YAS-280'),
(7, 'B-290'),
(8, 'S700'),
(9, 'Model D'),
(10, 'P-125'),
(11, 'Export Series'),
(12, 'RG550'),
(13, 'Kronos'),
(14, 'D-28');

-- Insertion des données dans la table instrument
INSERT INTO `instrument` (`id`, `type_instrument_id`, `marque_id`, `num_serie`, `date_achat`, `prix_achat`, `utilisation`, `chemin_image`, `couleur`) VALUES
(1, 1, 3, 'US21000123', '2021-06-15', 1200, 'Cours et prêt', 'stratocaster.jpg', 'Sunburst'),
(2, 1, 4, 'LP19980234', '2019-08-22', 2500, 'Concert', 'lespaul.jpg', 'Cherry Sunburst'),
(3, 11, 1, 'P125000345', '2022-01-10', 750, 'Cours', 'yamaha_p125.jpg', 'Noir'),
(4, 11, 5, 'SD20150456', '2020-03-18', 35000, 'Concert', 'steinway_d.jpg', 'Noir laqué'),
(5, 9, 7, 'EX20180567', '2021-11-05', 1500, 'Cours', 'pearl_export.jpg', 'Rouge'),
(6, 7, 6, 'SE20080678', '2020-07-12', 2200, 'Concert et cours', 'selmer_saxophone.jpg', 'Cuivre'),
(7, 5, 1, 'YFL20220789', '2022-03-15', 850, 'Cours et prêt', 'yamaha_flute.jpg', 'Argenté'),
(8, 13, 8, 'RG20190890', '2019-05-08', 900, 'Cours et prêt', 'ibanez_rg.jpg', 'Bleu métallisé'),
(9, 2, 1, 'YV20210901', '2021-09-22', 950, 'Cours', 'yamaha_violon.jpg', 'Bois naturel'),
(10, 12, 9, 'KR20180123', '2018-12-05', 3200, 'Concert', 'korg_kronos.jpg', 'Noir');

-- Insertion des données dans la table instrument_modele
INSERT INTO `instrument_modele` (`instrument_id`, `modele_id`) VALUES
(1, 1),
(2, 3),
(3, 10),
(4, 9),
(5, 11),
(6, 6),
(7, 5),
(8, 12),
(9, 7),
(10, 13);

-- Insertion des données dans la table accessoire
INSERT INTO `accessoire` (`id`, `instrument_id`, `libelle`, `chemin_image`) VALUES
(1, 1, 'Housse de guitare', 'housse_guitare.jpg'),
(2, 1, 'Jeu de cordes', 'cordes_guitare.jpg'),
(3, 3, 'Pédale de sustain', 'pedale_sustain.jpg'),
(4, 5, 'Cymbale crash', 'cymbale_crash.jpg'),
(5, 6, 'Anches saxophone', 'anches_saxo.jpg'),
(6, 7, 'Kit de nettoyage flûte', 'kit_nettoyage_flute.jpg'),
(7, 8, 'Ampli guitare', 'ampli_guitare.jpg');

-- Insertion des données dans la table jour
INSERT INTO `jour` (`id`, `libelle`) VALUES
(1, 'Lundi'),
(2, 'Mardi'),
(3, 'Mercredi'),
(4, 'Jeudi'),
(5, 'Vendredi'),
(6, 'Samedi'),
(7, 'Dimanche');

-- Insertion des données dans la table type_cours
INSERT INTO `type_cours` (`id`, `libelle`) VALUES
(1, 'Individuel'),
(2, 'Collectif'),
(3, 'Atelier'),
(4, 'Master class'),
(5, 'Éveil musical');

-- Insertion des données dans la table professeur
INSERT INTO `professeur` (`id`, `nom`, `prenom`, `num_rue`, `rue`, `copos`, `ville`, `tel`, `mail`, `chemin_image`) VALUES
(1, 'Dupont', 'Jean', 12, 'Rue de la Musique', 75001, 'Paris', 651254789, 'jean.dupont@emusic.fr', 'professeur1.jpg'),
(2, 'Martin', 'Sophie', 8, 'Avenue Mozart', 75016, 'Paris', 625478965, 'sophie.martin@emusic.fr', 'professeur2.jpg'),
(3, 'Bernard', 'Pierre', 25, 'Rue Beethoven', 75009, 'Paris', 698754123, 'pierre.bernard@emusic.fr', 'professeur3.jpg'),
(4, 'Leroy', 'Marie', 5, 'Place de l\'Opéra', 75002, 'Paris', 632145698, 'marie.leroy@emusic.fr', 'professeur4.jpg'),
(5, 'Dubois', 'Philippe', 18, 'Rue Chopin', 75007, 'Paris', 645982365, 'philippe.dubois@emusic.fr', 'professeur5.jpg'),
(6, 'Moreau', 'Céline', 42, 'Boulevard des Arts', 75008, 'Paris', 632541789, 'celine.moreau@emusic.fr', 'professeur6.jpg');

-- Insertion des données dans la table professeur_type_instrument
INSERT INTO `professeur_type_instrument` (`professeur_id`, `type_instrument_id`) VALUES
(1, 1),
(1, 13),
(2, 11),
(3, 6),
(3, 7),
(4, 2),
(4, 3),
(5, 9),
(6, 5);

-- Insertion des données dans la table cours
INSERT INTO `cours` (`id`, `jour_id`, `type_cours_id`, `professeur_id`, `type_instrument_id`, `libelle`, `age_mini`, `heure_debut`, `heure_fin`) VALUES
(1, 2, 1, 1, 1, 'Cours de guitare - niveau débutant', 7, '14:00:00', '15:00:00'),
(2, 2, 1, 1, 1, 'Cours de guitare - niveau intermédiaire', 10, '15:30:00', '16:30:00'),
(3, 3, 2, 1, 13, 'Atelier guitare électrique', 12, '17:00:00', '18:30:00'),
(4, 1, 1, 2, 11, 'Cours de piano - niveau débutant', 6, '10:00:00', '11:00:00'),
(5, 1, 1, 2, 11, 'Cours de piano - niveau avancé', 12, '11:30:00', '12:30:00'),
(6, 5, 2, 2, 11, 'Ensemble piano', 15, '18:00:00', '19:30:00'),
(7, 3, 1, 3, 7, 'Cours de saxophone', 10, '14:00:00', '15:00:00'),
(8, 4, 3, 3, 6, 'Ensemble clarinettes', 12, '16:00:00', '17:30:00'),
(9, 2, 1, 4, 2, 'Cours de violon - niveau débutant', 7, '16:00:00', '17:00:00'),
(10, 4, 1, 4, 3, 'Cours de violoncelle', 8, '14:30:00', '15:30:00'),
(11, 5, 2, 4, 2, 'Orchestre à cordes - junior', 10, '16:00:00', '17:30:00'),
(12, 6, 1, 5, 9, 'Cours de batterie', 10, '10:00:00', '11:00:00'),
(13, 6, 3, 5, 9, 'Atelier rythmique', 12, '14:00:00', '15:30:00'),
(14, 3, 1, 6, 5, 'Cours de flûte traversière', 8, '10:00:00', '11:00:00'),
(15, 5, 5, 6, 5, 'Éveil musical par la flûte', 4, '14:00:00', '15:00:00');

-- Insertion des données dans la table quotient_familial
INSERT INTO `quotient_familial` (`id`, `libelle`, `quotien_mini`, `quotient_max`) VALUES
(1, 'Tranche A', '0', '800'),
(2, 'Tranche B', '801', '1200'),
(3, 'Tranche C', '1201', '1600'),
(4, 'Tranche D', '1601', '2000'),
(5, 'Tranche E', '2001', '99999');

-- Insertion des données dans la table user
INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(1, 'admin@emusic.fr', '[\"ROLE_ADMIN\"]', '$2y$13$jLu4.0VBAxDjkXA6BL6YSeFu7/BIrSeilXlJodR94uSD4Ayeyigce'),
(2, 'dupont.marie@gmail.com', '[\"ROLE_ETUDIANT\"]', '$2y$13$v0t1XfXRvZzQjx7Bj2fT1evLuLVJH0NfE8RKXJhtGR.EB0RIqDU0W'),
(3, 'simon.robert@hotmail.com', '[\"ROLE_ETUDIANT\"]', '$2y$13$5D1VIajTQwEUZyN3QuGkf.ZK5dUKb/zJbXIFvFf3jA4xGw9UfJ94.'),
(4, 'leclerc.patricia@yahoo.fr', '[\"ROLE_ETUDIANT\"]', '$2y$13$YPY1y/U/X4WH0pN47C4KJ.UZRT04bq7UCOUgHzDRGkWzeLihS6I1q'),
(5, 'thomas.legrand@gmail.com', '[\"ROLE_ETUDIANT\"]', '$2y$13$k.KvhbrJl.zCEHALDk41m.Z4S1mKa5QY4dxQ5N3DP8mGOjTzJU.sa'),
(6, 'celine.petit@orange.fr', '[\"ROLE_ETUDIANT\"]', '$2y$13$L2RqwqJXD7.2VSsOVLOJi.dwF9x9MnzxBWQS3uBkMp2JC1Gzd9uXC'),
(7, 'gestionnaire@emusic.fr', '[\"ROLE_GESTIONNAIRE\"]', '$2y$13$CY3V1oSm2fvjwAn5Z.xAr.hC3rAsbzJwrLRMqAQCbHbKdJQKfHxT.');

-- Insertion des données dans la table responsable
INSERT INTO `responsable` (`id`, `compte_id`, `quotient_familial_id`, `nom`, `prenom`, `num_rue`, `rue`, `copos`, `ville`, `tel`, `chemin_image`) VALUES
(1, 2, 3, 'Dupont', 'Marie', 24, 'Rue des Lilas', 75020, 'Paris', 632145698, 'responsable1.jpg'),
(2, 3, 4, 'Robert', 'Simon', 8, 'Avenue Victor Hugo', 75016, 'Paris', 645789632, 'responsable2.jpg'),
(3, 4, 2, 'Leclerc', 'Patricia', 12, 'Rue du Commerce', 75015, 'Paris', 612457896, 'responsable3.jpg'),
(4, 5, 5, 'Legrand', 'Thomas', 45, 'Boulevard Saint-Michel', 75005, 'Paris', 698745632, 'responsable4.jpg'),
(5, 6, 1, 'Petit', 'Céline', 3, 'Rue de la Paix', 75002, 'Paris', 623145789, 'responsable5.jpg'),
(6, 7, 4, 'Gestion', 'Admin', 1, 'Rue de l\'Ecole', 75001, 'Paris', 656789012, 'admin.jpg');

-- Insertion des données dans la table eleve
INSERT INTO `eleve` (`id`, `responsable_id`, `nom`, `prenom`, `num_rue`, `rue`, `copos`, `ville`, `tel`, `mail`, `chemin_image`) VALUES
(1, 1, 'Dupont', 'Lucas', 24, 'Rue des Lilas', 75020, 'Paris', 632145698, 'lucas.dupont@gmail.com', 'eleve1.jpg'),
(2, 1, 'Dupont', 'Emma', 24, 'Rue des Lilas', 75020, 'Paris', 632145698, 'emma.dupont@gmail.com', 'eleve2.jpg'),
(3, 2, 'Robert', 'Nathan', 8, 'Avenue Victor Hugo', 75016, 'Paris', 645789632, 'nathan.robert@gmail.com', 'eleve3.jpg'),
(4, 3, 'Leclerc', 'Zoé', 12, 'Rue du Commerce', 75015, 'Paris', 612457896, 'zoe.leclerc@gmail.com', 'eleve4.jpg'),
(5, 4, 'Legrand', 'Hugo', 45, 'Boulevard Saint-Michel', 75005, 'Paris', 698745632, 'hugo.legrand@gmail.com', 'eleve5.jpg'),
(6, 4, 'Legrand', 'Chloé', 45, 'Boulevard Saint-Michel', 75005, 'Paris', 698745632, 'chloe.legrand@gmail.com', 'eleve6.jpg'),
(7, 5, 'Petit', 'Léa', 3, 'Rue de la Paix', 75002, 'Paris', 623145789, 'lea.petit@gmail.com', 'eleve7.jpg');

-- Insertion des données dans la table inscription
INSERT INTO `inscription` (`id`, `cours_id`, `eleve_id`, `date_inscription`) VALUES
(1, 1, 1, '2022-09-01'),
(2, 6, 2, '2022-09-02'),
(3, 3, 3, '2022-09-03'),
(4, 9, 4, '2022-09-05'),
(5, 12, 5, '2022-09-05'),
(6, 11, 6, '2022-09-04'),
(7, 14, 7, '2022-09-06');

-- Insertion des données dans la table pret
INSERT INTO `pret` (`id`, `instrument_id`, `eleve_id`, `date_debut`, `date_fin`, `etat_detaille_debut`, `etat_detaille_retour`) VALUES
(1, 1, 1, '2022-09-10', '2023-06-30', 'Bon état général, petites rayures sur la caisse', ''),
(2, 7, 7, '2022-09-12', '2023-06-30', 'Très bon état, comme neuf', ''),
(3, 9, 4, '2022-09-15', '2023-06-30', 'Bon état, quelques marques d\'usure', ''),
(4, 8, 3, '2022-10-01', '2023-01-31', 'Bon état, micro légèrement instable', 'Retourné en bon état, micro réparé');

-- Insertion des données dans la table intervention
INSERT INTO `intervention` (`id`, `instrument_id`, `date_debut`, `date_fin`, `descriptif`, `prix`, `quotite`) VALUES
(1, 2, '2022-02-15', '2022-02-20', 'Réglage manche et frettes', 150, 'Complet'),
(2, 4, '2022-04-10', '2022-05-15', 'Restauration table d\'harmonie', 1200, 'Complet'),
(3, 6, '2022-07-05', '2022-07-10', 'Remplacement tampons', 180, 'Complet'),
(4, 8, '2022-01-12', '2022-01-15', 'Réparation micro et potentiomètres', 90, 'Complet'),
(5, 5, '2022-08-01', '2022-08-05', 'Remplacement peau caisse claire', 60, 'Complet');

-- Insertion des données dans la table tarif
INSERT INTO `tarif` (`id`, `type_cours_id`, `quotient_familial_id`, `montant`) VALUES
(1, 1, 1, 300),
(2, 1, 2, 400),
(3, 1, 3, 500),
(4, 1, 4, 600),
(5, 1, 5, 700),
(6, 2, 1, 200),
(7, 2, 2, 250),
(8, 2, 3, 300),
(9, 2, 4, 350),
(10, 2, 5, 400),
(11, 3, 1, 150),
(12, 3, 2, 200),
(13, 3, 3, 250),
(14, 3, 4, 300),
(15, 3, 5, 350),
(16, 5, 1, 100),
(17, 5, 2, 125),
(18, 5, 3, 150),
(19, 5, 4, 175),
(20, 5, 5, 200);

-- Insertion des données dans la table paiement
INSERT INTO `paiement` (`id`, `responsable_id`, `montant`, `date_paiement`) VALUES
(1, 1, 500, '2022-09-15'),
(2, 1, 500, '2022-12-15'),
(3, 2, 400, '2022-09-10'),
(4, 2, 400, '2022-12-10'),
(5, 3, 250, '2022-09-20'),
(6, 3, 250, '2022-12-20'),
(7, 4, 700, '2022-09-05'),
(8, 4, 700, '2022-12-05'),
(9, 5, 150, '2022-09-12'),
(10, 5, 150, '2022-12-12');

-- Insertion des données dans la table metier
INSERT INTO `metier` (`id`, `libelle`) VALUES
(1, 'Luthier guitare'),
(2, 'Luthier violon'),
(3, 'Accordeur piano'),
(4, 'Réparateur instruments à vent'),
(5, 'Facteur d orgues'),
(6, 'Restaurateur d instruments anciens'),
(7, 'Technicien son'),
(8, 'Réparateur instruments électroniques');

-- Insertion des données dans la table professionnel
INSERT INTO `professionnel` (`id`, `num_rue`, `rue`, `copos`, `ville`, `tel`, `mail`, `nom`, `chemin_image`) VALUES
(1, 15, 'Rue des Luthiers', '75011', 'Paris', '0678451236', 'atelier.dubois@gmail.com', 'Atelier Dubois', 'pro1.jpg'),
(2, 8, 'Boulevard des Musiciens', '75009', 'Paris', '0645789632', 'violin.expert@gmail.com', 'Violin Expert', 'pro2.jpg'),
(3, 42, 'Rue de la Clef', '75005', 'Paris', '0625874136', 'accordeurs.paris@yahoo.fr', 'Accordeurs de Paris', 'pro3.jpg'),
(4, 12, 'Avenue des Instruments', '75012', 'Paris', '0689754123', 'vent.service@gmail.com', 'Vent Service', 'pro4.jpg'),
(5, 3, 'Rue Mozart', '75016', 'Paris', '0632145987', 'orgues.tradition@orange.fr', 'Orgues Tradition', 'pro5.jpg'),
(6, 25, 'Rue du Faubourg Saint-Antoine', '75011', 'Paris', '0645213698', 'techson@gmail.com', 'Tech Son', 'pro6.jpg');

-- Insertion des données dans la table metier_professionnel
INSERT INTO `metier_professionnel` (`metier_id`, `professionnel_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 2),
(6, 5),
(7, 6),
(8, 6);