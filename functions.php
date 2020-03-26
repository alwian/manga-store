<?php
// this file contains my logic for connecting to the DB.
include_once 'config/Database.php';
include 'models/Queries.php';
class Book
{
    public $index;
    public $title;
    public $image;
    public $id;

    public function displayMeta()
    {
        echo "<img src='" . $this->image . "'><br>";
        echo $this->title . "\t" . $this->index . "\t" . $this->image . "<br>";

    }
    public function displayCard()
    {
        $content = <<<EOD
        <div class="card">
            <img src="{$this->image}" class="card-img-top" alt="{$this->title}" style="width: 100%;">
            <div class="card-body">
                <h5 class="card-title">{$this->title}</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <div class="buttons" style="display: flex; flex-direction: row; position:absolute; bottom: 1rem;">
                    <a href="page.php/{$this->id}" class="btn btn-primary">View</a>
                    <a href="#cart" class="btn btn-primary" style="left: 5rem;">Buy Now</a>
                </div>
            </div>
        </div>
    EOD;
        echo $content;
    }

}

function populateView()
{
    $API_URL = "https://www.mangaeden.com/api/list/0/?p=1&l=25";
    $RESPONSE = file_get_contents($API_URL);
    $obj = json_decode($RESPONSE);

    for ($i = 0; $i < 25; $i++) {
        # code...
        $book = new Book();
        $book->index = $i;
        $book->title = $obj->manga[$i]->t;
        $book->id = $obj->manga[$i]->i;
        $book->image = "https://cdn.mangaeden.com/mangasimg/" . $obj->manga[$i]->im;
        // $book->displayMeta();
        $book->displayCard();
    }
    ;
}

function displayBestBooks()
{
    $db = new Database();
    $query = "SELECT * FROM `recommendations`";
    try{
        $stmt = new Queries($db->connect(), $query);
        $result = $stmt->recommendQuery();
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                // echo $row['title'] . " " . $row['link'] . "  " . $row['image'] . "<br>";
                $books = new Book();
                $books->title = $row['title'];
                $books->id = $row['link'];
                $books->image = "https://cdn.mangaeden.com/mangasimg/" . $row['image'];
                $books->displayCard();
            }
        }
    }
    catch (PDOException $e) {
        //echo $e->getMessage();
        return null;
    }
}
