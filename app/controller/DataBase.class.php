<?php
class DataBase
{
    private  $user =  "root";
    private $password = "pass";
    private $db_name = "project_data_base";
    private $host = "mysql";
    private  $dsn;

    public function __construct()
    {
        $this->dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;
    }

    public function connect()
    {
        try {
            $conn = new PDO($this->dsn, $this->user, $this->password);
            // Set PDO attributes
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $conn;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
