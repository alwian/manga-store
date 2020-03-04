<?php
// include ('config.php');
session_start();
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
            <img src="{$this->image}">
            <span class="card-title">{$this->title}</span>
        </div>
        <div class="card-content">
            <p>{$this->id}</p>
        </div>
        <div class="card-action">
            <a href="#">This is a link {$this->index}</a>
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
