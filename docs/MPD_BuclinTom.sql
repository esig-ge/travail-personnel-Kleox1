CREATE TABLE IF NOT EXISTS etudiant (
    id_etudiant INT AUTO_INCREMENT NOT NULL,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    classe VARCHAR(55) NOT NULL, /* Réduction taille VARCHAR*/
    date_naissance DATE NOT NULL,
    statut BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id_etudiant)
);

CREATE TABLE IF NOT EXISTS utilisateur (
    id_utilisateur INT AUTO_INCREMENT NOT NULL,
    login VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_utilisateur)
    
);

CREATE TABLE IF NOT EXISTS matiere (
    id_matiere INT AUTO_INCREMENT NOT NULL,
    nom VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_matiere)
);

CREATE TABLE IF NOT EXISTS commentaire (
    id_commentaire INT AUTO_INCREMENT NOT NULL,
    contenu TEXT NOT NULL,
    date DATE NOT NULL,
    type_comportement VARCHAR(55) NOT NULL, /* Réduction taille VARCHAR*/
    id_etudiant INT NOT NULL,
    PRIMARY KEY (id_commentaire),
    FOREIGN KEY (id_etudiant) REFERENCES etudiant(id_etudiant)
);

/* Table d'association */
CREATE TABLE IF NOT EXISTS note (
    id_note INT AUTO_INCREMENT NOT NULL,
    periode DATE NOT NULL,
    niveau_satisfaction VARCHAR(255) NOT NULL,
    id_etudiant INT NOT NULL,
    id_matiere INT NOT NULL,
    PRIMARY KEY (id_note),
    FOREIGN KEY (id_etudiant) REFERENCES etudiant(id_etudiant),
    FOREIGN KEY (id_matiere) REFERENCES matiere(id_matiere)
);
