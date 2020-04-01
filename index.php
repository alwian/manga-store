<?php
session_start();

// If the user is already logged in, take them to the homepage.
if(!isset($_SESSION['Logged']) || $_SESSION['Logged'] == false){
    http_response_code(403);
    header("Location: login.php");
    exit;
}

require_once "config/Database.php";
require_once "models/Item.php";

$db = new Database();
$conn = $db->connect();
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="referrer" content="no-referrer" />
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga Store</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/style.css">

</head>

<body>
<?php
require "header.php";
?>
<div class="page-container">
    <h2>Best Sellers</h2>
    <div class="items">
        <?php
        $item = new Item($conn);
        if ($recommended = $item->getTopTen()) {
            foreach ($recommended as $i) {
                $item->item_id = $i['item_id'];
                $item->getItem();
                $item->displayCard();
            }
        }
        ?>
    </div>
    <h2>Catalogue</h2>
    <div class="items">
        <?php
        if ($items = $item->getItems()) {
            foreach ($items as $i) {
                $item->item_id = $i['item_id'];
                $item->getItem();
                $item->displayCard();
            }
        }
        ?>
    </div>
</div>

<!--JavaScript at end of body for optimized loading-->
<script type="text/javascript" src="js/jquery-3.4.1.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>

</html>