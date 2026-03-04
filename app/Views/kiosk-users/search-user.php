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
                            <h1>Create Account</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                                <li class="breadcrumb-item active">Create Account</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-sm-6">
                        <!-- Default box -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update User Credits</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form role="form" method="post"
                                    action="<?php echo BASE_URL . 'kiosk-users/find-user'; ?>" id="create_user">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Client Email / Username</label>
                                                <input type="text" class="form-control" placeholder="Enter Client Email"
                                                    autocomplete="off" name="client_email" required>
                                            </div>
                                        </div>

                                    </div>

                                    <button class="btn btn-primary" type="submit" id="create_coupon">Search</button>

                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php require_once APPPATH . 'Views/inc/footer.php';?>
    </div>
    <!-- ./wrapper -->
    <?php require_once APPPATH . 'Views/inc/js_scripts.php';?>

</body>

</html>





