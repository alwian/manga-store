
<?php
    include '../models/User.php';
    include_once '../config/Database.php';

    session_start();

    $db = new Database();
    $conn = $db->connect();
    $user = new User($conn);

    if(!isset($_SESSION['Logged']) || $_SESSION['Logged'] == false){
        http_response_code(403);
        header("Location: ../login.php");
        exit;
    } else {
        $user = new User($conn);
        $user->user_id = $_SESSION['id'];
        $user->getUser();
        if ($user->type !== 'admin') {
            http_response_code(403);
            echo 'You do not have permission to access this page.';
            exit;
        }
    }

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        http_response_code(400);
        echo 'ID is required.';
        exit;
    } else {
        $user->user_id = $_GET["id"];
        if ($user->existsById()) {
            $user->deleteUser();
            header("Location: accountManage.php");
            exit;
        } else {
            http_response_code(404);
            echo 'The specified user was not found.';
            exit;
        }
    }