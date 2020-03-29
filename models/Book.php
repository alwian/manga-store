<?php
class Book
{
    public $title;
    public $image;
    public $id;

    public function db_construct($record)
    {
        $this->title = $record['title'];
        $this->image = "https://cdn.mangaeden.com/mangasimg/" . $record['image'];
        $this->id = $record['title_id'];
    }
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
