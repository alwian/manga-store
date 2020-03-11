<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp Page</title>
    <!--Import Stylesheets-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "header.php";?>

    <div class="page-container">
        <h2>Sign Up</h2>

        <form class="forms">
            <div id="form-inputs">
                <div id="left-forms">
                    <div class="form-group">
                        <div id="firstname">
                            <label for="InputFirstName">First Name</label>
                            <input type="text" class="form-control" id="InputFirstName" placeholder="First name">
                        </div>
                        <div id="lastname">
                            <label for="InputLastName">Last Name</label>
                            <input type="text" class="form-control" id="InputLastName" placeholder="Last name">
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="address">
                            <label for="InputAddress">Address</label>
                            <input type="text" class="form-control" id="InputAddress" placeholder="Address">
                        </div>
                        <div id="country">
                            <label for="SelectCountry">Country</label>
                            <select type="dropdown" class="form-control" id="SelectCountry" placeholder="Country">
                                <option>Canada</option>
                                <option>England</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="right-forms">
                    <div class="form-group">
                        <!-- <div id="lastname">
                            <label for="InputLastName">Last Name</label>
                            <input type="text" class="form-control" id="InputLastName" placeholder="Last named">
                        </div> -->
                        <div id="email">
                            <label for="InputEmail">Email address</label>
                            <input type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" placeholder="Email">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="password">
                            <label for="InputPassword">Password</label>
                            <input type="password" class="form-control" id="InputPassword" placeholder="Password">
                            <meter max="4" id="password-strength-meter"></meter>
                            <p id="password-strength-text"></p>
                        </div>
                        <div id="verify">
                            <label for="InputVerifyPassword">Verify Password</label>
                            <input type="password" class="form-control" id="InputVerifyPassword" placeholder="Re-enter Password">
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id="signup-button">Submit</button>
        </form>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
    <!--CDN Link for Password Strength Checker Tool-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js"></script>
    <script type="text/javascript" src="js/strength.js"></script>
</body>
<?php
if (isset($_POST['first_name'])) {
    $first_name = $_POST['first_name'];
    echo "First Name: " . $first_name . "<br>";
}
if (isset($_POST['lastname'])) {
    $last_name = $_POST['last_name'];
    echo "Last Name: " . $last_name . "<br>";
}

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    echo "Username: " . $username . "<br>";
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    echo "Email Address: " . $email . "<br>";
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
    echo "Password: " . $password . "<br>";
}
?>

</html>