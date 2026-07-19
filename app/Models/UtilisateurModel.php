<?php

namespace App\Models;

use Core\DefaultModel;

// Lecture seule : pas de création/modification/suppression (données RH figées)

class UtilisateurModel extends DefaultModel
{
    protected string $table = 'utilisateur';
    protected string $primaryKey = 'id_utilisateur';
}