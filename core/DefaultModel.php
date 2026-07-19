<?php

namespace Core;

use PDO;

/**
* Classe DefaultModel est la classe de base pour tous les modèles.
* Elle fournit les méthodes CRUD de base pour interagir avec la base de données.
*
* @package Core
*/

abstract class DefaultModel
{
    protected PDO $pdo;
    protected string $table;
    protected string $primaryKey = 'id';

    /**
    * Récupère la connexion PDO partagée via le Singleton Database.
    */

    public function __construct()
    {
        // Chaque modèle récupère la MÊME connexion PDO via le Singleton
        $this->pdo = Database::getInstance()->getPdo();
    }

    /**
    * Récupère tous les enregistrements de la table.
    *
    * @return array<int, array<string, mixed>> Tableau de tous les enregistrements
    */
    
    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    /**
    * Récupère un enregistrement par son ID
    *
    * @param int $id Identifiant de l'enregistrement recherché
    * @return array<string, mixed>|null
    */
    
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    /**
    * Insère un nouvel enregistrement
    *
    * @param array<string, mixed> $data Données à insérer
    * @return bool Succès ou échec de l'insertion
    */
    
    public function insert(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($data);
    }

    /**
    * Met à jour un enregistrement existant, identifié par son ID
    *
    * @param int $id ID de l'enregistrement à mettre à jour
    * @param array<string, mixed> $data Nouvelles données
    * @return bool Succès ou échec de la mise à jour
    */
    public function update(int $id, array $data): bool
    {
        $fields = [];
        foreach (array_keys($data) as $column) {
            $fields[] = "{$column} = :{$column}";
        }
        $fieldsStr = implode(', ', $fields);

        $sql = "UPDATE {$this->table} SET {$fieldsStr} WHERE {$this->primaryKey} = :pk";
        $data['pk'] = $id;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    /**
    * Supprime un enregistrement par son ID.
    *
    * @param int $id ID de l'enregistrement à supprimer
    * @return bool Succès ou échec de la suppression
    */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }
}