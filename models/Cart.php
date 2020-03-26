<?php
class Cart
{
    private $table = 'cart_items';
    private $conn;

    public $user_id;
    public $item_id;
    public $quantity;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addItem() {
        echo 'Not yet implemented.';
    }

    public function updateItem() {
        echo 'Not yet implemented.';
    }

    public function getItems() {
        echo 'Not yet implemented.';
    }

    private function deleteItem() {
        echo 'Not yet implemented.';
    }
}