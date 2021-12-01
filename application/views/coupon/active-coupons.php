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
                            <h1>iCN Coupons </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
                                <li class="breadcrumb-item active">Active Coupons</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <h3 class="card-title">Active Coupons</h3>
                            </div>
                            <div class="col-md-6">
                                <!-- form start here -->
                                <?php require_once(APPPATH . 'views/coupon/coupon-filter.php'); ?>
                                <!-- form end here -->
                            </div>

                            <div class="col-md-3">
                                <a href="<?php echo BASE_URL . 'coupon/expired-coupons'; ?>" class="coupon_buttons" id="coupon_button"><button class="btn btn-outline-danger">Expired Coupons</button></a>

                                <a href="<?php echo BASE_URL . 'coupon/add-coupon/'; ?>" class="coupon_buttons" id="expire_button"><button class="btn btn-outline-dark">Add Coupon</button></a>

                            </div>

                        </div>


                    </div>
                    <?php //var_dump($coupons) 
                    ?>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="coupon-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Coupon Code</th>
                                    <th>Discount Price</th>
                                    <th>Discount Type</th>
                                    <th>Transaction ID</th>
                                    <th>Creation Date</th>
                                    <th>Expiry Date</th>
                                    <th>Created By</th>
                                    <th class="action_tab">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if ($coupons) :
                                    
                                    foreach ($coupons as $coupon) : ?>

                                        <tr>
                                            <td><?php echo $coupon->coupon_code; ?></td>
                                            <td>$<?php echo $coupon->discount_price; ?></td>
                                            <td><?php echo $coupon->discount_type; ?></td>
                                            <td><?php echo $coupon->transaction_id; ?></td>
                                            <td><?php echo $coupon->date_added; ?></td>
                                            <td><?php echo $coupon->date_expire; ?></td>
                                            <td><?php echo $coupon->created_by; ?></td>
                                            <td class="action_tab"><a href="<?php echo BASE_URL . 'coupon/edit-coupon/' . $coupon->coupon_id; ?>"><button class="btn btn-outline-primary">Edit</button></a>
                                                <a href="<?php echo BASE_URL . 'coupon/view-coupon/' . $coupon->coupon_id; ?>"><button class="btn btn-outline-dark">View</button></a>
                                                <a href="<?php echo BASE_URL . 'coupon/expire-coupon/' . $coupon->coupon_id; ?>"><button class="btn btn-outline-danger">Expire </button></a>
                                            </td>
                                        </tr>

                                <?php endforeach;
                                endif;
                                ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                <th>Coupon Code</th>
                                    <th>Discount Price</th>
                                    <th>Discount Type</th>
                                    <th>Transaction ID</th>
                                    <th>Creation Date</th>
                                    <th>Expiry Date</th>
                                    <th>Created By</th>
                                    <th class="action_tab">Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php require_once(APPPATH . 'views/inc/footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <?php require_once(APPPATH . 'views/inc/js_scripts.php'); ?>
    <script type="text/javascript">
        $(function() {

            $('#coupon-table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>
</body>

</html>