-- Création de la base de données de test
DROP DATABASE IF EXISTS touche_pas_au_klaxon_test;
CREATE DATABASE touche_pas_au_klaxon_test;
USE touche_pas_au_klaxon_test;

-- Drop des tables si elles existent déjà (pour éviter les erreurs lors de la création)
DROP TABLE IF EXISTS trajet;
DROP TABLE IF EXISTS agence;
DROP TABLE IF EXISTS utilisateur;

-- Création des tables
CREATE TABLE UTILISATEUR (
    id_utilisateur INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    telephone VARCHAR(10) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    est_admin BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE AGENCE (
    id_agence INT PRIMARY KEY AUTO_INCREMENT,
    nom_ville VARCHAR(50) NOT NULL
);

CREATE TABLE TRAJET (
    id_trajet INT PRIMARY KEY AUTO_INCREMENT,
    date_depart DATETIME NOT NULL,
    date_arrivee DATETIME NOT NULL,
    nb_places_tot TINYINT NOT NULL,
    nb_places_dispo TINYINT NOT NULL,
    id_utilisateur INT NOT NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES UTILISATEUR(id_utilisateur) ON DELETE RESTRICT,
    id_agence_depart INT NOT NULL,
    FOREIGN KEY (id_agence_depart) REFERENCES AGENCE(id_agence) ON DELETE RESTRICT,
    id_agence_arrivee INT NOT NULL,
    FOREIGN KEY (id_agence_arrivee) REFERENCES AGENCE(id_agence) ON DELETE RESTRICT
);