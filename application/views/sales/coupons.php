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
                            <h1>iCN Sales</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
                                <li class="breadcrumb-item active">Coupons</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card">
                    <?php if ($this->session->flashdata('validation_failed')) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i>Validation Error</h5>
                            <?php echo $this->session->flashdata('validation_failed'); ?>
                        </div>
                    <?php endif; ?>
                    <?php echo validation_errors(); ?>
                    <div class="card-header border-transparent" style="background: #D4EDDA;">
                        <div class="row">
                            <div class="col-md-3">
                                <h3 class="card-title">Active Coupons</h3>
                            </div>
                            <div class="col-md-6">
                                <!-- form start here -->
                                <?php require_once(APPPATH . 'views/sales/coupon-filter.php'); ?>
                                <!-- form end here -->
                            </div>

                            <div class="col-md-3">

                                <a href="<?php echo BASE_URL . 'sales/expired-coupons'; ?>" class="coupon_buttons" id="coupon_button"><button class="btn btn-outline-danger">Expired Coupons</button></a>

                                <a href="<?php echo BASE_URL . 'sales/active-coupons'; ?>" class="coupon_buttons" id="coupon_button"><button class="btn btn-outline-primary">Active Coupons</button></a>


                            </div>

                        </div>
                    </div>

                    <!-- /.card-header -->

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Coupon</th>
                                        <th>Price</th>
                                        <th>Kiosk</th>
                                        <th>Expiry</th>
                                        <th>Counter</th>
                                        <th>One Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    if ($coupons) {

                                        foreach ($coupons as $coupon) {

                                    ?>
                                            <tr>
                                                <td class="coupon_code">
                                                    <span class="clip_board"></span>
                                                    <?php echo $coupon->coupon_code; ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    if ($coupon->discount_type == 'Percentage') {
                                                        echo '<span class="badge badge-success">' . $coupon->discount_price . ' %  </span>';
                                                    } else {
                                                        echo '<span class="badge badge-info">' . $coupon->discount_price . ' $  </span>';
                                                    } ?>

                                                </td>

                                                <td>
                                                    <?php echo coupon_product_name($coupon->kiosk_instance); ?>
                                                </td>

                                                <td>
                                                    <?php echo '<span class="badge badge-danger">' . $coupon->date_expire . '</span>'; ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    if ($coupon->coupon_counter == 0) {

                                                        echo '<span class="badge badge-warning">Unlimited</span>';
                                                    } else {

                                                        echo '<span class="badge badge-success">' . $coupon->coupon_counter . '  time</span>';
                                                    } ?>

                                                </td>

                                                <td>
                                                    <?php
                                                    if ($coupon->one_time_per_user == 1) {

                                                        echo '<span class="badge badge-success">Yes</span>';
                                                    } else {
                                                        echo '<span class="badge badge-warning">No</span>';
                                                    } ?>
                                                </td>
                                                <!-- <td>
                                                    <?php //echo $coupon->created_by; 
                                                    ?>
                                                </td> -->

                                                <td>

                                                    <button type="button" class="btn btn-outline-primary coupon_details" data-toggle="modal" data-target="#modal-default" id="<?php echo $coupon->coupon_id; ?>">Usage</button>


                                                </td>

                                            </tr>

                                    <?php }
                                    } ?>

                                </tbody>
                            </table>
                        </div>

                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <?php echo $this->pagination->create_links();   ?>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->

                <!-- calender -->

                <!-- calender end -->

            </section>
            <!-- /.content -->
        </div>

        <!-- modal start here -->
        <div class="modal fade show" id="modal-default" style="display: none;" aria-modal="true">
            <div class="modal-dialog">
                <form id="verify_pr_form" method="post">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Coupon Usage Details</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body">

                            <div id="none_verified_pr_text"></div>
                            <p>Coupon Apply <span class="badge badge-info" id="apply_time"> </span> Times,</p>
                            <p>Coupon Used <span class="badge badge-success" id="used_time"> </span> Times</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="modal_close_button">Close</button>
                        </div>
                    </div>

                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- modal end here -->


        <!-- /.content-wrapper -->
        <?php require_once(APPPATH . 'views/inc/footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <?php require_once(APPPATH . 'views/inc/js_scripts.php'); ?>

    <script>
        $(function() {

            $(document).on('click', '.coupon_details', function() {
                var coupon_id = $(this).attr("id");

                $.ajax({
                    url: '<?php echo BASE_URL . 'sales/coupon_usage_details'; ?>',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        coupon_id
                    },

                    success: function(data) {
                        console.log(data);
                        $('#apply_time').empty().append(data.coupon_applied);
                        $("#used_time").empty().append(data.coupon_used);
                    },
                    error: function(data) {

                    }
                }); //ajax end

            });

        }); //function end
    </script>

</body>

</html>