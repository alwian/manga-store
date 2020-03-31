<?php
// this file contains my logic for connecting to the DB.
require_once 'config/Database.php';
include 'models/Queries.php';
require_once 'models/User.php';
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
                    <a href="page.php/?id={$this->id}" class="btn btn-primary">View</a>
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



function displayUsers(){
    $db = new Database();
    $query = "SELECT user_id,email,first_name,last_name,type FROM `users`";

    try{
        $stmt = new Queries($db->connect(), $query);
        $result = $stmt->recommendQuery();
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $user = new User($db);
                $user->user_id = $row['user_id'];
                $user->email = $row['email'];
                $user->first_name = $row['first_name'];
                $user->last_name = $row['last_name'];
                $user->type= $row['type'];
                echo "<tr>
                                <td>$user->user_id</td>
                                 <!-- Delete Modal-->
                                <div class=\"modal fade\" id=\"deleteConfirm$user->user_id\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
                                    <div class=\"modal-dialog\" role=\"document\">
                                        <div class=\"modal-content\">
                                            <div class=\"modal-header\">
                                                <h5 class=\"modal-title\" id=\"exampleModalLabel\">Do you want to delete it?</h5>
                                                <button class=\"close\" type=\"button\" data-dismiss=\"modal\" aria-label=\"Close\">
                                                    <span aria-hidden=\"true\">×</span>
                                                </button>
                                            </div>
                                            <div class=\"modal-body\">Select \"Delete\" below if you want to delete this account.</div>
                                            <div class=\"modal-footer\">
                                                <button class=\"btn btn-secondary\" type=\"button\" data-dismiss=\"modal\">Cancel</button>
                                                <a class=\"btn btn-primary\" href=\"deleteConfirm.php?id=$user->user_id\">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <td>$user->email</td>
                                <td>$user->first_name&nbsp;$user->last_name</td>
                                <td>$user->type &nbsp;&nbsp;&nbsp;
                                <a href='userRoleChange.php?id=$user->user_id'><i class=\"fas fa-edit text-primary\"></i>Edit&nbsp;&nbsp&nbsp;&nbsp</a>
                                <a href='dashboard/accountManage.php?id=$user->user_id' data-toggle='modal' data-target='#deleteConfirm$user->user_id'><i class=\"fas fa-trash text-danger\"></i>Delete</a>
                                </td>
                      </tr>
                      ";


            }
        }
    }
    catch (PDOException $e) {
        //echo $e->getMessage();
        return null;
    }
}




