<?php
require_once 'config/Database.php';
require_once 'models/User.php';

session_set_cookie_params("Session", "/", null, true, true);
session_name("MANGALOGIN");
session_start();

// If the user is already logged in, take them to the homepage.
if (isset($_SESSION['Logged']) && $_SESSION['Logged'] == true) {
    http_response_code(401); // Unauthorized.
    header("Location: index.php");
    exit;
}

$verify_value = null;

$email_error = null;
$password_error = null;


$form_submitted = $_SERVER["REQUEST_METHOD"] == "POST";
$db = new Database();
$user = new User($db->connect());

if ($form_submitted) {
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $email_error = "Required.";
        http_response_code(400);
    } else {
        $user->email = $_POST['email'];
    }

    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $password_error = "Required.";
        http_response_code(400);
    } else {
        $user->password = $_POST['password'];
    }

    if ($email_error == null && $password_error == null) {
        if ($user->checkLogin()) {
            $user->getUser();
            $_SESSION['id'] = $user->user_id;
            $_SESSION['Logged'] = true;
            header("Location: index.php");
        } else {
            $email_error = "Email or Password is incorrect.";
            $password_error = "Email or Password is incorrect.";
            http_response_code(401);
        }
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
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" media="screen"/>
    <link type="text/css" rel="stylesheet" href="css/style.css">
</head>

<body>
<?php require "header.php"; ?>

<div class="page-container">
    <h2>Login</h2>

    <form class="forms" action="login.php" method="post">
        <div class="form-group form-login">
            <label for="InputEmail">Email address</label>
            <input type="email" class="form-control <?php if ($form_submitted) echo $email_error != null ? 'is-invalid' : 'is-valid'?>" id="InputEmail" name="email" aria-describedby="emailHelp"
                   placeholder="Email" value="<?php echo $user->email;?>" required>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            <div class="invalid-feedback">
                <?php echo $email_error?>
            </div>
        </div>
        <div class="form-group form-login">
            <label for="InputPassword">Password</label>
            <input type="password" class="form-control <?php if ($form_submitted) echo $password_error != null ? 'is-invalid' : 'is-valid'?>" id="InputPassword" name="password" placeholder="Password"  value="<?php echo $user->password;?>" required>
            <div class="invalid-feedback">
                <?php echo $password_error?>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" id="login-button">Submit</button>
    </form>
</div>

<!--JavaScript at end of body for optimized loading-->
<script type="text/javascript" src="js/jquery-3.4.1.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>

</html>