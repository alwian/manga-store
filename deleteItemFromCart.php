
<?php
include_once 'config/Database.php';
include_once 'models/Cart.php';
session_start();

// If the user is already logged in, take them to the homepage.
if (!isset($_SESSION['Logged']) || $_SESSION['Logged'] == false) {
    http_response_code(403);
    header("Location: login.php");
    exit;
} else if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    echo "Item id is required.";
    exit;
}

$db = new Database();
$conn = $db->connect();

//get item id from url
$itemId = $_GET["id"];
//create cart obj
$cart = new Cart($conn);
$cart->item_id = $itemId;
$cart->user_id =  $_SESSION['id'];
$cart->deleteItem();
header("Location: cart.php");
