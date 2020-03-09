<?php
class User
{
    private $table = 'users';
    private $conn;

    public $user_id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $phone;
    public $image;
    public $bio;
    public $type;


    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function create() {
        $query = "INSERT INTO $this->table (first_name, last_name, email, password, phone, image, bio, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->execute(array($this->first_name, $this->last_name, $this->email, password_hash($this->password, PASSWORD_DEFAULT), $this->phone, $this->image, $this->bio, $this->type));
            $this->user_id = $this->conn->lastInsertId();
            return $this->user_id;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return null;
        }
    }

    public function exists() {
        $query = "SELECT email FROM $this->table WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->execute(array($this->email));
            return ($stmt->rowCount() > 0);
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return null;
        }
    }

    public function checkLogin() {
        $query = "SELECT email, password FROM $this->table WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->execute(array($this->email));
            if ($stmt->rowCount() == 1) {
                $stmt->bindColumn('password', $hashed_password);
                $stmt->fetch(PDO::FETCH_BOUND);
                return password_verify($this->password, $hashed_password);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}