<?php
session_start();
include_once 'config/Database.php';
include_once 'models/Cart.php';
include_once 'models/Item.php';

session_start();

// If the user is already logged in, take them to the homepage.
if(!isset($_SESSION['Logged']) || $_SESSION['Logged'] == false){
    header("Location: index.php");
}

$db = new Database();
$conn = $db->connect();
$cart = new Cart($conn);
$cart->user_id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" media="screen,projection" />
        <link type="text/css" rel="stylesheet" href="css/style.css">
        <title>Cart</title>
    </head>
    <body>
    <?php
        require_once 'header.php';
    ?>
    <div class="container">
        <h1>My Cart</h1>
        <?php
            foreach ($cart->getItems() as $current_item) {
                $item = new Item($conn);
                $item->item_id = $current_item['item_id'];
                if ($item->getItem()) {
                    echo $item->average_rating;
                } else {
                    echo 'Item unavailable.';
                }
            }
        ?>
    </div>
    </body>
</html>



