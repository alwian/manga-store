<?php
include_once 'config/Database.php';
include_once 'models/User.php';

//register
if(isset($_POST['first_name']) && isset($_POST['lastname']) && isset($_POST['email'])
    && isset($_POST['password']) && isset($_POST['verify'])){
    //connect to db
    $db = new Database();
    $user = new User($db->connect());
    //check if the email is already registered
    $user->email = $_POST['email'];
    if($user->exists()==null){
        //check if the password and re-enter are the same
        if($_POST['password'] == $_POST['verify']){
            //put the variables
            $user->first_name = $_POST['first_name'];
            $user->last_name = $_POST['lastname'];
            $user->password = $_POST['password'];
            $user->type = "consumer";

            //create a account
            $user->create();

        }

    }


}

?>
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

        <form class="forms" action="signup.php" method="post">
            <div id="form-inputs">
                <div id="left-forms">
                    <div class="form-group">
                        <div id="firstname">
                            <label for="InputFirstName">First Name</label>
                            <input type="text" class="form-control" id="InputFirstName" name="first_name" placeholder="First name">
                        </div>
                        <div id="lastname">
                            <label for="InputLastName">Last Name</label>
                            <input type="text" class="form-control" id="InputLastName" name="lastname" placeholder="Last name">
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="address">
                            <label for="InputAddress">Address</label>
                            <input type="text" class="form-control" id="InputAddress" name="address" placeholder="Address">
                        </div>
                        <div id="country">
                            <label for="SelectCountry">Country</label>
                            <select type="dropdown" class="form-control" id="SelectCountry" name="country" placeholder="Country">
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
                            <input type="email" class="form-control" id="InputPassword" name="email" aria-describedby="emailHelp" placeholder="Email">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="password">
                            <label for="InputPassword">Password</label>
                            <input type="password" class="form-control" id="InputPassword" name="password" placeholder="Password">
                            <meter max="4" id="password-strength-meter"></meter>
                            <p id="password-strength-text"></p>
                        </div>
                        <div id="verify">
                            <label for="InputVerifyPassword">Verify Password</label>
                            <input type="password" class="form-control" id="InputVerifyPassword" name="verify" placeholder="Re-enter Password">
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

</html>