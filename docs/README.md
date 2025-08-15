# Mon Projet Individuel - Gestion des étudiants
Auteur : Tom BUCLIN

## Description
Ce projet consiste à créer individuellement une application qui permet de gérer un suivi d'étudiants (ajouter un étudiant, modifier un étudiant, supprimer un étudiant, afficher les détails d'un étudiant).

L'accès à l'application est protégée par une authentification (login et mot de passe haché). 

## Fonctionnalités
Les fonctionnalités de mon site web sont les suivantes : 
- Connexion / Déconnexion 
- Ajout, modification et suppression d'étudiants
- Gestion des matières et des notes

## Technologies utilisées
Les logiciels de mon site web sont les suivants : 
- HTML / CSS
- PHP
- SQL
- MySQL
- GitHub

## Structure du projet
/docs
    MCD_BuclinTom.png
    MPD_BuclinTom.sql
/src
    /config
        databaseconnect.php
        mysql.php
    /css
        style.css
    /img
        etudiants-classe.png
    /includes
        footer.php
        session.php
    ajouter_etudiant.php
    details_etudiant.php
    etudiants.php
    index.php
    login.php
    logout.php
    modifier_etudiant.php
    supprimer_etudiant.php

## Utilisation
1. Cloner le dépôt 
2. Importer le fichier SQL : MPD_BuclinTom.sql dans la base de données MySQL
3. Lancer le serveur local (XAMPP pour ma part)
4. Accéder au site via : http://localhost/src/login.php
5. Entrer les identifiants de connexion pour accéder au site web

## Identifiants de connexion
- Login : admin
- Mot de passe : 123

