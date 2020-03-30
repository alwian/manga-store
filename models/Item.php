<?php
class Item
{
    private $table = 'items';
    private $conn;

    public $item_id;
    public $seller_id;
    public $name;
    public $price;
    public $stock;
    public $image;
    public $description;
    public $average_rating;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getItem() {
        $query = "SELECT item_id, seller_id, name, price, stock, image, description, total_rating / rating_count as average_rating FROM $this->table WHERE item_id = :item_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":item_id", $this->item_id);

        try {
            $stmt->execute();
            $stmt->bindColumn('seller_id', $this->seller_id);
            $stmt->bindColumn('name', $this->name);
            $stmt->bindColumn('price', $this->price);
            $stmt->bindColumn('stock', $this->stock);
            $stmt->bindColumn('image', $this->image);
            $stmt->bindColumn('description', $this->description);
            $stmt->bindColumn('average_rating', $this->average_rating);
            if ($stmt->rowCount() === 1) {
                $stmt->fetch(PDO::FETCH_BOUND);
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }


    public function addItem(){
        $query = "SELECT  FROM $this->table WHERE item_id = :item_id";
    }
}