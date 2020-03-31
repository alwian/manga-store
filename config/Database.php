<?php
class Database
{
    private $dbname = 'csci3172g1';
    private $host = 'localhost';
    private $username = 'root';
<<<<<<< HEAD
    private $password = '';
=======
    private $password = 'root';
>>>>>>> feature/header
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