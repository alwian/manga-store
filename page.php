<!DOCTYPE html>
<html lang="en">

<?php
// link of the page
// /page.php/[somehashValue]
$acutal_link = $_SERVER['REQUEST_URI'];
// Split the string based on it
//output= [ "", "page.php", "hashValue"]
list($x, $src, $doc_id) = explode('/', $acutal_link);
$API_URL = "https://www.mangaeden.com/api/manga/{$doc_id}/";

// querying the JSON API for the document
// functionality for handling wrong ID
// @ sign ignores error messsages
$RESPONSE = @file_get_contents($API_URL);
if (!$RESPONSE) {
    // This is an invalid URL.. we will implement a redirect
    // to our 404 page.
    echo "404 This page doesnt exist";
    header('/404.php', true, 404);
    exit;
}
$RESPONSE = json_decode(@$RESPONSE);
$author = $RESPONSE->author;
?>

<head>
    <meta charset="UTF-8">
    <meta name="referrer" content="no-referrer" />
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $author ?></title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
</head>
<body>
<?php
// Valid Page with JSON
$categories = $RESPONSE->categories;
$description = $RESPONSE->description;
$image_bang_chk = $RESPONSE->image;
$IMG_CDN_URL = "https://cdn.mangaeden.com/mangasimg/{$image_bang_chk}";
echo $API_URL . '<br>';
echo $doc_id . '<br>';
echo 'Document Author: ' . $author . '<br><br>';
echo 'Manga Categories: ' . implode(" ", $categories) . '<br><br>';

// for loop for one item instancing..
foreach ($categories as $entry) {
    echo $entry . '<br>';
}
echo '<br>';
echo $description . '<br>';?>

<img src=<?php echo $IMG_CDN_URL ?> referrerpolicy='no-referrer'/></img>

</body>
</html>
