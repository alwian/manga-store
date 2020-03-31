<?php
class Order
{
    private $table = 'orders';
    private $conn;

    public $order_id;
    public $order_time;
    public $user_id;
    public $item_id;


    function __construct($conn)
    {
        $this->conn = $conn;
    }



    /**
     * This function is get all orders from 'orders' table
     *
     * @return bool|null Whether the order details are correct, an error occurred during database interaction.
     */
    public function getOrders(){
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return null;
        }
    }


    /**
     * This function is get a order from 'orders' table with a specific order number
     *
     * @return bool|null Whether the order details are correct, an error occurred during database interaction.
     */
    public function getOrder(){
        $query = "SELECT * FROM $this->table WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $this->order_id);
        try {
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $stmt->bindColumn('user_id', $this->user_id);
                $stmt->bindColumn('order_time', $this->order_time);
                $stmt->fetch(PDO::FETCH_BOUND);
                return false;
            }
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return null;
        }
    }


    /**
     * This function is for get the Item_ID from Order_ID in 'sold_items' table
     * @return bool|null Whether the order details were found, an error occurred during database interaction.
     */
    public function getSoldItem(){
        $query = "SELECT item_id,order_id,quantity FROM sold_items WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $this->order_id);
        try {
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $stmt->bindColumn('item_id', $this->item_id);
                $stmt->bindColumn('quantity', $this->quantity);
                $stmt->fetch(PDO::FETCH_BOUND);
                return false;
            }
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return null;
        }
    }


    /**
     * This function is for delete a order from order id in 'orders table'
     * @return bool|null Whether the order details were found, an error occurred during database interaction.
     */
    public function deleteOrder(){
        $query = "DELETE FROM sold_items WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_id", $this->order_id);
        try {
            $stmt->execute();
            $query = "DELETE FROM orders WHERE order_id = :order_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":order_id", $this->order_id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}