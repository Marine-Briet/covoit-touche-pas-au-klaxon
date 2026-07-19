<?php

namespace Core;

use PDO;
use PDOException;

/**
 * Classe Database gère la connexion à la base de données avec le pattern Singleton
 * et garantit qu'une seule connexion PDO est ouverte pendant toute l'exécution du script.
 *
 * @package Core
 */
class Database
{
    private static ?Database $instance = null;

    private PDO $pdo;

    /**
     * C'est la clé du Singleton : la seule porte d'entrée sera getInstance().
     */
    private function __construct()
    {
        require_once __DIR__ . '/../config/config.php';

        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

        try {
            // Tentative d'ouverture de la connexion PDO
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            // Si la connexion échoue, on arrête le script avec un message clair
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }

    /**
     * Point d'accès unique à l'instance.
     *
     * @return Database L'instance unique de la classe Database
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Récupère l'objet PDO pour exécuter les requêtes.
     *
     * @return PDO La connexion PDO active
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}