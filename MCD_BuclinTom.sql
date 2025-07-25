CREATE TABLE IF NOT EXISTS `etudiant` (
	`id_etudiant` int AUTO_INCREMENT NOT NULL UNIQUE,
	`nom` varchar(255) NOT NULL,
	`prenom` varchar(255) NOT NULL,
	`classe` varchar(255) NOT NULL,
	`date_naissance` date NOT NULL,
	PRIMARY KEY (`id_etudiant`)
);

CREATE TABLE IF NOT EXISTS `note` (
	`id_note` int AUTO_INCREMENT NOT NULL UNIQUE,
	`periode` date NOT NULL,
	`niveau_satisfaction` varchar(255) NOT NULL,
	`id_etudiant` int NOT NULL,
	`id_matiere` int NOT NULL,
	PRIMARY KEY (`id_note`)
);

CREATE TABLE IF NOT EXISTS `commentaire` (
	`id_commentaire` int AUTO_INCREMENT NOT NULL UNIQUE,
	`contenu` TEXT NOT NULL,
	`date` date NOT NULL,
	`type_comportement` varchar(255) NOT NULL,
	`id_etudiant` int NOT NULL,
	PRIMARY KEY (`id_commentaire`)
);

CREATE TABLE IF NOT EXISTS `matiere` (
	`id_matiere` int AUTO_INCREMENT NOT NULL UNIQUE,
	`nom` varchar(255) NOT NULL,
	PRIMARY KEY (`id_matiere`)
);


ALTER TABLE `note` ADD CONSTRAINT `note_fk3` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiant`(`id_etudiant`);

ALTER TABLE `note` ADD CONSTRAINT `note_fk4` FOREIGN KEY (`id_matiere`) REFERENCES `matiere`(`id_matiere`);
ALTER TABLE `commentaire` ADD CONSTRAINT `commentaire_fk4` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiant`(`id_etudiant`);
