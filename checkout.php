<?php
    session_start();

    // If the user is already logged in, take them to the homepage.
    if(!isset($_SESSION['Logged']) || $_SESSION['Logged'] == false){
        http_response_code(403);
        header("Location: login.php");
        exit;
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
    <?php require "header.php";?>
    <div class="page-container">
        <h1 class="text-center" style="margin-top:1rem;">Checkout</h1>
        <form class="forms" action="confirm.php" method="post">
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
                            <select type="dropdown" class="form-control" id="SelectCountry" name="country">
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
                <!--Link to thankyou.php, remove when button is resized and used as a link instead-->
                <button type="submit" class="btn" id="paypal-button"></button>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
