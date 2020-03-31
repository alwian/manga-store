<!DOCTYPE html>
<html lang="en">

<?php
session_start();

require 'config/Database.php';
require 'models/Item.php';

$db = new Database();
$conn = $db->connect();

$item = new Item($conn);

$id = $_GET["id"];
$item->item_id = $id;

if (!$item->getItem()) {
    echo 'Could not find the specified item.';
    exit;
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="referrer" content="no-referrer" />
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $item->author;?></title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import bootstrap.css-->
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
require "header.php";

echo 'Name: ' . $item->name . '<br><br>';
echo 'Document Author: ' . $item->author . '<br><br>';

echo '<br>';
echo $item->description . '<br>';
?>

<img src="data/product-images/<?php echo $item->image?>" referrerpolicy='no-referrer'/>

<script type="text/javascript" src="js/jquery-3.4.1.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>
