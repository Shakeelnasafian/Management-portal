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
                                <li class="breadcrumb-item active">Expired Coupons</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Expired Coupons</h3>
                        <a href="<?php echo BASE_URL.'coupon/icn-coupons'; ?>" class="coupon_buttons" id="coupon_button"><button class="btn btn-outline-primary">Active Coupons</button></a>

                        <a href="<?php echo BASE_URL.'coupon/add-coupon/'; ?>" class="coupon_buttons" id="expire_button"><button class="btn btn-outline-dark">Add Coupon</button></a> 
                        
                    </div>
                  
                    <div class="card-body">
                        <table id="coupon-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Coupon Code</th>
                                    <th>Discount Price</th>
                                    <th>Discount Type</th>
                                    <th>Date Expire</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                                if($coupons) : 
                                    foreach ($coupons as $coupon) : ?>

                                    <tr>
                                        <td><?php echo $coupon->coupon_code; ?></td>
                                        <td><?php echo $coupon->discount_price; ?></td>
                                        <td><?php echo $coupon->discount_type; ?></td>
                                        <td><?php echo $coupon->date_expire; ?></td>
                                   
                                    </tr>

                            <?php 
                                    endforeach; 
                                endif;
                                ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Coupon Code</th>
                                    <th>Discount Price</th>
                                    <th>Discount Type</th>
                                    <th>Date Expire</th>
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