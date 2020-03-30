<?php
session_start();
include 'config/Database.php';
include 'models/Book.php';
$value = $_POST['search'];
$mysql = new Database();
$conn = $mysql->connect();
$query = "SELECT * from `search_table` where UPPER(title) like UPPER(:title) ";
?>
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
    <link type="text/css" rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "header.php"; ?>
    <div class="container">
        <form class="input-group flex-nowrap pt-3" action="search.php" method="POST">
            <input type="text"
                class="form-control"
                value="<?php echo $value; ?>"
                name="search">
                <span>
                <svg id="search-img" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                    <path d="M0 0h24v24H0V0z" fill="none" />
                    <path
                        d="M15.5 14h-.79l-.28-.27c1.2-1.4 1.82-3.31 1.48-5.34-.47-2.78-2.79-5-5.59-5.34-4.23-.52-7.79 3.04-7.27 7.27.34 2.8 2.56 5.12 5.34 5.59 2.03.34 3.94-.28 5.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0 .41-.41.41-1.08 0-1.49L15.5 14zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                </svg>
            </span>
        </form>
        <div class="items">

        <?php
$statement = $conn->prepare($query);
$statement->bindValue(":title", "%{$value}%");
$statement->execute();
$result = $statement->fetchAll();
foreach ($result as $row) {
    $bk = new Book();
    $bk->db_construct($row);
    $bk->displayCard();
}

?>
</div>
    </div>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</body>

</html>