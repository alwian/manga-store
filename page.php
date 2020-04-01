<!DOCTYPE html>
<html lang="en">
    <?php
        session_start();

        require 'config/Database.php';
        require 'models/User.php';
        require 'models/Item.php';

        $db = new Database();
        $conn = $db->connect();

        if (!isset($_GET['id']) || empty($_GET['id'])) {
            http_response_code(400);
            echo 'Item ID must be specified.';
            exit;
        }

        $item = new Item($conn);
        $item->item_id = $_GET['id'];

        if (!$item->getItem()) {
            http_response_code(404);
            echo 'Could not find the specified item.';
            exit;
        }

        $seller = new User($conn);
        $seller->user_id = $item->seller_id;
        $seller->getUser();
        
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="referrer" content="no-referrer" />
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $item->name;?></title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import bootstrap.css-->
        <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" media="screen,projection" />
        <link type="text/css" rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <?php
            require "header.php";

            $content = <<<EOD
            '<div class="item-container col-10 col-sm-10 col-" id="item-page">
                <div class="col-md-9 col-sm-12 col-" id="item-info">
                    <h2 id="page-title">{$item->name}</h2>
                    <h5 id="page-author">Author: <em>{$item->author}</em></h5>
                    </br>
                    <div id="item-details">
                        <div id="page-image" width="25%">
                            <img src="data/product-images/{$item->image}" referrerpolicy="no-referrer"/>
                        </div>
                        <div id="page-extras">
                            <h5>Number of Pages in Comic: <em>{$item->number_pages}</em></h5>
                            </br>
                            <h5>Sold by: <em>{$seller->first_name} {$seller->last_name}</em></h5>
                            <h5>Stock available: <em>{$item->stock}</em></h5>
                        </div>
                    </div>
                    </br>
                    <div id="page-description">
                        <h5>Description:</h5>
                        <p>{$item->description}</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12" id="item-purchase">
                    <h4><b>Purchase</b></h4>
                    </br>
                    <h5 id="price_label"><b>Price:</b></h5>
                    <h3 id="price_value">&#36;{$item->price}</h3>
                    </br>
EOD;
            if ($item->stock > 0) {
                $content .= "<form class=\"forms\" action=\"cart.php\" method=\"post\">
                        <label for=\"selectQuantity\">Quantity:</label>
                        <input type=\"number\" name=\"quantity\" id=\"selectQuantity\" value=\"1\"/>
                        <input type=\"hidden\" name=\"item_id\" value=\"{$_GET['id']}\"/>
                        <button class=\"btn btn-primary\" id=\"cart-btn\" type=\"submit\">Add to Cart</button>";
            }

            $content .= "</form></div></div>";
            echo $content;
        ?>

        <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
    </body>
</html>
