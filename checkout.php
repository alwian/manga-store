<?php
require_once "config/Database.php";
require_once "models/Order.php";
require_once "models/Cart.php";
require_once "models/Item.php";

session_start();

// Make sure the user is logged in.
if (!isset($_SESSION['Logged']) || $_SESSION['Logged'] == false) {
    http_response_code(401); // Unauthorized.
    header("Location: login.php");
    exit;
}


$cart_error = null;
$shipping_address_error = null;
$city_error = null;
$country_error = null;
$state_error = null;
$zip_error = null;

$shipping_details = array(
        "shipping_address" => null,
        "city" => null,
        "country" => null,
        "state" => null,
        "zip" => null
);

$db = new Database();
$conn = $db->connect();

$form_submitted = $_SERVER["REQUEST_METHOD"] == "POST";
// Check if the the form been submitted.
if ($form_submitted) {
    $cart = new Cart($conn);
    $cart->user_id = $_SESSION['id'];

    if ($cart->getItems() < 1) {
        $cart_error = "Cannot checkout with an empty cart.";
    }

    if (!isset($_POST['address']) || empty($_POST['address'])) {
        $shipping_address_error = "Required.";
        http_response_code(400);
    } else {
        $shipping_details['shipping_address'] = $_POST['address'];
    }

    if (!isset($_POST['country']) || empty($_POST['country'])) {
        $country_error = "Required.";
        http_response_code(400);
    } else {
        $shipping_details['country'] = $_POST['country'];
        if ($shipping_details['country'] != "Canada" && $shipping_details['country'] != "England" && $shipping_details['country'] != "United States") {
            $country_error = "We only ship to Canada, England and the United States.";
        }
    }

    if (!isset($_POST['city']) || empty($_POST['city'])) {
        $city_error = "Required.";
        http_response_code(400);
    } else {
        $shipping_details['city'] = $_POST['city'];
    }

    if (!isset($_POST['state']) || empty($_POST['state'])) {
        $state_error = "Required.";
        http_response_code(400);
    } else {
        $shipping_details['state'] = $_POST['state'];
    }

    if (!isset($_POST['zip']) || empty($_POST['zip'])) {
        $zip_error = "Required.";
        http_response_code(400);
    } else {
        $shipping_details['zip'] = $_POST['zip'];
    }

    // Make sure all fields have been filled.
    if ($cart_error == null && $shipping_address_error == null && $country_error == null && $state_error == null && $city_error == null && $zip_error == null) {
        $order = new Order($conn);
        $order->user_id = $_SESSION["id"];
        $order->shipping_info = $shipping_details["shipping_address"] . ", " . $shipping_details["city"] . ", " . $shipping_details["state"] . ", " . $shipping_details["zip"] . ", " . $shipping_details["country"];
        $shipping = $order->shipping_info;
        $order->addToOrder(); // Add all items and shipping info ti the order.
        $_SESSION['order_id'] = $order->order_id;
        header("Location: confirm.php");
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
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" media="screen"/>
    <link type="text/css" rel="stylesheet" href="css/style.css">
    <title>Checkout</title>
</head>

<body>
<?php require "header.php"; // Load header to top of page
?>
<!-- Container to hold form -->
<div class="page-container">
    <h1 class="text-center" style="margin-top:1rem;">Checkout</h1>
    <!-- Form on submit post details to confirm.php -->
    <form class="forms" action="checkout.php" method="post">
        <div id="form-inputs">
            <div id="left-forms">
                <div class="form-group">
                    <div id="address">
                        <label for="InputAddress">Shipping Address</label>
                        <input type="text" class="form-control" id="InputAddress" name="address" placeholder="Address">
                    </div>
                    <div id="city">
                        <label for="InputCity">City</label>
                        <input type="text" class="form-control" id="InputCity" name="city" placeholder="City">
                    </div>
                    <div id="country">
                        <label for="SelectCountry">Country</label>
                        <select class="form-control" id="SelectCountry" name="country">
                            <option>Canada</option>
                            <option>England</option>
                            <option>United States</option>
                        </select>
                    </div>
                </div>
            </div>
            <div id="right-forms">
                <div class="form-group">
                    <div id="state">
                        <label for="InputState">State</label>
                        <input type="text" class="form-control" id="InputState" name="state" placeholder="State">
                    </div>
                    <div id="zip">
                        <label for="InputZip">Zip</label>
                        <input type="text" class="form-control" id="InputZip" name="zip" placeholder="Zip">
                    </div>
                </div>
            </div>
        </div>
        <hr class="col-12">
        <div id="pay-button">
            <!--Post shipping information and place order on click-->
            <button type="submit" class="btn" id="paypal-button"></button>
        </div>
    </form>
</div>
<!-- Import scripts -->
<script src="js/jquery-3.4.1.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>

</html>