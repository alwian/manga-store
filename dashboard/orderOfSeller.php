<?php
require_once "dashboard_header.php";
require_once "dashboard_sidebar.php";

$db = new Database();
$conn = $db->connect();
if(isset($_GET["id"])) {
    $order = new Order($db->connect());
    $order->order_id = $_GET["id"];
    $order->deleteOrder();
    header("Location: displayAllOrders.php");
}
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
        <?php
        require_once "dashboard_topbar.php";
        ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Order List</h1>
            <p></p>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">Order List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Items</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Author</th>
                                <th>Buyer</th>
                                <th>Time</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sellerID =  $_SESSION['id'];
                            $order = new Order($conn);
                            $orders = $order->getOrders();
                            foreach ($orders as $o) {
                                $order->order_id = $o['order_id'];
                                $order->getOrder();
                                $order->getSoldItem();

                                $item = new Item($conn);
                                $item->item_id = $order->item_id;
                                $item->getItem();
                                $user = new User($conn);
                                $user->user_id = $order->user_id;
                                $user->getUser();
                                $totalPrice = $item->price*$order->quantity;
                                if($item->seller_id == $sellerID ){
                                    echo "<tr>
                                    <td>$order->order_id</td>
                                    <td>$item->name</td>
                                    <td>$order->quantity</td>
                                    <td>$totalPrice</td>
                                    <td>$item->author</td>
                                    <td>$user->first_name $user->last_name</td>
                                    <td>$order->order_time</td>
                                    <td>
                                        <a href='displayAllOrders.php?id=$order->order_id'><i class=\"fas fa-trash text-danger\"></i>Delete</a>
                                    </td>
                                    
                      </tr>
                      ";
                                }

                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

</div>
<!-- End of Page Wrapper -->
<?php
include "dashboard_logoutModal.php";
include "dashboard_footer.php";
?>


