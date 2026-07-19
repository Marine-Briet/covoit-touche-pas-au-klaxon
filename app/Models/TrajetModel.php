<?php

namespace App\Models;

use Core\DefaultModel;


class TrajetModel extends DefaultModel {
    protected string $table = 'trajet';
    protected string $primaryKey = 'id_trajet';

    // Récupère tous les trajets à venir avec places disponibles, triés par date de départ croissante.
    public function findAllAvailable(): array
    {
        $sql = "SELECT 
                    t.id_trajet,
                    t.date_depart,
                    t.date_arrivee,
                    t.nb_places_tot,
                    t.nb_places_dispo,
                    dep.nom_ville AS ville_depart,
                    arr.nom_ville AS ville_arrivee,
                    u.id_utilisateur,
                    u.nom,
                    u.prenom,
                    u.telephone,
                    u.email
                FROM trajet t
                INNER JOIN agence dep ON t.id_agence_depart = dep.id_agence
                INNER JOIN agence arr ON t.id_agence_arrivee = arr.id_agence
                INNER JOIN utilisateur u ON t.id_utilisateur = u.id_utilisateur
                WHERE t.nb_places_dispo > 0
                AND t.date_depart > NOW()
                ORDER BY t.date_depart ASC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    // Récupère un trajet précis avec toutes les infos jointes (pour la modale de détails et le formulaire de modification).
    public function findByIdWithDetails(int $id): ?array
    {
        $sql = "SELECT 
                    t.*,
                    dep.nom_ville AS ville_depart,
                    arr.nom_ville AS ville_arrivee,
                    u.nom,
                    u.prenom,
                    u.telephone,
                    u.email
                FROM trajet t
                INNER JOIN agence dep ON t.id_agence_depart = dep.id_agence
                INNER JOIN agence arr ON t.id_agence_arrivee = arr.id_agence
                INNER JOIN utilisateur u ON t.id_utilisateur = u.id_utilisateur
                WHERE t.id_trajet = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    public function findAllWithDetails(): array
    {
    $sql = "SELECT 
                t.*,
                dep.nom_ville AS ville_depart,
                arr.nom_ville AS ville_arrivee,
                u.nom, u.prenom
            FROM trajet t
            INNER JOIN agence dep ON t.id_agence_depart = dep.id_agence
            INNER JOIN agence arr ON t.id_agence_arrivee = arr.id_agence
            INNER JOIN utilisateur u ON t.id_utilisateur = u.id_utilisateur
            ORDER BY t.date_depart DESC";

    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll();
    }
}