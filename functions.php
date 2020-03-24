<?php
// this file contains my logic for connecting to the DB.
include 'config.php';
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
        <div class="card medium">
        <div class="card-image">
            <img src="{$this->image} ">
            <span class="card-title">{$this->title}</span>
        </div>
        <div class="card-content">
            <p>{$this->id}</p>
        </div>
        <div class="card-action">
            <a href="/page.php/{$this->id}">This is a link {$this->index}</a>
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
    global $mysql;
    $query = "SELECT * FROM `recomendations`";
    $result = $mysql->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // echo $row['title'] . " " . $row['link'] . "  " . $row['image'] . "<br>";
            $books = new Book();
            $books->title = $row['title'];
            $books->id = $row['link'];
            $books->image = "https://cdn.mangaeden.com/mangasimg/" . $row['image'];
            $books->displayCard();

        }

    } else {
        echo "Error: " . $mysql . "<br>" . $mysql->error;

    }
}
