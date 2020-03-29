<?php
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
    <!--Import materialize.css-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/style.css">

    <title>Cart</title>
</head>
<body>
<?php
require_once 'header.php';
?>

<h1>My Cart</h1>



<div class="container">
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">ID#</th>
            <th scope="col">Image</th>
            <th scope="col">Product</th>
            <th scope="col">Price</th>
            <th scope="col">QTY</th>
            <th scope="col">Amount</th>
            
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($cart->getItems() as $current_item) {
            $item = new Item($conn);
            $item->item_id = $current_item['item_id'];

            if ($item->getItem()) {
                //under this part
                echo "<tr>
                              <td>$item->item_id</td>
                              <td><img href = $item->image\"></td>
                              <td>$item->name</td>
                              <td>$item->price</td>
                              <td>2</td>
                              <td>$item->price</td>
                            
                            </tr>";
            } else {
                echo 'Item unavailable.';
            }
        }

        echo " </tbody>
                </table>";
        ?>

        <div class="container">
            <table class="table">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Total &emsp; $ Checkout</th>
                    <th scope="col"></th>

                </tr>
                </thead>
                <tbody>
        </div>
</body>
</html>



