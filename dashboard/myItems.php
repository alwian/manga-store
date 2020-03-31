<?php
include "dashboard_header.php";
include "dashboard_sidebar.php";
require_once "../models/Item.php";


// If the user is already logged in, take them to the homepage.
if(!isset($_SESSION['Logged']) || $_SESSION['Logged'] == false){
    header("Location: index.php");
}

$db = new Database();
$conn = $db->connect();
$user = new User($conn);
$user->user_id = $_SESSION['id'];
?>
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
        <?php
        include "dashboard_topbar.php";
        ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Manage Items</h1>
            </div>

            <table class="table">
                <thead class="thead-light">
                <tr>
                    <th scope="col">ID#</th>
                    <th scope="col">Name</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $totalSum = 0;
                $count = 0;
                $items = $user->getItems();
                if ($items !== null) {
                    foreach ($items as $current_item) {
                        $item = new Item($conn);
                        $item->item_id = $current_item['item_id'];
                        if ($item->getItem()) {
                            echo "<tr>
                              <td>$item->item_id</td>
                              <td>$item->name</td>
                              <td><a href='ItemManage.php?id=$item->item_id'><span class='material-icons bg-white text-info'>Edit</span></a></td>
                              <td><a href='deleteItemFromCart.php?id=$item->item_id'><span class='material-icons bg-white text-danger'>delete</span></a></td>
                            </tr>";
                        } else {
                            echo 'Item unavailable.';
                        }
                    }
                }
                ?>
                </tbody>
            </table>
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





