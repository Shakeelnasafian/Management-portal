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
                            <h1>iCN Campaigns</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
                                <li class="breadcrumb-item active">Design</li>
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
                    <div class="card-header border-transparent">
                        <div class="row">
                            <div class="col-md-3">
                                <h3 class="card-title">Graphics Design Dashboard</h3>
                            </div>
                            <div class="col-md-8">
                                <!-- <div class="row">
                <div class="col-md-3">
                  
                  <form action="<?php echo BASE_URL . 'reporting/reporting-filters' ?>" method="post">
                    <input type="number" class="form-control" name="pr_id" placeholder="Search by ID" autocomplete="off">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="publish_date" placeholder="Select Date" autocomplete="off">
                </div>
                  <div class="col-md-3">
                    <button class="btn btn-default">Filter</button>
                  </div>
                  </form>             
                </div>       -->

                            </div>
                            <div class="col-md-1">
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- /.card-header -->

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                        <th>Action</th>


                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    if ($campaigns) {

                                        foreach ($campaigns as $campaign) {

                                    ?>
                                            <tr id="<?php echo 'pr_' . $campaign->post_id; ?>">

                                                <td>
                                                    <a href="<?php echo BASE_URL . 'reporting/view-report/' . $campaign->post_id ?>" target="_blank">
                                                        <?php echo $campaign->post_id; ?></a>
                                                </td>

                                                <td style="width: 40%;">
                                                    <a href="<?php echo 'http://examplenewswire.com/' . $campaign->post_name ?>" target="_blank">
                                                        <?php echo $campaign->post_title; ?></a>
                                                </td>

                                                <td> <span class="success-color">
                                                <?php echo date('Y-m-d',strtotime($campaign->start_date)); ?>
                                                    </span>
                                                </td>

                                                <td>
                                                <span class="danger-color">
                                                <?php echo $end_date = date('Y-m-d',strtotime($campaign->end_date)); ?>
                                                </span>
                                                </td>


                                                <td><span class="badge badge-success">
                                                    <?php echo $campaign->department; ?>
                                                   </span>
                                                </td>

                                                <td>
                                                <span class="badge badge-info">
                                                    <?php echo $campaign->campaign_status; ?>
                                                </span>
                                                </td>


                                                <td>
                                                    <a href="<?php echo BASE_URL . 'campaign/add-mockups/' . $campaign->post_id; ?>">
                                                        <button type="button" class="btn btn-info ">Add Mockups</button>
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
                        <?php echo isset($pager) ? $pager->links() : '';   ?>
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




