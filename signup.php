<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp Page</title>
    <!--Import materialize.css-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
</head>

<body>
    <?php require "header.php";?>

    <div class="container">
        <h2>Register</h2>

        <form class="col s12" method="POST" action="registered.php">
            <div class="row">
                <div class="input-field col s6">
                    <input placeholder="First Name" id="first_name" type="text" class="validate" name="first_name">
                    <label for="first_name">First Name</label>
                </div>

                <div class="input-field col s6">
                    <input placeholder="Last Name" id="last_name" type="text" name="last_name" class="validate">
                    <label for="last_name">Last Name</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s6">
                    <input id="username" type="text" name="username" class="validate">
                    <label for="username">Username</label>
                </div>
                <div class="input-field col s6">
                    <input id="email" type="email" name="email" class="validate">
                    <label for="email">Email</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" type="password" name="password" class="validate">
                    <label for="password">Password</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="repeat_password" type="password" class="validate">
                    <label for="repeat_password">Repeat Password</label>
                </div>
            </div>

            <button class="btn waves-effect waves-light right" type="submit" name="action">
                Submit
                <i class="material-icons right">send</i>
            </button>
            <span>

            </span>
        </form>
    </div>



    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
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