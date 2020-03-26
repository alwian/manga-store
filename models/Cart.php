<?php
class Cart
{
    private $table = 'cart_items';
    private $conn;

    public $user_id;
    public $item_id;
    public $quantity;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function update() {
        if ($this->quantity === 0) {
            return $this->deleteItem();
        } else {
            $query = "INSERT INTO $this->table (user_id, item_id, quantity) VALUES (:user_id, :item_id, :quantity) ON DUPLICATE KEY UPDATE quantity = :quantity";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":item_id", $this->item_id);
            $stmt->bindParam(":quantity", $this->quantity);

            try {
                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                echo $e->getMessage();
                return null;
            }
        }
    }

    public function getItems() {
        $query = "SELECT item_id, quantity FROM $this->table WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    private function deleteItem() {
        $query = "DELETE FROM $this->table WHERE user_id = :user_id AND item_id = :item_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":item_id", $this->item_id);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}