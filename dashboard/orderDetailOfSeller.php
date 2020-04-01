<?php
require_once "dashboard_header.php";
require_once "dashboard_sidebar.php";

//connect to db
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
                                <th>Item ID</th>
                                <th>Item Name</th>
                                <th>Price</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            //create a new order obj
                            $order = new Order($conn);
                            //create a new item obj
                            $item = new Item($conn);
                            //total is for calculate the total price
                            $total = 0;

                            //get the order id from url
                            if(isset($_GET["id"])){
                                //get order ID
                                $order->order_id = $_GET["id"];
                                //get all the item from the order id
                                $soldItems = $order->getSoldItems();

                                //for each item in the order
                                foreach ($soldItems as $i){
                                    //set the item it
                                    $item->item_id = $i['item_id'];
                                    //get the item information
                                    $item->getItem();
                                    //if item's seller id equals to seller then print all the item in this order
                                    if($item->seller_id == $_SESSION['id']){
                                        $quantity =  $i['quantity'];
                                        echo "<tr>";
                                        echo "<td>$item->item_id</td>";
                                        echo "<td>$item->name</td>";
                                        echo "<td>$item->price</td>";
                                        echo "<td>$quantity</td>";
                                        $total = $total + $item->price*$quantity;
                                    }

                                }
                            }

                            //print out the price
                            echo "<tr><td colspan='4' class='text-center'>Total: $total</td></tr>"
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


