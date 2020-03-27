<?php
class Database
{
    private $dbname = 'csci3172g1';
    private $host = 'db.cs.dal.ca';
    private $username = 'jiashu';
    private $password = 'eF3ubPFYPXZgrGV6fnMx7w9gQ';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';', $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return null;
        }
        return $this->conn;
    }
}