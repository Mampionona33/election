<?php

namespace lib;

use controller\DataBase;
use PDOException;

class TableManipulator
{
    private $db;
    private $dataBase;

    public function __construct()
    {
        $this->dataBase = new DataBase();
        $this->db = $this->dataBase->connect();
    }

    public function createTable($tableName, $columns)
    {
        try {
            $columnsQuery = [];
            $primaryKeys = [];

            foreach ($columns as $column) {
                $columnName = $column['name'];
                $columnType = $column['type'];
                $isRequired = $column['required'] ? 'NOT NULL' : '';
                $isAutoIncrement = isset($column['auto_increment']) && $column['auto_increment'] ? 'AUTO_INCREMENT' : '';

                if ($columnType === 'ENUM') {
                    $enumValues = "'" . implode("', '", $column['values']) . "'";
                    $defaultValue = "'" . $column['values'][0] . "'";
                    $columnsQuery[] = "$columnName $columnType($enumValues) $isRequired $isAutoIncrement DEFAULT $defaultValue";
                } else {
                    $columnsQuery[] = "$columnName $columnType $isRequired $isAutoIncrement";
                }

                if (isset($column['auto_increment'])) {
                    $primaryKeys[] = $columnName;
                }
            }

            $columnsString = implode(', ', $columnsQuery);
            $primaryKeysString = implode(', ', $primaryKeys);

            $sql = "CREATE TABLE IF NOT EXISTS $tableName ($columnsString, PRIMARY KEY ($primaryKeysString));";
            $this->db->exec($sql);

            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la création de la table : " . $e->getMessage();
            return false;
        }
    }
}
