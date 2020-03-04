<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="referrer" content="no-referrer" />
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga Store</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" media="screen,projection" />
    
</head>

<body>
    <?php
        require "header.php";
        require "functions.php";
    ?>
    <div class="container">
        <h2>Index</h2>
        <div class="row">
            <div class="col s12 m4 l2">
                <?php populateView();?>
            </div>
        </div>

    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <!-- <script type="text/javascript" src="js/materialize.min.js"></script> -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</body>

</html>