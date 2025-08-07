CREATE TABLE IF NOT EXISTS etudiant (
	id_etudiant int AUTO_INCREMENT NOT NULL UNIQUE,
	nom varchar(255) NOT NULL,
	prenom varchar(255) NOT NULL,
	classe varchar(255) NOT NULL,
	date_naissance date NOT NULL,
	statut BOOLEAN NOT NULL DEFAULT TRUE,
	PRIMARY KEY (id_etudiant)
);

CREATE TABLE IF NOT EXISTS note (
	id_note int AUTO_INCREMENT NOT NULL UNIQUE,
	periode date NOT NULL,
	niveau_satisfaction varchar(255) NOT NULL,
	id_etudiant int NOT NULL,
	id_matiere int NOT NULL,
	PRIMARY KEY (id_note),
	FOREIGN KEY (id_etudiant) REFERENCES etudiant(id_etudiant),
	FOREIGN KEY (id_matiere) REFERENCES matiere(id_matiere)
);

CREATE TABLE IF NOT EXISTS commentaire (
	id_commentaire int AUTO_INCREMENT NOT NULL UNIQUE,
	contenu TEXT NOT NULL,
	date DATE NOT NULL,
	type_comportement varchar(255) NOT NULL,
	id_etudiant int NOT NULL,
	PRIMARY KEY (id_commentaire),
	FOREIGN KEY (id_etudiant) REFERENCES etudiant(id_etudiant)
);

CREATE TABLE matiere (
	id_matiere int AUTO_INCREMENT NOT NULL UNIQUE,
	nom varchar(255) NOT NULL,
	PRIMARY KEY (id_matiere)
);



