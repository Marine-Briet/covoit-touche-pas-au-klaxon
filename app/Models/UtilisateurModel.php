<?php

namespace App\Models;

use Core\DefaultModel;

/**
 * Modèle représentant un utilisateur (employé).
 * Hérite des méthodes CRUD génériques de DefaultModel.
 *
 * @package App\Models
 */
class UtilisateurModel extends DefaultModel
{
    protected string $table = 'utilisateur';
    protected string $primaryKey = 'id_utilisateur';

    /**
     * Récupère un utilisateur par son adresse email (utilisé pour la connexion).
     *
     * @param string $email Adresse email de l'utilisateur recherché
     * @return array<string, mixed>|null Les données de l'utilisateur, ou null si non trouvé
     */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();

        return $result ?: null;
    }
}