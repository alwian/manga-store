<?php
class Queries{

    private $conn;
    private $query;

    /**
     * Queries constructor.
     * @param $conn
     * @param $query
     */
    public function __construct($conn, $query)
    {
        $this->conn = $conn;
        $this->query = $query;
    }

    public function recommendQuery(){

        $stmt = $this->conn->prepare($this->query);
        try {
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }

    }
}
