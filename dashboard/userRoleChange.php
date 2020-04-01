<?php
require_once "dashboard_header.php";

if ($user->type !== 'admin') {
    http_response_code(403);
    echo 'You do not have permission to access this page.';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["userRole"]) && !empty($_POST["userRole"]) && isset($_POST['userID']) && !empty($_POST['userID'])) {
        $user = new User($conn);
        $user->user_id = $_POST["userID"];
        if ($user->existsById()) {
            if ($_POST['userRole'] !== 'consumer' && $_POST['userRole'] !== 'seller' && $_POST['userRole'] !== 'admin') {
                http_response_code(422);
                echo 'User role is invalid.';
                exit;
            } else {
                $user->type = $_POST["userRole"];
                $user->changeUserRole();
                header("Location: accountManage.php");
                exit;
            }
        } else {
            http_response_code(404);
            echo 'The specified user does not exist';
            exit;
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        http_response_code(400);
        echo 'id is required.';
        exit;
    }
}

require_once "dashboard_sidebar.php";


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
            <h1 class="h3 mb-2 text-gray-800">Change User Role</h1>
            <p></p>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">Accounts Table</h6>
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
                            //create a new user obj
                            $user = new User($conn);
                            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                                $user->user_id = $_POST["userID"];
                            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                                $user->user_id = $_GET["id"];
                            }

                            //get user information and print
                            $user->getUser();
                                echo "<tr>
                                <td>$user->user_id</td>                               
                                <td>$user->email</td>
                                <td>$user->first_name&nbsp;$user->last_name</td>
                                     <td>
                                         <form action='userRoleChange.php' method='post'>
                                               <input type='hidden' value='$user->user_id' name='userID'/>
                                               <div class=\"input-group\">
                                                  <select name='userRole' class=\"custom-select\" id=\"inputGroupSelect04\" aria-label=\"Example select with button addon\">
                                                    <option value=$user->type selected>Select A Role($user->type)</option>
                                                    <option value=\"consumer\">Consumer</option>
                                                    <option value=\"seller\">Seller</option>
                                                    <option value=\"admin\">Admin</option>
                                                  </select>
                                                  <div class=\"input-group-append\">
                                                    <button type='submit' class=\"btn btn-outline-secondary\" type=\"button\">Submit</button>
                                                  </div>
                                                </div> 
                                          </form>
                                     </td>
                      </tr>
                      ";

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





