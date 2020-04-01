<?php
    //include all the class
    session_start();
    require_once "../config/Database.php";
    require_once "../models/User.php";
    require_once "../models/Order.php";
    require_once "../models/Item.php";

    $db = new Database();
    $conn = $db->connect();

    if(!isset($_SESSION['Logged']) || $_SESSION['Logged'] == false){
        http_response_code(403);
        header("Location: ../login.php");
        exit;
    } else {
        $user = new User($conn);
        $user->user_id = $_SESSION['id'];
        $user->getUser();
        if ($user->type !== 'admin' && $user->type !== 'seller') {
            http_response_code(403);
            echo 'You do not have permission to access this page.';
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

    <!-- the title of the header-->
  <title>Manga - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">


</head>
<!--The start of every page in dashboard -->
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">