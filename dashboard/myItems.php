<?php
include "dashboard_header.php";
include "dashboard_sidebar.php";
require_once "../models/User.php";
require_once "../models/Item.php";

$user = new User($conn);
$user->user_id = $_SESSION['id'];

$user->getUser();
if ($user->type !== 'seller') {
    http_response_code(403);
    echo 'You must be a seller to access this page.';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['operation']) && $_POST['operation'] === 'Delete' && isset($_POST['itemId']) && !empty($_POST['itemId']))  {
        $item = new Item($conn);
        $item->item_id = $_POST['itemId'];
        $item->getItem();
        if ($item->seller_id === $_SESSION['id']) {
            if ($item->deleteItem() === null) {
                http_response_code(304);
                echo 'There was a problem deleting the item.';
                exit;
            } else {
                unlink("../data/product-images/$item->image");
            }
        } else {
            http_response_code(403);
            echo 'You do not own this item.';
            exit;
        }
    }
}

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
                            echo "<tr xmlns=\"http://www.w3.org/1999/html\">
                              <td>$item->item_id</td>
                              <td>$item->name</td>
                              <td><a href='ItemManage.php?itemId=$item->item_id'><span class='material-icons text-info'>Edit</span></a></td>
                              <form action='myItems.php' method='post'>
                                <input type='hidden' value='$item->item_id' name='itemId' />
                                <td><input class='material-icons text-danger' style=\"background:none; border-width:0;\" type='submit' value='Delete' name='operation'/></td>
                              </form>
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





