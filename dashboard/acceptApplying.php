<?php
require_once "dashboard_header.php";
require_once "dashboard_sidebar.php";

$user = new User($conn);
$user->user_id = $_SESSION['id'];
$user->getUser();
if ($user->type !== 'admin') {
    http_response_code(403);
    echo 'You do not have permission to access this page.';
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_GET["id"]) || !isset($_GET["type"]) || empty($_GET['id']) || empty($_GET['type'])) {
        http_response_code(200);
        echo 'ID and type are required.';
        exit;
    } else {
        if($_GET["type"] == 'delete'){
            $user = new User($conn);
            $user->user_id = $_GET["id"];
            $user->deleteUserFromSellerApllyList();
            header("Location: acceptApplying.php");
        }else {
            $user = new User($conn);
            $user->user_id = $_GET["id"];
            $user->type = "seller";
            $user->changeUserRole();
            $user->deleteUserFromSellerApllyList();
            header("Location: acceptApplying.php");
        }
    }
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
            <h1 class="h3 mb-2 text-gray-800">Apply To Be Seller List</h1>
            <p></p>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">Apply To Be Seller List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Email Address</th>
                                <th>Name</th>
                                <th>User Role</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $user = new User($conn);
                            $users = $user->displayAppliedUser();
                            foreach ($users as $u) {
                                $user->user_id = $u['user_id'];
                                $user->getUser();
                                echo "<tr>
                                <td>$user->user_id</td>
         
                                <td>$user->email</td>
                                <td>$user->first_name&nbsp;$user->last_name</td>
                                <td>$user->type &nbsp;&nbsp;&nbsp;
                                <a href='acceptApplying.php?id=$user->user_id&type=accept'><i class=\"fas fa-edit text-primary\"></i>Accept&nbsp;&nbsp&nbsp;&nbsp</a>
                                <a href='acceptApplying.php?id=$user->user_id&type=delete'><i class=\"fas fa-trash text-danger\"></i>Delete</a>
                                </td>
                      </tr>
                      ";
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





