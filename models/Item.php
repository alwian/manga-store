<?php
class Item
{
    private $table = 'items';
    private $conn;

    public $item_id;
    public $seller_id;
    public $name;
    public $author;
    public $price;
    public $stock;
    public $image;
    public $description;
    public $average_rating;
    public $number_pages;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addItem() {
        $query = "INSERT INTO $this->table (seller_id, name, author, price, stock, image, description) VALUES (:seller_id, :name, :author, :price, :stock, :image, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':seller_id', $this->seller_id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':stock', $this->stock);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':description', $this->description);

        try {
            $stmt->execute();
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
    public function exists() {
        $query = "SELECT * FROM $this->table WHERE item_id = :item_id OR name = :name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":item_id", $this->item_id);
        $stmt->bindParam(":name", $this->name);

        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getItem() {
        $query = "SELECT item_id, seller_id, name, author, price, stock, image, description, round(total_rating / rating_count * 100, 2) as average_rating, number_pages FROM $this->table WHERE item_id = :item_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":item_id", $this->item_id);

        try {
            $stmt->execute();
            $stmt->bindColumn('seller_id', $this->seller_id);
            $stmt->bindColumn('name', $this->name);
            $stmt->bindColumn('author', $this->author);
            $stmt->bindColumn('price', $this->price);
            $stmt->bindColumn('stock', $this->stock);
            $stmt->bindColumn('image', $this->image);
            $stmt->bindColumn('description', $this->description);
            $stmt->bindColumn('average_rating', $this->average_rating);
            $stmt->bindColumn('number_pages', $this->number_pages);
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


    public function getItems() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getRecommended() {
        $query = "SELECT i.* FROM items i, recommendations r WHERE i.item_id = r.item_id";
        $stmt = $this->conn->prepare($query);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }

    }

    public function displayCard()
    {
        $content = <<<EOD
        <div class="card">
            <img src="data/product-images/{$this->image}" class="card-img-top" alt="{$this->name}" style="width: 100%;">
            <div class="card-body">
                <h5 class="card-title">{$this->name}</h5>
                <div class="buttons" style="display: flex; flex-direction: row; position:absolute; bottom: 1rem;">
                    <a href="page.php?id={$this->item_id}" class="btn btn-primary">View</a>
                    <a href="#cart" class="btn btn-primary" style="left: 5rem;">Buy Now</a>
                </div>
            </div>
        </div>
EOD;
        echo $content;
    }
}