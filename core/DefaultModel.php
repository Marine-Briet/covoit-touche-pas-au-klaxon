<?php

namespace Core;

use PDO;


abstract class DefaultModel
{
    protected PDO $pdo;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct()
    {
        // Chaque modèle récupère la MÊME connexion PDO via le Singleton
        $this->pdo = Database::getInstance()->getPdo();
    }

    // Récupère tous les enregistrements
    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    // Récupère un enregistrement par son ID
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    // Insère un nouvel enregistrement
    public function insert(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($data);
    }

    // Met à jour un enregistrement existant, identifié par son ID
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

    // Supprime un enregistrement par son ID.
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }
}