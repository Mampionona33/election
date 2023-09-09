<?php

namespace lib;

use controller\DataBase;
use PDO;
use PDOException;

class DataManipulator
{
    protected $db;
    protected $dataBase;

    public function __construct()
    {
        $this->dataBase = new DataBase();
        $this->db = $this->dataBase->connect();
    }

    public function createData($tableName, $data)
    {
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO $tableName ($fields) VALUES ($placeholders)";

        $stmt = $this->db->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        try {
            $stmt->execute();
            return $data;
        } catch (PDOException $e) {
            echo "Erreur lors de la création des données : " . $e->getMessage();
            exit();
        }
    }

    public function getData(string $tableName, array $columns = [], string $condition = ""): array
    {
        $query = "SELECT";


        // Si la liste de colonnes est vide, sélectionner toutes les colonnes avec *
        if (empty($columns)) {
            $query .= " *";
        } else {
            // Sinon, ajouter les colonnes à la requête
            $query .= " " . implode(", ", $columns);
        }

        // Ajouter la table à la requête
        $query .= " FROM " . $tableName;

        // Si une condition est spécifiée, l'ajouter à la requête
        if (!empty($condition)) {
            $query .= " WHERE " . $condition;
        }

        $stmt = $this->db->prepare($query);

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des données : " . $e->getMessage();
            exit();
        }
    }

    public function updateData(string $tableName, array $data, $id_key, $id_value): bool
    {
        $placeholders = '';
        $updateValues = '';

        foreach ($data as $key => $value) {
            $placeholders .= "$key = :$key, ";
            $updateValues .= "`$key` = :$key, ";
        }

        $placeholders = rtrim($placeholders, ', ');
        $updateValues = rtrim($updateValues, ', ');

        $sql = "UPDATE $tableName SET $placeholders WHERE $id_key = :id";

        $stmt = $this->db->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindValue(":id", $id_value);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour des données : " . $e->getMessage();
            return false;
        }
    }

    public function deleteData($tableName, $id_key, $id_value)
    {
        $sql = "DELETE FROM $tableName WHERE $id_key = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id_value);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression des données : " . $e->getMessage();
            return false;
        }
    }

    public function getCount(string $tableName, string $condition = ""): int
    {
        $query = "SELECT COUNT(*) AS total FROM $tableName";

        if (!empty($condition)) {
            $query .= " WHERE " . $condition;
        }

        $stmt = $this->db->prepare($query);

        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['total'];
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du nombre de lignes : " . $e->getMessage();
            exit();
        }
    }
}
