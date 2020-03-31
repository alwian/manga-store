<!-- Sidebar -->
<ul class="navbar-nav bg-gray-900 sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="far fa-kiss-wink-heart"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Manga Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="../index.php">
            <ion-icon name="list-circle-outline"></ion-icon>
            <span>HomePage</span></a>
    </li>

    <?php

            //side bar menu for admin
                    if($user->type == "admin"){
                        echo "<!-- Divider -->
                        <hr class=\"sidebar-divider\">
                    
                        <!-- Heading -->
                        <div class=\"sidebar-heading\">
                            Account
                        </div>
                    
                        <!-- Nav Item - Pages Collapse Menu -->
                        <li class=\"nav-item\">
                            <a class=\"nav-link collapsed\" data-toggle=\"collapse\" data-target=\"#collapseTwo\" aria-expanded=\"true\" aria-controls=\"collapseTwo\">
                                <i class=\"fas fa-user-cog\"></i>
                                <span>User Management</span></a>
                            </a>
                            <div id=\"collapseTwo\" class=\"collapse\" aria-labelledby=\"headingTwo\" data-parent=\"#accordionSidebar\">
                                <div class=\"bg-white py-2 collapse-inner rounded\">
                                    <a class=\"collapse-item\" href=\"accountManage.php\">Account Management</a>
                                    <a class=\"collapse-item\" href=\"#\">Search User</a>
                                </div>
                            </div>
                        </li>";

                    }
    ?>




    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Store
    </div>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-store"></i>
            <span>Store Management</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <?php
                    //side bar for admin

                        if($user->type == "admin") {
                            echo " <div class=\"bg-white py-2 collapse-inner rounded\">
                                    <h6 class=\"collapse-header\">Seller:</h6>
                                    <a class=\"collapse-item\" href=\"sellerManagement.php\">Seller Management</a>
                                    <a class=\"collapse-item\" href=\"acceptApplying.php\">Seller Apply List</a>
                                    <h6 class=\"collapse-header\">Order:</h6>
                                    <a class=\"collapse-item\" href=\"displayAllOrders.php\">Order Display</a>
                                    <a class=\"collapse-item\" href=\"searchOrder.php\">Search For Order</a>
                                </div>";
                        }


                        //side bar for seller
                        if($user->type == "seller"){
                            echo " <div class=\"bg-white py-2 collapse-inner rounded\">
                                                <h6 class=\"collapse-header\">Shop:</h6>
                                                <a class=\"collapse-item\" href=\"myItems.php\">Item Management</a>
                                                <a class=\"collapse-item\" href=\"addItem.php\">Add Item</a>
                                                <h6 class=\"collapse-header\">Order:</h6>
                                                <a class=\"collapse-item\" href=\"#\">Order Display</a>
                                                <a class=\"collapse-item\" href=\"#\">Search For Order</a>
                                            </div>";
                        }

            ?>

        </div>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->