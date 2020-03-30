<?php
    include_once "config/Database.php";
    include_once "models/User.php";

    $db = new Database();
    $user = new User($db->connect());
    $user->user_id = $_SESSION['id'];
    $user->getUser();
?>