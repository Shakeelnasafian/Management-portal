<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo BASE_URL ?>" class="brand-link">
        <img src="<?php echo ASSETS; ?>images/logo.jpg" alt="Editorial Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">iCN Management</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <?php if($this->session->userdata('user_session')->profile_image != ""){ ?>
           
                <img src="<?php echo $this->session->userdata('user_session')->profile_image; ?>" alt="Editorial user" class="brand-image img-circle elevation-3 user_iamge" style="opacity: .8">
           
                <?php }else{ ?>
            
            <img src="<?php echo ASSETS; ?>images/user.png" alt="Editorial user" class="brand-image img-circle elevation-3 user_iamge" style="opacity: .8">
           
            <?php } ?>
            
            <div class="info">
                <a href="#" class="d-block"><?php echo $this->session->userdata('user_session')->user_login ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview" id="dashboard">
                    <a href="<?php echo BASE_URL ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <?php if ($this->session->userdata('user_session')->icn_role == 'Editor' or $this->session->userdata('user_session')->icn_role == 'Administrator' or $this->session->userdata('user_session')->icn_role == 'Operations-Staff') { ?>

                    <li class="nav-item has-treeview" id="coupons">
                        <a class="nav-link">
                            <i class="nav-icon fa fa-dollar-sign"></i>
                            <p>
                            iCN Coupons
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview sub-child">
                            <li class="nav-item" id="pending_pressreleases">
                                <a href="<?php echo BASE_URL ?>coupon/icn-coupons" class="nav-link">
                                    <i class="nav-icon fa fa-toggle-on"></i>
                                    <p>Active Coupons</p>
                                </a>
                            </li>

                            <li class="nav-item has-treeview" id="schedule_pressreleases">
                                <a href="<?php echo BASE_URL ?>coupon/expired-coupons" class="nav-link">
                                    <i class="nav-icon fa fa-toggle-off"></i>
                                    <p>Expired Coupons</p>
                                </a>
                            </li>

                            <li class="nav-item has-treeview" id="published_pressreleases">
                                <a href="<?php echo BASE_URL ?>coupon/add-coupon" class="nav-link">
                                    <i class="nav-icon fa fa-plus"></i>
                                    <p>Add Coupon</p>
                                </a>
                            </li>

                            <li class="nav-item has-treeview" id="published_pressreleases">
                                <a href="<?php echo BASE_URL ?>coupon/transaction-details" class="nav-link">
                                    <i class="nav-icon fa fa-plus"></i>
                                    <p>Transaction Details</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item has-treeview" id="operations_dashboard">
                        <a class="nav-link">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>
                                Operations
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview sub-child">
                            <li class="nav-item" id="pending_pressreleases">
                                    <a href="<?php echo BASE_URL . 'operations/create-pressrelease' ?>" class="nav-link">
                                        <i class="nav-icon fas fa-pen-square"></i>
                                        <p>Create Press Release</p>
                                    </a>
                            </li>
                            <li class="nav-item" id="pending_pressreleases">
                                <a href="<?php echo BASE_URL . 'operations/pending-pressreleases' ?>" class="nav-link">
                                    <i class="nav-icon fas fa-circle-notch fa-spin"></i>
                                    <p>Pending Pressreleases</p>
                                </a>
                            </li>

                            <li class="nav-item has-treeview" id="schedule_pressreleases">
                                <a href="<?php echo BASE_URL . 'operations/schedule-pressreleases' ?>" class="nav-link">
                                    <i class="nav-icon fas fa-calendar-alt"></i>
                                    <p>Schedule Pressreleases</p>
                                </a>
                            </li>

                            <li class="nav-item has-treeview" id="published_pressreleases">
                                <a href="<?php echo BASE_URL . 'operations/published-pressreleases' ?>" class="nav-link">
                                    <i class="nav-icon fas fa-book-open"></i>
                                    <p>Published Pressreleases</p>
                                </a>
                            </li>

                            <li class="nav-item has-treeview" id="trashed_pressreleases">
                                <a href="<?php echo BASE_URL . 'operations/trashed-pressreleases' ?>" class="nav-link">
                                    <i class="nav-icon fas fa-trash"></i>
                                    <p>Trashed Pressreleases</p>
                                </a>
                            </li>

                            <li class="nav-item has-treeview" id="trashed_pressreleases">
                                <a href="<?php echo BASE_URL . 'operations/draft-pressreleases' ?>" class="nav-link">
                                    <i class="nav-icon fab fa-firstdraft"></i>
                                    <p>Draft Pressreleases</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                <?php } ?>

                <?php if ($this->session->userdata('user_session')->icn_role == 'SocialMedia-Staff' or $this->session->userdata('user_session')->icn_role == 'Administrator') { ?>
                    <li class="nav-item has-treeview" id="reporting">
                        <a href="<?php echo BASE_URL ?>reporting/dashboard" class="nav-link">
                            <i class="nav-icon fa fa-file"></i>
                            <p>ICN Reporting</p>
                        </a>
                    </li>

                <?php }

                if ($this->session->userdata('user_session')->icn_role == 'Operations-Staff' or $this->session->userdata('user_session')->icn_role == 'Administrator') { ?>

                    <li class="nav-item has-treeview " id="pr_status">
                        <a class="nav-link">
                            <i class="nav-icon fas fa-exclamation-circle"></i>
                            <p>
                                PR Status
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview sub-child">
                            <li class="nav-item" id="verified_prs">
                                <a href="<?php echo BASE_URL ?>pressrelease/verified-prs" class="nav-link">
                                    <i class="far fas fa-check-circle nav-icon"></i>
                                    <p>Verified PRs</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo BASE_URL ?>pressrelease/none-verified-prs" class="nav-link">
                                    <i class="far fas fa-ban nav-icon"></i>
                                    <p>None Verified PRs</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php }

                if ($this->session->userdata('user_session')->icn_role == 'Editor' or $this->session->userdata('user_session')->icn_role == 'Administrator') { ?>

                    <li class="nav-item has-treeview" id="market_links">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas far fa-store"></i>
                            <p>
                                Market Place
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview sub-child">
                            <li class="nav-item">
                                <a href="<?php echo BASE_URL ?>utility/add_marketplace_sites_links" class="nav-link">
                                    <i class="far fas fas fa-plus nav-icon"></i>
                                    <p>Add Synacor network links</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo BASE_URL ?>utility/search_marketplace_sites_links" class="nav-link">
                                    <i class="far fas fa fa-search nav-icon"></i>
                                    <p>Search Links</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php }

                if ($this->session->userdata('user_session')->icn_role == 'Editor' or $this->session->userdata('user_session')->icn_role == 'Administrator' or $this->session->userdata('user_session')->icn_role == 'SEO-Staff') { ?>

                    <li class="nav-item has-treeview" id="find_pressrelease">
                        <a href="<?php echo BASE_URL ?>search-engine/find-pressrelease" class="nav-link">
                            <i class="nav-icon fa fa-search"></i>
                            <p>Archive Press Releases</p>
                        </a>
                    </li>

                <?php } ?>
                
                <li class="nav-item has-treeview " id="managment_user">
                    <a class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Management Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview sub-child">

                        <?php
                        if ($this->session->userdata('user_session')->icn_role == 'Administrator') { ?>

                            <li class="nav-item has-treeview" id="add_user">
                                <a href="<?php echo BASE_URL ?>users/add-user" class="nav-link">
                                    <i class="nav-icon fas fa-plus"></i>
                                    <p>Add Management Users</p>
                                </a>
                            </li>

                        <?php } ?>
                        <li class="nav-item">
                            <a href="<?php echo BASE_URL . 'users/edit-profile/' . $this->session->userdata('user_session')->ID ?>" class="nav-link">
                                <i class="far fas fa-user nav-icon"></i>
                                <p>Profile</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <?php
                if ($this->session->userdata('user_session')->icn_role == 'Stake Holders' || $this->session->userdata('user_session')->icn_role == 'Administrator' || $this->session->userdata('user_session')->icn_role == 'Editor') { ?>

                    <li class="nav-item has-treeview " id="icrowd_users">
                        <a class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                iCrowd Users
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview sub-child">
                            <li class="nav-item">
                                <a href="<?php echo BASE_URL ?>kiosk-users/pressrelease-users" class="nav-link">
                                    <i class="far fas fa-user nav-icon"></i>
                                    <p>iCN Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo BASE_URL ?>kiosk-users/legal-users" class="nav-link">
                                    <i class="far fas fa-user nav-icon"></i>
                                    <p>Legal Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo BASE_URL ?>kiosk-users/content-users" class="nav-link">
                                    <i class="far fas fa-user nav-icon"></i>
                                    <p>Content Marketing Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo BASE_URL ?>kiosk-users/realestate-users" class="nav-link">
                                    <i class="far fas fa-user nav-icon"></i>
                                    <p>Wire Realestat Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo BASE_URL ?>kiosk-users/nexisnewsire-users" class="nav-link">
                                    <i class="far fas fa-user nav-icon"></i>
                                    <p>Nexis Newsire Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo BASE_URL ?>kiosk-users/search-user" class="nav-link">
                                    <i class="far fas fa-user nav-icon"></i>
                                    <p>Add Credits</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php  } ?>


                <?php
                if ($this->session->userdata('user_session')->icn_role == 'Sales' or $this->session->userdata('user_session')->icn_role == 'Administrator') { ?>

                    <li class="nav-item has-treeview " id="icn_sales">
                        <a class="nav-link">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>
                                iCN Sales
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview sub-child">
                            <li class="nav-item" id="icn_users">
                                <a href="<?php echo BASE_URL ?>sales/pressreleases" class="nav-link">
                                    <i class="fas fa-newspaper nav-icon"></i>
                                    <p>Press Releases</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo BASE_URL ?>sales/active-coupons" class="nav-link">
                                    <i class="fa fa-dollar-sign nav-icon"></i>
                                    <p>iCN Coupons</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo BASE_URL ?>sales/users-credits" class="nav-link">
                                    <i class="fas fa-newspaper nav-icon"></i>
                                    <p>Users Credits</p>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="<?php echo BASE_URL ?>sales/pressreleases" class="nav-link">
                                    <i class="far fas fa-user nav-icon"></i>
                                    <p>Wire Realestat Users</p>
                                </a>
                            </li> -->
                        </ul>
                    </li>

                <?php  } ?>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>