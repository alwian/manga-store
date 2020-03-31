<?php
    include_once "config/Database.php";
    include_once "models/User.php";
    session_start();
    $db = new Database();
    $user = new User($db->connect());
    $user->user_id = $_SESSION['id'];
    $user->getUser();
    $user->applyToBeSeller();
    header("Location: index.php");