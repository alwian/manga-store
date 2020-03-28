<?php
    include "dashboard_header.php";
    include "dashboard_sidebar.php";
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
                        <h1 class="h3 mb-0 text-gray-800">Quick Buttons</h1>
                    </div>

                    <!-- Row Heading -->
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        <h5>User Management</h5>
                    </div>
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Account Management -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <a href="accountManage.php">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Account Management</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fas fa-user-cog text-primary fa-3x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>
                        </div>

                        <!--Create Account -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Create Account</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fas fa-user-plus text-primary fa-3x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                        <!-- Content Row -->
                        <div class="row">

                        <!--Delete Account -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Delete Account</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-minus text-primary fa-3x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Change Account Role -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Search User</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-search text-primary fa-3x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Content Row -->
                    <br><br>





                    <!-- Row Heading -->
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        <h5>Store Management</h5>
                    </div>
                    <h6>Sellers:</h6>
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Seller Management -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Seller Management</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-store-alt text-primary fa-3x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Seller Apply List -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Seller Apply List</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-list text-primary fa-3x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->


                    <h6>Orders:</h6>
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Order Display -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Order Display</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-window-restore text-primary fa-3x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Search For Order -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Search Order</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-search text-primary fa-3x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- Content Row -->

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





