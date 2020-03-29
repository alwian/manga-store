<!DOCTYPE html>
<html lang="en">
<?php
$acutal_link = $_SERVER['REQUEST_URI'];
list($src, $chap_id) = explode('/', $acutal_link);
// on dev, we dont even want to query the API, check parameters and authentication
$API_URL = "https://www.mangaeden.com/api/chapter/{$chap_id}";
$RESPONSE = @file_get_contents($API_URL);
if (!$RESPONSE) {
    echo "404, This page doesnt exist";
    header('/404.php', true, 404);
    exit;
}
$RESPONSE = json_decode(@$RESPONSE);
?>

<head>
    <meta charset="UTF-8">
    <meta name="referrer" content="no-referrer" />
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "PlaceHolder" ?></title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css" media="screen,projection" />
</head>
<body>

<?php
require "header.php";
echo $API_URL . "<br>";
$RESPONSE = array_reverse($RESPONSE->images);
?>
<h3>This is the document for a specific chapter of the book.</h3>
At this point, we would store the name of the book and other information in
the session so we dont have to query a DB for it.. we can also use it to check if
its not a brute force request so if session exists then load more else unauthorized
<br>

<?php
$IMG_CDN_URL = "https://cdn.mangaeden.com/mangasimg/";
foreach ($RESPONSE as $data) {
    $id = $data[0];
    $img_url = $data[1];
    $width = $data[2];
    $height = $data[3];
    $img_link = $IMG_CDN_URL . $img_url;
    // echo $img_link . "<br>";
    echo "<img src='{$img_link}' referrerpolicy='no-referrer' alt='{$id}' decoding='sync' height='{$height}' width='{$width}'/>";
}
?>
</body>