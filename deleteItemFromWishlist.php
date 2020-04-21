<?php
include_once 'config/Database.php';
include_once 'models/Wishlist.php';

session_set_cookie_params("Session", "/", null, true, true);
session_name("MANGALOGIN");
session_start();

// Make sure the user is logged in.
if (!isset($_SESSION['Logged']) || $_SESSION['Logged'] == false) {
    http_response_code(401); // Unauthorized.
    header("Location: login.php");
    exit;
    // Make sure all fields are filled.
} else if ((!isset($_GET['id']) || empty($_GET['id'])) && $_GET['item_id'] != 0) {
    http_response_code(400); // Bad Request.
    echo "Item id is required.";
    exit;
}

$db = new Database();
$conn = $db->connect();

//get item id from url
$itemId = $_GET["id"];
//create cart obj
$wishlist = new Wishlist($conn);
$wishlist->item_id = $itemId;
$wishlist->user_id = $_SESSION['id'];
$wishlist->deleteItem(); // Delete the item from the cart.
header("Location: wishlist.php");
