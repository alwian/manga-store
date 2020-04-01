<?php
require_once "dashboard_header.php";
require_once "dashboard_sidebar.php";

$db = new Database();
$conn = $db->connect();
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
            <h1 class="h3 mb-2 text-gray-800">Order Detail</h1>
            <p></p>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">Order Detail</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Items</th>
                                <th>Price</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $order = new Order($conn);
                            $item = new Item($conn);
                            $total = 0;

                            if(isset($_GET["id"])){
                                 $order->order_id = $_GET["id"];
                                 $soldItems = $order->getSoldItems();

                                foreach ($soldItems as $i){
                                    $item->item_id = $i['item_id'];
                                    $quantity =  $i['quantity'];
                                    $item->getItem();
                                    echo "<tr>";
                                    echo "<td>$order->order_id</td>";
                                    echo "<td>$item->item_id</td>";
                                    echo "<td>$item->price</td>";
                                    echo "<td>$quantity</td>";
                                    $total = $total + $item->price*$quantity;
                                }
                            }

                            echo "<tr><td colspan='4' class='text-center'>Total: $total</td>></tr>"
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


