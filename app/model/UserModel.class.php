<?php

namespace model;

use lib\DataManipulator;
use lib\TableManipulator;

class UserModel
{
    private $tableName;
    private $columns;
    private $dataManipulator;
    private $tableManipulator;

    public function __construct()
    {
        $this->tableName = "User";
        $this->columns = [
            [
                'name' => 'id_user',
                'type' => 'INT',
                'required' => true,
                'auto_increment' => true,
            ],
            [
                'name' => 'email',
                'type' => 'VARCHAR(50)',
                'required' => false,
            ],
            [
                'name' => 'password',
                'type' => 'VARCHAR(50)',
                'required' => false,
            ],
            [
                'name' => 'role',
                'type' => 'ENUM',
                'values' => ['Mr', 'Mme', 'Mlle'],
                'required' => false,
            ]
        ];
        $this->dataManipulator = new DataManipulator();
        $this->tableManipulator = new TableManipulator();
        $this->tableManipulator->createTable($this->tableName, $this->columns);
    }

    public function createUser(): bool
    {
        return false;
    }

    public function getUsers(): array
    {
        return [];
    }
}
