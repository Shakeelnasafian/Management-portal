<?php require_once APPPATH . 'views/inc/head.php';?>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once APPPATH . 'views/inc/header.php';?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->

        <?php require_once APPPATH . 'views/inc/sidebar.php';?>

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

                <!-- Default box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create Nexis User Account</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form role="form" method="post" action="<?php echo BASE_URL . 'kiosk-users/add-nexis-account'; ?>" id="create_user">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Client Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Client Name" autocomplete="off" name="client_name" required value="<?php echo $user->client_name ?>">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Client Email</label>
                                        <input type="text" class="form-control" placeholder="Enter Client Email" autocomplete="off" name="user_email" value="<?php echo $user->client_email ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>User Name</label>
                                        <input type="text" class="form-control" placeholder="Enter User Name" autocomplete="off" name="user_login"  required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="text" class="form-control" placeholder="EnterPassword" autocomplete="off" name="user_pass" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Client Company</label>
                                        <input type="text" class="form-control" placeholder="Enter lient Company" autocomplete="off" name="client_company" value="<?php echo $user->client_company ?>" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Credit Request</label>
                                        <input type="numbers" class="form-control" placeholder="Enter Credit Request" autocomplete="off" name="credit_request" value="<?php echo $user->credit_request ?>" required>
                                    </div>
                                </div>              
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Client Country</label>
                                        <input type="text" class="form-control" placeholder="Enter Client Country" autocomplete="off" name="client_country" value="<?php echo $user->client_country ?>" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Nexis SQA Email</label>
                                    <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Enter Nexis SQA Email" autocomplete="off" name="nexis_sqa_email" value="<?php echo $user->nexis_sqa_email ?>" required>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nexis AM Email</label>
                                        <input type="text" class="form-control" placeholder="Enter Nexis AM Email" autocomplete="off" name="nexis_am_email" value="<?php echo $user->nexis_am_email ?>" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Nexis Seller Email</label>
                                    <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Enter Nexis Seller Email" autocomplete="off" name="nexis_seller_email" value="<?php echo $user->nexis_seller_email ?>" required>
                                </div>
                                <input type="hidden" name="user_id" value="<?php echo $user->ID ?>">
                            </div>

                            <button class="btn btn-primary" type="submit" id="create_coupon">Create Account</button>

                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php require_once APPPATH . 'views/inc/footer.php';?>
    </div>
    <!-- ./wrapper -->
    <?php require_once APPPATH . 'views/inc/js_scripts.php';?>
    <script type="text/javascript">
        $(function() {

            $("#create_user").validate({
                ignore: ":hidden",
                rules: {
                    user_email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "<?php echo BASE_URL ?>kiosk_users/check_user_email",
                        type: "post",
                    }
                },
                user_login: {
                    required: true,
                    maxlength: 20,
                    minlength: 5,
                    remote: {
                        url: "<?php echo BASE_URL ?>kiosk_users/check_user_login",
                        type: "post",
                    }
                },

                },
                messages: {
                    user_email: {
                    required: 'Please enter your Corporate Email Address.',
                    email: 'Please enter a valid Email Address.',
                    remote: "This email address has already been registered."
                    },
                    user_login: {
                        required: 'Please enter a Username.',
                        remote: "Username already exists."
                    },
                },
            });

        });
    </script>
</body>

</html>