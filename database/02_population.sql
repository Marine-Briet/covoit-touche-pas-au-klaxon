USE touche_pas_au_klaxon;

INSERT INTO UTILISATEUR (nom, prenom, telephone, email, mot_de_passe) VALUES
('Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Lefèvre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Leroy', 'Thomas', '0655443322', 'thomas.leroy@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Roux', 'Chloé', '0633221199', 'chloe.roux@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Petit', 'Maxime', '0766778899', 'maxime.petit@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Garnier', 'Laura', '0688776655', 'laura.garnier@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Dupuis', 'Antoine', '0744556677', 'antoine.dupuis@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Lefebvre', 'Emma', '0699887766', 'emma.lefebvre@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Fontaine', 'Louis', '0655667788', 'louis.fontaine@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Chevalier', 'Clara', '0788990011', 'clara.chevalier@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Robin', 'Nicolas', '0644332211', 'nicolas.robin@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Gauthier', 'Marine', '0677889922', 'marine.gauthier@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Fournier', 'Pierre', '0722334455', 'pierre.fournier@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Girard', 'Sarah', '0688665544', 'sarah.girard@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Lambert', 'Hugo', '0611223366', 'hugo.lambert@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Masson', 'Julie', '0733445566', 'julie.masson@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO'),
('Henry', 'Arthur', '0666554433', 'arthur.henry@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO');

INSERT INTO UTILISATEUR (nom, prenom, telephone, email, mot_de_passe, est_admin) VALUES
('Admin', 'Admin', '0600000000', 'admin@email.fr', '$2y$10$8NFt2bmPKrA050z.cLPFruUlsZUO87bPTqVCMJaMaVlnF1lQ14SmO', TRUE);

SELECT id_utilisateur, nom, prenom FROM UTILISATEUR;

INSERT INTO AGENCE (nom_ville) VALUES
('Paris'),
('Lyon'),
('Marseille'),
('Toulouse'),
('Nice'),
('Nantes'),
('Strasbourg'),
('Montpellier'),
('Bordeaux'),
('Lille'),
('Rennes'),
('Reims');

SELECT id_agence, nom_ville FROM AGENCE;


//IMPORTANT : id_agence_depart ≠ id_agence_arrivee ; date_arrivee > date_depart ; 0 ≤ nb_places_dispo < nb_places_tot


INSERT INTO TRAJET (date_depart, date_arrivee, nb_places_tot, nb_places_dispo, id_utilisateur, id_agence_depart, id_agence_arrivee) VALUES
-- Trajet normal
('2026-07-20 08:00:00', '2026-07-20 11:00:00', 5, 4,
    (SELECT id_utilisateur FROM UTILISATEUR WHERE email = 'alexandre.martin@email.fr'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Lille'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Paris')),

-- Trajet normal
('2026-07-23 08:00:00', '2026-07-23 10:00:00', 5, 2,
    (SELECT id_utilisateur FROM UTILISATEUR WHERE email = 'sophie.dubois@email.fr'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Paris'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Reims')),

-- Trajet complet (0 place dispo -> ne doit pas s'afficher sur la page d'accueil)
('2026-07-24 08:00:00', '2026-07-24 16:00:00', 4, 0,
    (SELECT id_utilisateur FROM UTILISATEUR WHERE email = 'julien.bernard@email.fr'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Strasbourg'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Bordeaux')),

-- Trajet passé (date antérieure à aujourd'hui -> ne doit pas s'afficher sur la page d'accueil)
('2026-02-12 08:00:00', '2026-02-12 14:00:00', 4, 2,
    (SELECT id_utilisateur FROM UTILISATEUR WHERE email = 'camille.moreau@email.fr'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Paris'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Bordeaux')),

-- Trajet normal
('2026-07-25 07:30:00', '2026-07-25 09:00:00', 4, 3,
    (SELECT id_utilisateur FROM UTILISATEUR WHERE email = 'lucie.lefevre@email.fr'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Nantes'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Rennes')),

-- Trajet normal
('2026-07-26 09:00:00', '2026-07-26 11:30:00', 3, 1,
    (SELECT id_utilisateur FROM UTILISATEUR WHERE email = 'thomas.leroy@email.fr'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Lyon'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Marseille')),

-- Trajet normal (voiture encore vide, toutes les places dispo)
('2026-07-28 07:00:00', '2026-07-28 09:30:00', 4, 3,
    (SELECT id_utilisateur FROM UTILISATEUR WHERE email = 'chloe.roux@email.fr'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Toulouse'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Montpellier')),

-- Trajet normal
('2026-08-01 08:00:00', '2026-08-01 11:00:00', 5, 2,
    (SELECT id_utilisateur FROM UTILISATEUR WHERE email = 'maxime.petit@email.fr'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Bordeaux'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Nantes')),

-- Trajet normal
('2026-08-03 07:00:00', '2026-08-03 09:00:00', 2, 1,
    (SELECT id_utilisateur FROM UTILISATEUR WHERE email = 'laura.garnier@email.fr'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Nice'),
    (SELECT id_agence FROM AGENCE WHERE nom_ville = 'Marseille'));