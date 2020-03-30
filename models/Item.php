<?php
class Item
{
    private $table = 'items';
    private $conn;

    public $item_id;
    public $seller_id;
    public $name;
    public $author_id;
    public $genres;
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
        $query = "SELECT item_id, seller_id, name, author_id, price, stock, image, description, total_rating / rating_count as average_rating FROM $this->table WHERE item_id = :item_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":item_id", $this->item_id);

        try {
            $stmt->execute();
            $stmt->bindColumn('seller_id', $this->seller_id);
            $stmt->bindColumn('name', $this->name);
            $stmt->bindColumn('author_id', $this->author_id);
            $stmt->bindColumn('price', $this->price);
            $stmt->bindColumn('stock', $this->stock);
            $stmt->bindColumn('image', $this->image);
            $stmt->bindColumn('description', $this->description);
            $stmt->bindColumn('average_rating', $this->average_rating);
            if ($stmt->rowCount() === 1) {
                $stmt->fetch(PDO::FETCH_BOUND);
                $this->getGenres();
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    private function getGenres() {
        $query = "SELECT genre FROM genres WHERE item_id = :item_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":item_id", $this->item_id);

        try {
            $stmt->execute();
            $this->genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getAuthorName() {
        $query = "SELECT name FROM authors WHERE author_id = :author_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":author_id", $this->author_id);

        try {
            $stmt->execute();
            $stmt->bindColumn('name', $author_name);
            if ($stmt->rowCount() === 1) {
                $stmt->fetch(PDO::FETCH_ASSOC);
                return $author_name;
            } else {
                return null;
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
            <img src="product-images/{$this->image}" class="card-img-top" alt="{$this->name}" style="width: 100%;">
            <div class="card-body">
                <h5 class="card-title">{$this->name}</h5>
                <p class="card-text">{$this->description}</p>
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