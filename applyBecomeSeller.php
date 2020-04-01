<?php
include_once "config/Database.php";
include_once "models/User.php";
session_start();

// If the user is already logged in, take them to the homepage.
if (!isset($_SESSION['Logged']) || $_SESSION['Logged'] == false) {
    http_response_code(403);
    header("Location: login.php");
    exit;
} else {
    $user = new User($conn);
    $user->user_id = $_SESSION['id'];
    $user->getUser();
    if ($user->type !== 'consumer') {
        http_response_code(403);
        echo 'You do not have permission to access this page.';
        exit;
    }
}

$db = new Database();
$user = new User($db->connect());
$user->user_id = $_SESSION['id'];
$user->getUser();
$user->applyToBeSeller();
header("Location: index.php");
