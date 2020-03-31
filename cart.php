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

<h1 class="text-center">My Cart</h1><br><br>



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
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $totalSum = 0;
        $count = 0;
        foreach ($cart->getItems() as $current_item) {
            $item = new Item($conn);
            $item->item_id = $current_item['item_id'];
            $quantity=$current_item['quantity'];

            if ($item->getItem()) {
                $amount = $quantity*$item->price;
                $totalSum +=$amount;
                

                echo "<tr>
                              <td>$item->item_id</td>
                              <td><img href = $item->image\"></td>
                              <td>$item->name</td>
                              <td>$item->price</td>
                              <td>$quantity</td>
                              <td>$amount</td>
                              <td><a href='deleteItemFromCart.php?id=$item->item_id'>Delete &emsp;<span class='material-icons bg-white text-danger'>delete</span></a></td>
                            </tr>";
            } else {
                echo 'Item unavailable.';
            }
        }

        echo " 
            
            <thead class=\"thead-light\">
                <tr>
                    <th scope=\"col\">Total: $ $totalSum</th>
                    <th scope=\"col\"> &emsp; &emsp;</th>
                    <th scope=\"col\"> &emsp; &emsp;</th>
                    <th scope=\"col\"> &emsp;</th>
                    <th scope=\"col\"> &emsp;</th>
                    <th scope=\"col\"> &emsp;</th>
                    <th scope=\"col\"><a href=\"checkout.php\"> Checkout</a></th>
                </tr>
                </thead>
                </tbody>
                </table>";
        ?>

</body>
</html>



