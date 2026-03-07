<?php require_once(APPPATH . 'Views/inc/head.php'); ?>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once(APPPATH . 'Views/inc/header.php'); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->

        <?php require_once(APPPATH . 'Views/inc/sidebar.php'); ?>

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
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card">
                    <?php if (session()->getFlashdata('validation_failed')) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
                            <h5><i class="icon fas fa-check"></i>Validation Error</h5>
                            <?php echo session()->getFlashdata('validation_failed'); ?>
                        </div>
                    <?php endif; ?>
                    <?php echo validation_list_errors(); ?>
                    <div class="card-header border-transparent" style="background: #D4EDDA;">
                        <div class="row">
                            <div class="col-md-3">
                                <h3 class="card-title">Press Releases</h3>
                            </div>
                            <div class="col-md-9">
                            <!-- form start here -->
                            <?php require_once(APPPATH . 'Views/sales/filter-form.php'); ?>
                            <!-- form end here -->    
                            </div>
                      
                        </div>
                    </div>

                    <!-- /.card-header -->

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Report</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Author</th>
                                        <!-- <th>Action</th> -->


                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    if ($posts) {

                                        foreach ($posts as $post) {

                                    ?>
                                            <tr id="<?php echo 'pr_' . $post->ID; ?>">

                                                <td>
                                                    <a href="<?php echo 'https://pdfprocessor.examplenewswire.com/new/'. $post->ID ?>" target="_blank">
                                                        <?php echo $post->ID; ?></a>
                                                </td>

                                                <td style="width: 40%;">
                                                    <a href="<?php echo 'http://examplenewswire.com/' . $post->post_name ?>" target="_blank">
                                                        <?php echo $post->post_title; ?></a>
                                                </td>

                                                <td>
                                                    <?php echo $post->post_date; ?>
                                                </td>
                                                <td>
                                                    <?php echo get_status($post->post_status); ?>
                                                </td>
                                                <td>
                                                    <?php echo $post->user_login; ?>
                                                </td>

                                                <!-- <td>
                                                
                                                        <button type="button" class="btn btn-outline-primary">User Info</button>
                                                    

                                                </td> -->

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
                        <?= isset($pager) ? $pager->links() : '' ?> Total Result <a data-ci-pagination-page="" style="width: 100px !important;"><?= $total_rows ?></a>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->

                <!-- calender -->

                <!-- calender end -->

            </section>
            <!-- /.content -->
        </div>


        <!-- /.content-wrapper -->
        <?php require_once(APPPATH . 'Views/inc/footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <?php require_once(APPPATH . 'Views/inc/js_scripts.php'); ?>

</body>

</html>




