<?php require_once APPPATH . 'Views/inc/head.php';?>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once APPPATH . 'Views/inc/header.php';?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->

        <?php require_once APPPATH . 'Views/inc/sidebar.php';?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Update User Credits</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                                <li class="breadcrumb-item active">Update Credits</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Update User Credits</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form role="form" method="post" action="<?php echo BASE_URL . 'kiosk-users/update-user-credits'; ?>" id="update_credits">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Client Name</label>
                                        <input type="text" class="form-control" value="<?php echo $user->user_nicename ?>" disabled>
                                    </div>
                                </div>
                                <input type="hidden" name="user_id" value="<?php echo $user->ID; ?>">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Client Email</label>
                                        <input type="text" class="form-control" value="<?php echo $user->user_email ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>User Name</label>
                                        <input type="text" class="form-control" value="<?php echo $user->user_login ?>"  disabled>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Previous Credits</label>
                                        <input type="text" class="form-control" placeholder="Enter lient Company" autocomplete="off" name="old_credits" value="<?php echo $user->total_credit ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>New Credits</label>
                                        <input type="text" class="form-control" placeholder="Enter New Credits" autocomplete="off" name="new_credits" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Package</label>
                                        <input type="numbers" class="form-control" placeholder="Enter Credit Request" autocomplete="off" name="credit_request" value="<?php echo $user->package_selected ?>">
                                    </div>
                                </div>              
                            </div>

                            <button class="btn btn-primary" type="submit">Update Credits</button>

                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php require_once APPPATH . 'Views/inc/footer.php';?>
    </div>
    <!-- ./wrapper -->
    <?php require_once APPPATH . 'Views/inc/js_scripts.php';?>
    <script type="text/javascript">
        $(function() {

            $("#update_credits").validate();

        });
    </script>
</body>

</html>





