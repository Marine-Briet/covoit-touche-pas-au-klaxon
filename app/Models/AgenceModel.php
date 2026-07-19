<?php

namespace App\Models;

use Core\DefaultModel;

/**
 * Modèle représentant une agence (ville).
 * Hérite des méthodes CRUD génériques de DefaultModel.
 * CRUD complet géré par l'administrateur uniquement.
 *
 * @package App\Models
 */
class AgenceModel extends DefaultModel
{
    protected string $table = 'agence';
    protected string $primaryKey = 'id_agence';
}