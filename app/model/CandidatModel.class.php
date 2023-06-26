<?php

namespace model;

use lib\DataManipulator;
use lib\TableManipulator;

class CandidatModel
{
    private $tableName;
    private $columns;
    private $dataManipulator;
    private $tableManipulator;

    public function __construct()
    {
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
    }
}
