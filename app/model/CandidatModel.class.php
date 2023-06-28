<?php

namespace model;

use lib\DataManipulator;
use lib\TableManipulator;
use PDO;
use PDOException;

class CandidatModel extends DataManipulator
{
    private $tableName;
    private $columns;
    private $dataManipulator;
    private $tableManipulator;

    public function __construct()
    {
        parent::__construct();

        $this->tableName = "Candidats";
        $this->columns = [
            [
                'name' => 'id_candidat',
                'type' => 'INT',
                'required' => true,
                'auto_increment' => true,
            ],
            [
                'name' => 'name',
                'type' => 'VARCHAR(50)',
                'required' => true,
            ],
            [
                'name' => 'nbVoix',
                'type' => 'BIGINT',
                'required' => true,
            ]
        ];
        $this->dataManipulator = new DataManipulator();
        $this->tableManipulator = new TableManipulator();
        $this->tableManipulator->createTable($this->tableName, $this->columns);
    }

    public function createCandidat($data)
    {
        $createCandidat = $this->dataManipulator->createData($this->tableName, $data);
        if ($createCandidat) {
            return $createCandidat;
        }
        return null;
    }

    public function getCandidats()
    {
        $query = "SELECT id_candidat, name, nbVoix, CONCAT( ROUND((nbVoix * 100 / (SELECT SUM(nbVoix) FROM Candidats)), 2) ,' %') AS pourcentage FROM Candidats;";
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

    public function getCandidatPercentage(): int
    {

        return 0;
    }
}
