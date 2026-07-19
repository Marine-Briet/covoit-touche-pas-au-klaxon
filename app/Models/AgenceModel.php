<?php

namespace App\Models;

use Core\DefaultModel;

class AgenceModel extends DefaultModel
{
    protected string $table = 'agence';
    protected string $primaryKey = 'id_agence';
}