<?php

namespace model;

use lib\TableManipulator;

class GroupeModel
{
    private $tableName;
    private $columns;
    private $tableManipulator;
    private $name;

    public function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }
    public function getTableName(): string
    {
        return $this->tableName;
    }
    public function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }
    public function getColumns(): array
    {
        if (isset($this->columns)) {
            return $this->columns;
        }
        return [];
    }

    public function setTableManipulator(TableManipulator $tableManipulator): void
    {
        $this->tableManipulator = $tableManipulator;
    }

    public function getTableManipulator(): TableManipulator
    {
        return $this->tableManipulator;
    }

    public function __construct()
    {
        $this->setTableName("Groupe");
        $this->setColumns([
            [
                'name' => 'id_groupe',
                'type' => 'INT',
                'required' => true,
                'auto_increment' => true,
            ],
            [
                'name' => 'name',
                'type' => 'VARCHAR(50)',
                'required' => true,
                'auto_increment' => false,
            ],
        ]);
        $this->setTableManipulator(new TableManipulator());
        $this->tableManipulator->createTable($this->tableName, $this->columns);
    }

    public function create($data): void
    {
    }

    public function update($data): void
    {
    }

    public function get(): array
    {
        return [];
    }

    public function getAll(): array
    {
        return [];
    }

    public function delete($id_groupe): void
    {
    }
}
