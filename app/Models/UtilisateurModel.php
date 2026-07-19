<?php

namespace App\Models;

use Core\DefaultModel;

class UtilisateurModel extends DefaultModel
{
    protected string $table = 'utilisateur';
    protected string $primaryKey = 'id_utilisateur';

    
    // Récupère un utilisateur par son adresse email (connexion)
    
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();

        return $result ?: null;
    }
}