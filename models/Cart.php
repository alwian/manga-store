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

    public function getItems() {
        echo 'Not yet implemented.';
    }

    private function deleteItem() {
        echo 'Not yet implemented.';
    }
}