<?php
require 'config/Database.php';
require 'models/User.php';
require 'models/Item.php';
require_once 'models/Order.php';

session_start();

// Make sure the user is already logged in.
if (!isset($_SESSION['Logged']) || $_SESSION['Logged'] == false) {
    http_response_code(401); // Unauthorized.
    header("Location: login.php");
    exit;
}

// Make sure an item id is specified.
if ((!isset($_GET['id']) || empty($_GET['id'])) && $_GET['id'] != 0) {
    http_response_code(400); // Bad request.
    echo 'Item ID must be specified.';
    exit;
}

$db = new Database();
$conn = $db->connect();

$order = new Order($conn);
$order->user_id = $_SESSION['id'];
$item = new Item($conn);
$item->item_id = $_GET['id'];
//for each order the user has placed, show order details
foreach ($order->getOrdersForUser() as $o) {
    $order->order_id = $o['order_id'];
    foreach ($order->getSoldItems() as $product) {
        if ($product['item_id'] == $item->item_id) {
            $item->owned = True;
            break 2;
        }
    }
}

if ($item->owned != True) {
    header("Refresh: 5; URL=library.php");
    echo "You do not own this item.";
    echo "<br>You will be redirected in 5 seconds...";
    exit;
}

if (!$item->exists()) { // Make sure the specified item exists.
    http_response_code(404); // Not Found.
    echo 'Could not find the specified item.';
    exit;
}

$item->getItem();
$seller = new User($conn);
$seller->user_id = $item->seller_id;
$seller->getUser();

?>

<!DOCTYPE html>
<html>

<head>
    <!--Import stylesheets-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="css/style.css">
    <title><?php echo "Reading: {$item->name}"; ?></title>
</head>

<body>
    <?php
    require "header.php";
    ?>
    <div class="container col-12 bg-dark" id="viewer">
        <h2 style="color: lightgrey; margin: auto; width: 50%"><?php echo $item->name; ?></h2>
        <?php
            for($i = 0; $i < $item->number_pages; $i++){
                echo "<div id=\"book\"> Page {$i} </div>";
            }
        ?>
    </div>
    <script src="js/jquery-3.4.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>