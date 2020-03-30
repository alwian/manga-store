<!DOCTYPE html>
<html lang="en">

<?php
session_start();
// If the user is already logged in, take them to the homepage.
if(!isset($_SESSION['Logged']) || $_SESSION['Logged'] == false){
    header("Location: login.php");
}

// get book ID
$id = $_GET["id"];
$API_URL = "https://www.mangaeden.com/api/manga/{$id}/";

// querying the JSON API for the document
// functionality for handling wrong ID
// @ sign ignores error messages
$RESPONSE = file_get_contents($API_URL);
if (!$RESPONSE) {
    // This is an invalid URL.. we will implement a redirect
    // to our 404 page.
    echo "404 This page doesnt exist";
    header('/404.php', true, 404);
    exit;
}
$obj = json_decode($RESPONSE);
?>

<head>
    <meta charset="UTF-8">
    <meta name="referrer" content="no-referrer" />
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $obj->title ?></title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import bootstrap.css-->
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        require "header.php";
    
        // Valid Page with JSON
        $categories = $obj->categories;
        $description = $obj->description;
        $image_bang_chk = $obj->image;
        $IMG_CDN_URL = "https://cdn.mangaeden.com/mangasimg/{$image_bang_chk}";
    
        echo '<h2>' . $obj->title .'</h2>' . '<br>';
        echo 'Manga Categories: ' . implode(" ", $categories) . '<br><br>';

        // for loop for one item instancing..
        foreach ($categories as $entry) {
            echo $entry . ',';
        }
        echo '<br>';
        echo $description . '<br>'; 
    ?>
    <img src=<?php echo $IMG_CDN_URL ?> referrerpolicy='no-referrer'/></img>

    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
