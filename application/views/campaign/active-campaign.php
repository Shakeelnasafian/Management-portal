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
                            <h1>iCN Campaigns</h1>
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
                    <div class="card-header border-transparent">
                        <div class="row">
                            <div class="col-md-3">
                                <h3 class="card-title">iCN Active Campaigns </h3>
                            </div>
                            <div class="col-md-5">
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
                            <div class="col-md-4 campaign-buttons">
                                
                                <a href="<?php echo BASE_URL . 'campaign/active-campaigns' ?>"><button class="btn btn-primary">Active Campaign</button></a>
                                <a href="<?php echo BASE_URL . 'campaign/completed-campaigns' ?>"><button class="btn btn-success">Completed Campaign</button></a>

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
                                        <th>Progress</th>


                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    if ($campaigns) {
                                          foreach ($campaigns as $campaign) { ?>
                                        
                                            <tr id="<?php echo 'pr_' . $campaign->post_id; ?>">

                                                <td>
                                                    <a href="<?php echo BASE_URL . 'reporting/view-report/' . $campaign->post_id ?>" target="_blank">
                                                        <?php echo $campaign->post_id; ?></a>
                                                </td>

                                                <td style="width: 35%;">
                                                    <a href="<?php echo 'http://icrowdnewswire.com/' . $campaign->post_name ?>" target="_blank">
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

                                                <?php 
                                                
                                                $today_date = date("Y-m-d");
                                                $today_date = strtotime($today_date);
                                                $end_date = strtotime($end_date);
                                                
                                                $date_diff = round(abs($end_date - $today_date) / (60*60*24),0); 
                                                
                                                $percentage = round($date_diff * 100 / 9);
                                                ?>

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
                                                <div class="progress">
                                                    <div class="progress-bar bg-primary progress-bar-striped" style="width: <?php echo $percentage ?>%">
                                                    <span class="sr-only"><?php echo $percentage ?>% Complete (success)</span>
                                                     </div>
                                                 </div>
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