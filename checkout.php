<?php

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
    <h1 class="text-center">Checkout</h1><br><br>

    <form class="forms" action="checkout.php" method="post">
        <div id="form-inputs">
            <div id="left-forms">
                <div class="form-group">
                    <div id="fullname">
                        <label for="InputFullName">Full Name</label>
                        <input type="text" class="form-control" id="InputFullName" name="full_name" placeholder="Full name">
                    </div>
                </div>
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
                    <div id="email">
                        <label for="InputEmail">Email address</label>
                        <input type="email" class="form-control" id="InputEmail" name="email" placeholder="Email">

                    </div>
                </div>
                <div class="form-group">
                    <div id="state">
                        <label for="InputState">State</label>
                        <input type="state" class="form-control" id="InputState" name="state" placeholder="State">
                    </div>
                    <div id="zip">
                        <label for="InputZip">Zip</label>
                        <input type="zip" class="form-control" id="InputZip" name="zip" placeholder="Zip">
                    </div>

                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" id="order-button">Place Order</button>




    </form>
</div>


</body>
</html>
