<?php
    session_start();

    // If the user is already logged in, take them to the homepage.
    if(!isset($_SESSION['Logged']) || $_SESSION['Logged'] == false){
        header("Location: index.php");
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

<h1 class="text-center">Thank you for your purchase. We have received your order.</h1><br><br>

</body>
</html>
