
<?php
    include '../models/User.php';
    include_once '../config/Database.php';
    $db = new Database();
    $user = new User($db->connect());
    $user->user_id = $_GET["id"];
    $user->deleteUser();
    header("Location: accountManage.php");
?>