<?php
include_once 'config/Database.php';
include_once 'models/Cart.php';
include_once 'models/Item.php';
include_once 'models/Order.php';

session_start();

// If the user is already logged in, take them to the homepage.
if (!isset($_SESSION['Logged']) || $_SESSION['Logged'] == false) {
    header("Location: login.php");
}

//Create connection to the data base and new instance of Order
$db = new Database();
$conn = $db->connect();
$order = new Order($conn);
$order->user_id = $_SESSION['id'];


// Check if the the form been submitted.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ((isset($_POST['address']) && !empty($_POST['address'])) && (isset($_POST['country']) && !empty($_POST['country'])) && (isset($_POST['city']) && !empty($_POST['city']))
        && (isset($_POST['state']) && !empty($_POST['state'])) && (isset($_POST['zip']) && !empty($_POST['zip']))
    ) {
        
        $order = new Order($conn);
        $order->user_id = $_SESSION["id"];
        $order->shipping_info = $_POST["address"] . ", " . $_POST["city"] . ", " . $_POST["state"] . ", " . $_POST["zip"] . ", " . $_POST["country"];
        $shipping = $order->shipping_info;
        $order->addToOrder();
    } else {
        echo "Item error";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Import Stylesheets-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "header.php"; //load header to top of page ?>
    <h1 class="text-center" style="margin-top:1rem">Thank you for your purchase. We have received your order.</h1><br><br>
    <!-- Container to display order details after submitting order-->
    <div class="container col-1w" style="border: .25rem rgb(241, 241, 241) solid; border-radius: 2rem; padding-bottom: 1rem;">
        </br>
        <h2 class="text-center" id="cart-header">Here's your order:</h2></br></br>
        <div class="container col-12 bg-dark" style="padding: 1rem; border-radius: 2rem;">
            <table class="table table-dark table-striped table-hover " style="margin-bottom:0;">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID#</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">QTY</th>
                        <th scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalSum = 0;
                    $count = 0;
                    // For each item in the order print the item details to the table
                    foreach ($order->getSoldItems() as $current_item) {
                        $item = new Item($conn);
                        $item->item_id = $current_item['item_id'];
                        $quantity = $current_item['quantity'];

                        if ($item->getItem()) {
                            $amount = $quantity * $item->price;
                            $totalSum += $amount;


                            echo "<tr>
                                        <td>$item->item_id</td>
                                        <td>$item->name</td>
                                        <td>$item->price</td>
                                        <td>$quantity</td>
                                        <td>$amount</td>
                                        </tr>";
                        } else {
                            echo 'Item unavailable.';
                        }
                    }
                    echo "<thead class=\"thead-dark\">
                            <tr>
                                <th scope=\"col\">Total: $ $totalSum</th>
                                <th scope=\"col\"> &emsp; &emsp;</th>
                                <th scope=\"col\"> &emsp;</th>
                                <th scope=\"col\"> &emsp;</th>
                                <th scope=\"col\"></th>
                            </tr>
                            </thead>";
                    ?>
                </tbody>
            </table>
        </div>
        </br>
        <!-- Display the shipping information-->
        <div class="container" id="shipping-details">
            <h5>Shipping to:</h5>
            <h5><?php echo "$shipping"  ?></h5>
        </div>
    </div>
    <!-- Import scripts -->
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>

</html>