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
                                <th>Time</th>
                                <th>View</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $order = new Order($conn);

                            $orders=$order->getOrders();
                            $item = new Item($conn);

                            foreach ($orders as $o){
                                $order->order_id = $o['order_id'];
                                $order->getOrder();
                                $hasProduct = false;
                                $soldItems = $order->getSoldItems();
                                foreach ($soldItems as $i){
                                    $item->item_id = $i['item_id'];
                                    $item->getItem();
                                    if($item->seller_id ==  $_SESSION['id']){
                                        $hasProduct = true;
                                    }
                                }

                                if ($hasProduct){
                                    echo "<tr>";
                                    echo "<td>$order->order_id</td>";
                                    echo "<td>$order->order_time</td>";
                                    echo "<td><a href='orderDetailOfSeller.php?id=$order->order_id'><i class=\"fas fa - trash text - danger\"></i>View</a></td>";
                                    echo "</tr>";
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


