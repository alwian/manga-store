<?php
include_once 'config/Database.php';
include_once 'models/Cart.php';

$db = new Database();
$conn = $db->connect();

$cart = new Cart($conn); // Create new cart.

$cart->user_id = 11; // Set the user the cart belongs to. (make sure it is in your local db)
$cart->item_id = 1; // Set the Id of the item to modify in the cart. (make sure it is in your local db)
$cart->quantity = 7; // Set new quantity of the item.
$cart->update(); // Update the db with new details.

echo $cart->getItems(); // Get items for the user.

$cart->quantity = 4; // Change the item quantity.
$cart->update(); // Update the db with new details.

echo "<br/>";
echo $cart->getItems(); // Get items for the user.

$cart->quantity = 0; // Change quantity of the item.
$cart->update(); // Update the db, quantity is 0 so item is removed from the users cart.

echo "<br/>";
echo $cart->getItems(); // Get items for the user.

