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
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return null;
        }
    }
}