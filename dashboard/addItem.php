<?php
include "dashboard_header.php";
include "dashboard_sidebar.php";
require_once "../models/Item.php";

$error = '';

$user = new User($conn);
$user->user_id = $_SESSION['id'];
$user->getUser();
if ($user->type !== 'seller') {
    http_response_code(403);
    echo 'You do not have permission to access this page.';
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['itemName']) && isset($_POST['itemAuthor']) && isset($_POST['itemPages']) && isset($_POST['itemPrice']) && isset($_POST['itemStock']) && isset($_POST['itemDescription']) &&
        !empty($_POST['itemName']) && !empty($_POST['itemAuthor']) && !empty($_POST['itemPages']) && !empty($_POST['itemPrice']) && !empty($_POST['itemStock']) && !empty($_POST['itemDescription'])
    ) {
        $item = new Item($conn);
        $item->seller_id = $_SESSION['id'];
        $item->name = $_POST['itemName'];

        if (file_exists($_FILES['itemImage']['tmp_name']) && is_uploaded_file($_FILES['itemImage']['tmp_name'])) {
            if (!$item->exists()) {
                $item->author = $_POST['itemAuthor'];
                $item->price = $_POST['itemPrice'];
                $item->stock = $_POST['itemStock'];
                $item->description = $_POST['itemDescription'];
                $item->number_pages = $_POST['itemPages'];

                $target_dir = "../data/product-images/";
                $unique_filename = uniqid('uploaded-', true)
                    . '.' . strtolower(pathinfo($_FILES['itemImage']['name'], PATHINFO_EXTENSION));
                $target_file = $target_dir . $unique_filename;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $check = getimagesize($_FILES["itemImage"]["tmp_name"]);
                if ($check !== false) {
                    $error = 'Image is too big';
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                        $error = "Sorry, only JPG, JPEG & PNG files are allowed.";
                    } else {
                        if (move_uploaded_file($_FILES["itemImage"]["tmp_name"], $target_file)) {
                            $item->image = $unique_filename;
                            $item_id = $item->addItem();
                            if ($item_id !== null) {
                                header("Location: ../page.php?id=$item_id");
                            } else {
                                unlink($target_file);
                                $error = "There was an error adding the item.";
                            }
                        } else {
                            $error = "Sorry, there was an error uploading your file.";
                        }
                    }
                } else {
                    $error = "File is not an image.";
                }
            } else {
                $error = 'Item name already exists.';
            }
        } else {
            $error = 'Image is too big';
        }
    } else {
        $error = "All fields not filled.";
    }
}
?>
<!-- Content Wrapper -->
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
                <h1 class="h3 mb-0 text-gray-800">Add Item</h1>
            </div>

            <form action="addItem.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="itemName">Item Name</label>
                    <input class="form-control" type="text" id="itemName" name="itemName" required />
                </div>
                <div class="form-group">
                    <label for="itemAuthor">Author</label>
                    <input class="form-control" type="text" id="itemAuthor" name="itemAuthor" required />
                </div>
                <div class="form-group">
                    <label for="itemPages">Number of pages</label>
                    <input class="form-control" type="text" id="itemPages" name="itemPages" required />
                </div>
                <div class="form-group">
                    <label for="itemPrice">Price</label>
                    <input class="form-control" type="number" id="itemPrice" name="itemPrice" required />
                </div>
                <div class="form-group">
                    <label for="itemStock">Stock</label>
                    <input class="form-control" type="number" id="itemStock" name="itemStock" required />
                </div>
                <div class="form-group">
                    <label for="itemImage">Image</label>
                    <input class="form-control" type="file" id="itemImage" name="itemImage" required />
                </div>
                <div class="form-group">
                    <label for="itemDescription">Description</label>
                    <textarea class="form-control" id="itemDescription" name="itemDescription" required></textarea>
                </div>
                <button class="btn btn-primary" type="submit">Submit</button>
                <?php echo "<p class='text-danger'>$error</p>" ?>
            </form>

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