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
                            <h1>iCN Operations</h1>
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
                                <h3 class="card-title">Published Press Releases</h3>
                            </div>
                            <div class="col-md-9">
                            <!-- form start here -->
                            <?php require_once(APPPATH . 'views/operations/filter_form.php'); ?>
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
                                        <th>Date GMT</th>
                                        <th>Author</th>
                                        <th>Action</th>


                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    if ($posts) {

                                        foreach ($posts as $post) {

                                    ?>
                                            <tr id="<?php echo 'pr_' . $post->ID; ?>">

                                                <td>
                                                    <a href="<?php echo 'https://pdfprocessor.icrowdnewswire.com/new/'. $post->ID ?>" target="_blank">
                                                        <?php echo $post->ID; ?></a>
                                                </td>

                                                <td style="width: 40%;">
                                                    <a href="<?php echo 'http://icrowdnewswire.com/' . $post->post_name ?>" target="_blank">
                                                        <?php echo $post->post_title; ?></a>
                                                </td>

                                                <td>
                                                    <?php echo $post->post_date; ?>
                                                </td>
                                                <td>
                                                    <?php echo $post->post_date_gmt; ?>
                                                </td>
                                                <td>
                                                    <?php echo $post->user_login; ?>
                                                </td>

                                                <td>
                                                
                                                    <a href="<?php echo BASE_URL . 'operations/edit-pressrelease/' . $post->ID ?>">
                                                        <button type="button" class="btn btn-outline-primary">Edit</button>
                                                    </a>

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


        <!-- /.content-wrapper -->
        <?php require_once(APPPATH . 'views/inc/footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <?php require_once(APPPATH . 'views/inc/js_scripts.php'); ?>

</body>

</html>