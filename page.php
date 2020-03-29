<?php
session_start();
// link of the page
// /page.php/[somehashValue]
$actual_link = $_SERVER['REQUEST_URI'];
// Split the string based on it
//output= [ "", "page.php", "hashValue"]
list($src, $doc, $id) = explode('/', $actual_link);
$API_URL = "https://www.mangaeden.com/api/manga/{$id}/";

// querying the JSON API for the document
// functionality for handling wrong ID
// @ sign ignores error messsages
$RESPONSE = file_get_contents($API_URL);
if (!$RESPONSE) {
    // This is an invalid URL.. we will implement a redirect
    // to our 404 page.
    echo "404 This page doesnt exist";
    header('Location: 404.php', true, 404);
    exit;
}
$obj = json_decode($RESPONSE);
$author = $obj->author;
$title = $obj->title;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="referrer" content="no-referrer" />
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import bootstrap.css-->
    <link type="text/css" rel="stylesheet" href="/css/bootstrap.min.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="/css/style.css">
</head>
<body>

<?php
require "header.php";
$categories = $obj->categories;
$description = $obj->description;
$image_bang_chk = $obj->image;
$_SESSION['manga_name'] = $title;
?>
<div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?> </li>
            </ol>
        </nav>
<?php
// Valid Page with JSON

$IMG_CDN_URL = "https://cdn.mangaeden.com/mangasimg/{$image_bang_chk}";
echo "API URL: " . $API_URL . '<br><br>';
echo 'Document Author: ' . $author . '<br><br>';
echo 'Manga Categories: ' . implode(" ", $categories) . '<br><br>';

// for loop for one item instancing..
foreach ($categories as $entry) {
    echo $entry . '<br>';
}
echo '<br>';
echo $description . '<br>'; ?>

        <img src=<?php echo $IMG_CDN_URL ?> referrerpolicy='no-referrer'/></img>
        <?php
$chapters = $obj->chapters;

foreach (array_reverse($chapters) as $chapter) {
    $chapterNum = $chapter[0];
    $chapterDate = $chapter[1];
    $chapterTitle = $chapter[2];
    $chapterID = $chapter[3];

    echo "<br><button><a href='../chapter.php/{$chapterID}'>Chapter {$chapterTitle}</a></button>";
}
?>
    </div>

    <script type="text/javascript" src="/js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/script.js"></script>
</body>
</html>
