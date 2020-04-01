<?php
require_once 'config/Database.php';
require_once 'models/User.php';
session_start();

// If the user is already logged in, take them to the homepage.
if (isset($_SESSION['Logged']) && $_SESSION['Logged'] == true) {
    http_response_code(403);
    header("Location: index.php");
    exit;
}

$errorMsg = null;

// Check if the the form been submitted.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check all the required information has been set and is not empty.
    if (
        isset($_POST['first_name']) && !empty($_POST['first_name'])
        && isset($_POST['last_name']) && !empty($_POST['last_name'])
        && isset($_POST['email']) && !empty($_POST['email'])
        && isset($_POST['password']) && !empty($_POST['password'])
        && isset($_POST['verify']) && !empty($_POST['verify'])
    ) {
        // Connect to db
        $db = new Database();
        $user = new User($db->connect());
        // Check if the email is already registered
        $user->email = $_POST['email'];
        if ($user->exists() == null) {
            // Check if the password and re-enter are the same.
            if ($_POST['password'] == $_POST['verify']) {
                // Set the user details.
                $user->first_name = $_POST['first_name'];
                $user->last_name = $_POST['last_name'];
                $user->password = $_POST['password'];
                $user->type = "consumer";
                // Create a new account
                if ($user->create() != null) {
                    $_SESSION['id'] = $user->user_id;
                    $_SESSION['userType'] = $user->type;
                    $_SESSION['user_first_name'] = $user->first_name;
                    $_SESSION['user_last_name'] = $user->last_name;
                    $_SESSION['Logged'] = true;
                    header("Location: index.php");
                } else {
                    http_response_code(500);
                    $errorMsg = "Something went wrong on our end.";
                }
            } else {
                http_response_code(400);
                $errorMsg = "Password and verify password do not match.";
            }
        } else {
            http_response_code(409);
            $errorMsg = "This email is already in use.";
        }
    } else {
        http_response_code(400);
        $errorMsg = "All fields required.";
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
    <?php require "header.php"; //load header at top of page 
    ?>

    <div class="page-container">
        <h2>Sign Up</h2>
        <!-- Form with POST request to submit details to create account-->
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
                            <input type="text" class="form-control" id="InputLastName" name="last_name" placeholder="Last name">
                        </div>
                    </div>
                </div>
                <div id="right-forms">
                    <div class="form-group">
                        <div id="email">
                            <label for="InputEmail">Email address</label>
                            <input type="email" class="form-control" id="InputEmail" name="email" aria-describedby="emailHelp" placeholder="Email">
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
            <!-- Submit details-->
            <button type="submit" class="btn btn-primary" id="signup-button">Submit</button>
            <p class="form-text text-danger"><?php echo $errorMsg; ?></p>
        </form>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!--CDN Link for Password Strength Checker Tool-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js"></script>
    <script type="text/javascript" src="js/strength.js"></script>
</body>

</html>