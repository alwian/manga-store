
<?php
    include_once 'config/Database.php';
    include_once 'models/Cart.php';
    session_start();
    $db = new Database();

    //get item id from url
    $itemId = $_GET["id"];
    //create cart obj
    $cart = new Cart($db->connect());
    $cart->item_id = $itemId;
    $cart->user_id =  $_SESSION['id'];
    $cart->deleteItem();
    header("Location: cart.php");
?>