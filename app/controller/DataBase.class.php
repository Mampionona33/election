<?php

namespace controller;

use PDO;
use PDOException;

class DataBase
{
    private  $user;
    private $password;
    private $db_name;
    private $host;
    private  $dsn;
    private $conn;

    public function setUser(string $user): void
    {
        $this->user = $user;
    }
    public function getUser(): string
    {
        return $this->user;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function setDbName(string $db_name): void
    {
        $this->db_name = $db_name;
    }
    public function getDbName(): string
    {
        return $this->db_name;
    }
    public function setHost(string $host): void
    {
        $this->host = $host;
    }
    public function getHost(): string
    {
        return   $this->host;
    }

    private function setConn(PDO $conn): void
    {
        $this->$conn = $conn;
    }

    public function getConn(): PDO
    {
        return $this->conn;
    }

    public function __construct()
    {
        $this->setUser("root");
        $this->setPassword("pass");
        $this->setDbName("project_data_base");
        $this->setHost("mysql");
        $this->dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;
    }

    public function connect()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $this->conn;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
