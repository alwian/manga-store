<?php
// this file contains my logic for connecting to the DB.
include_once 'config/Database.php';
include 'models/Queries.php';
include 'models/Book.php';

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
