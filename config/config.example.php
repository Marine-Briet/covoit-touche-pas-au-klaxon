<?php
// Copier ce fichier en config.php et renseigner vos propres valeurs.
// config.php n'est pas versionné (voir .gitignore).

if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
}

if (!defined('DB_NAME')) {
    define('DB_NAME', 'touche_pas_au_klaxon');
}

if (!defined('DB_USER')) {
    define('DB_USER', 'votre_utilisateur');
}

if (!defined('DB_PASS')) {
    define('DB_PASS', 'votre_mot_de_passe');
}

if (!defined('DB_CHARSET')) {
    define('DB_CHARSET', 'utf8mb4');
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/covoit-touche-pas-au-klaxon/public');
}
