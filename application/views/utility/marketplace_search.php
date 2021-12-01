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
                            <h1>Marketplace Search </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
                                <li class="breadcrumb-item active">Search Post ID</li>
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
                                <h3 class="card-title">Search Post ID</h3>
                            </div>
                            <div class="col-md-6">
                                <!-- form start here -->
                                <?php require_once(APPPATH . 'views/utility/marketplace_filter.php'); ?>
                                <!-- form end here -->
                            </div>

                        </div>


                    </div>
                    <?php if ($this->session->flashdata('validation_failed') != ''){?>  
                    <div class="alert alert-warning mt-2" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php  echo ($this->session->flashdata('validation_failed'));
                                ?>
                    </div>
                    <?php } ?>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="coupon-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Post ID</th>
                                    <th>URL</th>
                                    <th>Creation Date</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (isset($marketplace_data) && $marketplace_data!= '') {
                                    foreach ($marketplace_data as $result) : ?>

                                        <tr>
                                            <td><?php echo $result->post_id; ?></td>
                                            <td><?php echo $result->post_link; ?></td>
                                            <td><?php echo $result->fetch_date; ?></td>
                                        </tr>

                                <?php endforeach;
                                }else{ ?>
                                    
                                    <tr>
                                            <td>No Records To Dispaly</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                <th>Post ID</th>
                                    <th>URL</th>
                                    <th>Creation Date</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <?php echo $this->pagination->create_links();   ?>
                    </div>
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
        // $(function() {

        //     $('#coupon-table').DataTable({
        //         "paging": true,
        //         "lengthChange": true,
        //         "searching": true,
        //         "ordering": false,
        //         "info": true,
        //         "autoWidth": false,
        //     });
        // });
    </script>
</body>

</html>