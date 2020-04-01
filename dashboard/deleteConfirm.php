
<?php
    //include classes
    include '../models/User.php';
    include_once '../config/Database.php';
    //connect database
    $db = new Database();
    $user = new User($db->connect());
    //get the user ID from url parameter
    $user->user_id = $_GET["id"];
    //delete user
    $user->deleteUser();
    //go back to accountManage page
    header("Location: accountManage.php");
?>