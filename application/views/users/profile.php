<?php require_once(APPPATH . 'views/inc/head.php'); ?>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once(APPPATH . 'views/inc/header.php'); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->

        <?php require_once(APPPATH . 'views/inc/sidebar.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Edit Profile</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- frankly links start here-->
                <?php require_once(APPPATH . 'views/inc/alerts.php'); ?>
                <!-- Default box -->
                <div class="row">
                    <div class="col-md-12">

                        <!-- card start here -->

                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Edit Profile</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form role="form" action="<?php echo BASE_URL . 'users/update-profile/' . $user->ID; ?>" id="create_user" method="post" enctype="multipart/form-data">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control" value="<?php echo $user->user_login; ?>" disabled>

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="form-control" value="<?php echo $user->user_email; ?>" disabled>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Registration Date</label>
                                                <input type="text" class="form-control" value="<?php echo $user->user_registered; ?>" disabled>

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Role</label>
                                                <input type="text" class="form-control" value="<?php echo $user->icn_role; ?>" disabled>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" class="form-control password_fields" name="new_pass" placeholder="Enter New Password" autocomplete="off" id="new_pass_togl">

                                                <i class="fas fa-eye fa-w-18 toggle_password" id="new_password"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Re-Enter Password</label>
                                                <input type="password" class="form-control" name="confirm_pass" placeholder="confirm Password" required id="confirm_pass_togl">
                                                <i class="fas fa-eye fa-w-18 toggle_password" id="confirm_password"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- text input -->

                                            <div class="form-group">
                                                <label>Change Phone Number</label>
                                                <input type="tel" class="form-control" name="cell_phone" id="cell_phone" placeholder="Enter Cell Phone" autocomplete="off" required value="<?php echo $user->cell_phone; ?>">
                                            </div>


                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>Profile Image</label>
                                                        <input type="file" class="form-control-file" name="profile_image">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <img src="<?php echo $user->profile_image; ?>" alt="Editorial user" class="brand-image img-circle elevation-3 image_profile" style="opacity: .8">

                                                    </div>
                                                </div>



                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">

                                            <button class="btn btn-info" id="add-button">Update Profile</button>
                                        </div>
                                    </div>


                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>

                        <!-- card end here -->


                        <!-- /.card -->
                    </div>
                    <!-- /.col -->


                </div>
                <!-- /.row -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php require_once(APPPATH . 'views/inc/footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <?php require_once(APPPATH . 'views/inc/js_scripts.php'); ?>
    <script type="text/javascript">
        $("#create_user").validate({

            ignore: ":hidden",
            rules: {
                  new_pass: {
                    required: true,
            },
            confirm_pass: {
                    required: true,
                    equalTo: '#new_pass_togl',
            },
        },
           
        });


        $('#new_password').click(function() {

            var input_type = $("#new_pass_togl").prop('type');

            if (input_type == "password") {

                $("#new_pass_togl").prop("type", "text");

            } else {

                $("#new_pass_togl").prop("type", "password");
            }
        });

        $('#confirm_password').click(function() {

            var input_type = $("#confirm_pass_togl").prop('type');

            if (input_type == "password") {

                $("#confirm_pass_togl").prop("type", "text");

            } else {

                $("#confirm_pass_togl").prop("type", "password");
            }
        });
    </script>
</body>

</html>