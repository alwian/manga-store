<?php
class User
{
    private $table = 'users';
    private $conn;

    /**
     * The ID of this user in the database.
     * @var int
     */
    public $user_id;

    /**
     * The forename of the user.
     * @var string
     */
    public $first_name;

    /**
     * The surname of the user.
     * @var string
     */
    public $last_name;

    /**
     * The email of the user.
     * @var string
     */
    public $email;

    /**
     * The password of the user.
     * @var string
     */
    public $password;

    /**
     * The phone number of the user.
     * @var string
     */
    public $phone;

    /**
     * The name of the image associated with this user.
     * @var string
     */
    public $image;

    /**
     * The bio of the user.
     * @var string
     */
    public $bio;

    /**
     * The type of user.
     * @var string
     */
    public $type;

    /**
     * User constructor.
     * @param $conn Database connection for the class to utilise.
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Creates a user.
     *
     * Handles the job adding a user to the database.
     *
     * @return int|null The ID of the created user, Indicates an error creating the user, usually because the user exists.
     */
    public function create() {
        $query = "INSERT INTO $this->table (first_name, last_name, email, password, phone, image, bio, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->execute(array($this->first_name, $this->last_name, $this->email, password_hash($this->password, PASSWORD_DEFAULT), $this->phone, $this->image, $this->bio, $this->type));
            $this->user_id = $this->conn->lastInsertId(); // Get the ID of the new user.
            return $this->user_id;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return null;
        }
    }

    /**
     * Checks whether a user exists.
     *
     * Uses the users email to check their existence.
     *
     * @return bool|null Whether the user exists, an error occurred during database interaction.
     */
    public function exists() {
        $query = "SELECT email FROM $this->table WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->execute(array($this->email));
            return ($stmt->rowCount() > 0); // See whether any users where found.
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return null;
        }
    }

    /**
     * Checks whether a set of credentials is correct.
     *
     * Uses the given email and password to check if the provided login details are correct.
     *
     * @return bool|null Whether the users details are correct, an error occurred during database interaction.
     */
    public function checkLogin() {
        $query = "SELECT user_id, email, password  FROM $this->table WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->execute(array($this->email));
            if ($stmt->rowCount() == 1) {
                $stmt->bindColumn('password', $hashed_password); // Extract the hashed password of the found user.
                $stmt->bindColumn('user_id', $user_id);
                $stmt->fetch(PDO::FETCH_BOUND);
                // Check the given password matches the found password.
                if (password_verify($this->password, $hashed_password)) {
                    $this->user_id = $user_id;
                    return true;
                }
                return false;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return null;
        }
    }


    /**
     * This function is for get user object.
     * @return bool|null Whether the user details were found, an error occurred during database interaction.
     */
    public function getUser() {
        $query = "SELECT first_name, last_name, email, phone, image, bio, type FROM $this->table WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('user_id', $this->user_id);
        try {
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $stmt->bindColumn('first_name', $this->first_name);
                $stmt->bindColumn('last_name', $this->last_name);
                $stmt->bindColumn('email', $this->email);
                $stmt->bindColumn('phone', $this->phone);
                $stmt->bindColumn('image', $this->image);
                $stmt->bindColumn('bio', $this->bio);
                $stmt->bindColumn('type', $this->type);
                $stmt->fetch(PDO::FETCH_BOUND);
                return false;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return null;
        }
    }

    /**
     * This function gets all users.
     * @return array|null All userrs, an error occurred during database interaction.
     */
    public function getUsers() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return null;
        }
    }



    /**
     * This function is for delete user from admin's dashboard
     *
     * User can be delete from Account management Table
     *
     *
     */
    public function deleteUser(){
        $query = "DELETE FROM $this->table WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }

    }
}