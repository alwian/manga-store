<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//echo file_exists('models/User.php');

include_once 'config/Database.php';
include_once 'models/User.php';

$db = new Database();
$conn = $db->connect();

$user = new User($conn);

$user->first_name = 'Alex';
$user->last_name = 'Anderson';
$user->email = 'jiashu@alwian.com';
$user->password = 'testpass';
$user->phone = '848483333300';
$user->image = 'picture.png';
$user->bio = 'I am alex';
$user->type = 'consumer';

//$new_id = $user->create();
//if ($new_id != null) {
//    echo 'Added -> ' . $new_id;
//} else {
//    echo 'Not added.';
//}

//echo "<br/><br/>";

//$user_exists = $user->exists();

//if ($user_exists != null) {
//    echo 'User exists.';
//} else {
//    echo 'user does not exists';
//}

//echo 'Exists? -> ' . $user_exists;

if ($user->checkLogin()) {
    echo 'Can login';
} else {
    echo 'Can\'t login.';
}

