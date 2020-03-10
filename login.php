<?php
    include_once 'config/Database.php';
    include_once 'models/User.php';
    session_start();
    $errorMsg = null;


    //if user logged then bring user to homepage
    if($_SESSION['Logged'] == true){
        header("Location: index.php");
    }
    //Login
    //check if the the form been submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //check all the required information is been set and not empty
        if(isset($_POST['email']) && !empty($_POST['email'])
            && isset($_POST['password']) && !empty($_POST['password'])
            ){
            //connect to db
            $db = new Database();
            $user = new User($db->connect());
            //check if the email is exists
            $user->email = $_POST['email'];
            if($user->exists()!=null){
                //check if the password matches the database
                $user->password = $_POST['password'];
                //check the password from db
                if($user->checkLogin()){
                    $_SESSION['email'] = $user->email;
                    $_SESSION['Logged'] = true;
                    header("Location: index.php");
                }else{
                    $errorMsg = "Sorry, the login information is incorrect.";
                }

            }else{
                $errorMsg = "Sorry, the login information is incorrect.";
            }
        }else{
            $errorMsg = "Sorry, some of the field is still empty.";
        }
    }

?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga Store - Login</title>
    <!--Import materialize.css-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "header.php"; ?>

    <div class="page-container">
        <h2>Login</h2>

        <form class="forms" action="login.php" method="post">
            <div class="form-group">
                <label for="InputEmail">Email address</label>
                <input type="email" class="form-control" id="InputPassword" name="email" aria-describedby="emailHelp" placeholder="Email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="InputPassword">Password</label>
                <input type="password" class="form-control" id="InputPassword" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary" id="login-button">Submit</button>
            <p class="form-text text-muted"><?php echo$errorMsg ?></p>
        </form>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</body>

</html>