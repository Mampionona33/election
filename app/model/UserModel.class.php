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
                'name' => 'id_groupe',
                'type' => 'int',
                'required' => true,
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
        return $this->dataManipulator->getData($this->tableName);
    }

    public function getUser($user_id): array
    {
        return [];
    }

    public function getUserByEmail($data): array
    {
        $condition = "email= '" . $data["email"] . "' AND password='" . $data["password"] . "'";
        $user = $this->dataManipulator->getData($this->tableName, [], $condition);
        if (count($user) > 0) {
            return $user;
        }
        return [];
    }
}
