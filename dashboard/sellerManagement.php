<?php
require_once "dashboard_header.php";
require_once "dashboard_sidebar.php";

$db = new Database();
$conn = $db->connect();
if(isset($_GET["id"])) {
    $user = new User($db->connect());
    $user->user_id = $_GET["id"];
    $user->type = "consumer";
    $user->changeUserRole();
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
            <h1 class="h3 mb-2 text-gray-800">Sellers Table</h1>
            <p></p>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">Sellers Table</h6>
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
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $user = new User($conn);
                            $users = $user->getUsers();

                            foreach ($users as $u) {
                                $user->user_id = $u['user_id'];


                                $user->getUser();
                                if($user->type == "seller"){
                                    echo "<tr>
                                <td>$user->user_id</td>
           
                                <td>$user->email</td>
                                <td>$user->first_name&nbsp;$user->last_name</td>
                                <td>$user->type &nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <a href='sellerManagement.php?id=$user->user_id'><i class=\"fas fa-edit text-primary\"></i>Change To Consumer&nbsp;&nbsp&nbsp;&nbsp</a>
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





