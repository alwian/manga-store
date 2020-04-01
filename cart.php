<?php
    include_once 'config/Database.php';
    include_once 'models/Cart.php';
    include_once 'models/Item.php';

    session_start();

    // If the user is already logged in, take them to the homepage.
    if(!isset($_SESSION['Logged']) || $_SESSION['Logged'] == false){
        http_response_code(403);
        header("Location: login.php");
        exit;
    }

    $db = new Database();
    $conn = $db->connect();
    $cart = new Cart($conn);
    $cart->user_id = $_SESSION['id'];

    // Check if the the form been submitted.
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['quantity']) && !empty($_POST['quantity']) && isset($_POST['item_id']) && !empty($_POST['item_id'])){
            $cart->item_id = $_POST["item_id"];
            $cart->quantity = $_POST["quantity"];

            $item = new Item($conn);
            $item->item_id = $_POST['item_id'];
            if ($item->exists()) {
                if ($item->stock >= $cart->quantity) {
                    if (!$cart->addItem()) {
                        http_response_code(500);
                        echo 'There was an error adding the item.';
                        exit;
                    }
                } else {
                    http_response_code(400);
                    echo 'We do not have that many items in stock.';
                    exit;
                }

            } else {
                http_response_code(404);
                echo 'Could not add item, item does not exist.';
                exit;
            }

        } else{
            http_response_code(400);
            echo 'Item quantity and ID required.';
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
    </br>
    <div class="container col-1w" style="border: .25rem rgb(241, 241, 241) solid; border-radius: 2rem; padding-bottom: 1rem;">
        </br>
        <h2 class="text-center" id="cart-header">My Cart</h2></br></br>
        <div class="container col-12 bg-dark" style="padding: 1rem; border-radius: 2rem;">
            <table class="table table-dark table-striped table-hover " style="margin-bottom:0;">
                <thead class="thead-dark" >
                    <tr>
                        <th scope="col">ID#</th>
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
                                        <td>$item->name</td>
                                        <td>$item->price</td>
                                        <td>$quantity</td>
                                        <td>$amount</td>
                                        <td><a href='deleteItemFromCart.php?id=$item->item_id'><span class='material-icons text-light' alt='delete'>delete</span></a></td>
                                        </tr>";
                        }
                    }
                    echo "<thead class=\"thead-dark\">
                            <tr>
                                <th scope=\"col\">Total: $ $totalSum</th>
                                <th scope=\"col\"> &emsp; &emsp;</th>
                                <th scope=\"col\"> &emsp;</th>
                                <th scope=\"col\"> &emsp;</th>
                                <th scope=\"col\"> &emsp;</th>
                                <th scope=\"col\">
                                    <form action='checkout.php' Method='POST'>
                                        <button type='submit' class='btn' id='cart-btn' href=\"checkout.php\"> Checkout</button>
                                    </form>
                                </th>
                            </tr>
                            </thead>";
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>



