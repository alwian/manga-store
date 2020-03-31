<?php
include "dashboard_header.php";
include "dashboard_sidebar.php";
require_once "../models/Item.php";
require_once "../models/User.php";

$db = new Database();
$conn = $db->connect();
$user = new User($conn);
$user->user_id = $_SESSION['id'];

// If the user is already logged in, take them to the homepage.
if(!isset($_SESSION['Logged']) || $_SESSION['Logged'] == false) {
    header("Location: ../login.php");
} else {
    $user->getUser();
    if ($user->type !== 'seller') {
        echo 'You must be a seller to access this page.';
        exit;
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['itemId']) && !empty($_GET['itemId'])) {
                $id = $_GET['itemId'];
            } else {
                echo 'Item id is required.';
                exit;
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['itemId']) && !empty($_POST['itemId'])) {
                $id = $_POST['itemId'];
            } else {
                echo 'Item id is required.';
                exit;
            }
        } else {
            echo 'Invalid Request method.';
        }

        $item = new Item($conn);
        $item->item_id = $id;
        if ($item->exists()) {
            $item->getItem();
            if (!($item->seller_id === $_SESSION['id'])) {
                echo "You do not own this item.";
                exit;
            }
        } else {
            echo 'Item does not exist.';
            exit;
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['itemName']) && isset($_POST['itemAuthor']) && isset($_POST['itemPages']) && isset($_POST['itemPrice']) && isset($_POST['itemStock']) && isset($_POST['itemDescription']) &&
                !empty($_POST['itemName']) && !empty($_POST['itemAuthor']) && !empty($_POST['itemPages']) && !empty($_POST['itemPrice']) && !empty($_POST['itemStock']) && !empty($_POST['itemDescription'])) {
                $item->name = $_POST['itemName'];
                $item->author = $_POST['itemAuthor'];
                $item->price = $_POST['itemPrice'];
                $item->stock = $_POST['itemStock'];
                $item->description = $_POST['itemDescription'];
                $item->number_pages = $_POST['itemPages'];


                $upload_successful = true;
                $file_uploaded = false;
                if (isset($_FILES['itemImage']['name']) && !empty($_FILES['itemImage']['name'])) {
                    if (!($_FILES['itemImage']['name'] === $item->image)) {
                        $file_uploaded = true;
                        if (file_exists($_FILES['itemImage']['tmp_name']) && is_uploaded_file($_FILES['itemImage']['tmp_name'])) {
                            $item->author = $_POST['itemAuthor'];
                            $item->price = $_POST['itemPrice'];
                            $item->stock = $_POST['itemStock'];
                            $item->description = $_POST['itemDescription'];
                            $item->number_pages = $_POST['itemPages'];

                            $target_dir = "../data/product-images/";
                            $target_file = $target_dir . basename($_FILES["itemImage"]["name"]);
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                            $check = getimagesize($_FILES["itemImage"]["tmp_name"]);
                            if ($check !== false) {
                                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                                    $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                    $upload_successful = false;
                                } else if (strlen($_FILES['itemImage']['name']) <= 120) {
                                    if (!move_uploaded_file($_FILES["itemImage"]["tmp_name"], $target_file)) {
                                        $error = "Sorry, there was an error uploading your file.";
                                        $upload_successful = false;
                                    }
                                } else {
                                    $error = "File name is too long.";
                                    $upload_successful = false;
                                }
                            } else {
                                $error = "File is not an image.";
                                $upload_successful = false;
                            }
                        } else {
                            $error = "Files is too big.";
                            $upload_successful = false;
                        }

                    }
                }

                if ($file_uploaded) {
                    if ($upload_successful) {
                        $old_file = $item->image;
                        $item->image = $_FILES['itemImage']['name'];
                        $success = $item->update();
                        if ($success != null) {
                            unlink("../data/product-images/" . $old_file);
                            header("Location: ../page.php?id=$item->item_id");
                            exit;
                        } else {
                            unlink($target_file);
                            $item->image = $old_file;
                            $error = "There was an error updating the item.";
                        }
                    }
                } else {
                    $success = $item->update();
                    if ($success != null) {
                        header("Location: ../page.php?id=$item->item_id");
                        exit;
                    } else {
                        $error = "There was an error updating the item.";
                    }
                }
            }
        }
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
                <h1 class="h3 mb-0 text-gray-800">Update Item</h1>
            </div>

            <form action="itemManage.php" method="post" enctype="multipart/form-data">
                <input type="hidden" value="<?php echo $item->item_id;?>" name="itemId" />
                <div class="form-group">
                    <label for="itemName">Item Name</label>
                    <input class="form-control" type="text" id="itemName" name="itemName" value="<?php echo $item->name;?>" required/>
                </div>
                <div class="form-group">
                    <label for="itemAuthor">Author</label>
                    <input class="form-control" type="text" id="itemAuthor" name="itemAuthor" value="<?php echo $item->author;?>" required/>
                </div>
                <div class="form-group">
                    <label for="itemPages">Number of pages</label>
                    <input class="form-control" type="text" id="itemPages" name="itemPages" value="<?php echo $item->number_pages;?>" required/>
                </div>
                <div class="form-group">
                    <label for="itemPrice">Price</label>
                    <input class="form-control" type="number" id="itemPrice" name="itemPrice" value="<?php echo $item->price;?>" required/>
                </div>
                <div class="form-group">
                    <label for="itemStock">Stock</label>
                    <input class="form-control" type="number" id="itemStock"  name="itemStock" value="<?php echo $item->stock;?>" required/>
                </div>
                <div class="form-group">
                    <label for="itemImage">Image</label>
                    <input class="form-control" type="file" id="itemImage" name="itemImage"/>
                </div>
                <div class="form-group">
                    <label for="itemDescription">Description</label>
                    <textarea class="form-control" id="itemDescription" name="itemDescription" required><?php echo $item->description;?></textarea>
                </div>
                <button class="btn btn-primary" type="submit">Update</button>
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