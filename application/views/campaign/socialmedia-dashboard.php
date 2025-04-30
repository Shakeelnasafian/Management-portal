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
                                <li class="breadcrumb-item active">Social Media</li>
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
                                <h3 class="card-title">Social Media Dashboard</h3>
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
                                        <th>PR-ID</th>
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

                                        foreach ($campaigns as $campaign) {  ?>

                                            <tr id="<?php echo 'cam_' . $campaign->campaign_id; ?>">

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


                                                <td><button type="button" class="btn btn-primary edit_campaign" data-toggle="modal" data-target="#modal-default" id="<?php echo $campaign->campaign_id; ?>">
                                                        Edit</button></td>

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

            <!-- modal start here -->
            <div class="modal fade show" id="modal-default" style="display: none;" aria-modal="true">
                <div class="modal-dialog">
                    <form id="update_campaign_form" method="post">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit iCN Campaign</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <div class="form-group col-md-12">
                                    <input type="hidden" name="campaign_id" class="campaign_id">
                                    <label>Department</label>
                                    <select class="form-control" name="department" id="department">
                                        <option value="graphics-design">Graphics Design</option>
                                        <option value="social-media">Social Media</option>
                                        <option value="operations">Operations</option>
                                        <option value="sales">Sales-Team</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Campaign Status</label>
                                    <select class="form-control" name="campaign_status" id="campaign_status">
                                        <option value="started">Started</option>
                                        <option value="in-progress">In Progress</option>
                                        <option value="Mokup">Mokup</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                                <div id="none_verified_pr_text"></div>

                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="modal_close_button">Close</button>
                                <button type="submit" class="btn btn-primary" id="updated_campaign">Update</button>
                            </div>
                        </div>

                    </form>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- modal end here -->

        </div>
        <!-- /.content-wrapper -->
        <?php require_once(APPPATH . 'views/inc/footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <?php require_once(APPPATH . 'views/inc/js_scripts.php'); ?>

</body>

<script>
    $(function() {

        $(document).on('click', '.edit_campaign', function() {
            var pr_id = $(this).attr("id");
            $('.campaign_id').val(pr_id);
        });

        $(document).on('submit', '#update_campaign_form', function(e) {

            e.preventDefault();

                let campaign_id = $('.campaign_id').val();

                $.ajax({
                    url: '<?php echo BASE_URL . 'campaign/update_campaign_status/'; ?>',
                    type: 'POST',
                    data: $('#update_campaign_form').serialize(),

                    success: function(data) {
                        $('#cam_' + campaign_id).remove();
                        $('#update_campaign_form')[0].reset();
                        $('#modal_close_button').trigger('click');
                        // $('#modal-default').css("display", "none");
                        // $("body").removeClass('modal-open');
                    },
                    error: function(data) {
                        $("#none_verified_pr_text").empty().append('<span class="alert alert-danger alert-dismissible" id="none_verified_pr_text">' + data + '</span>');
                    }
                }); //ajax end
           
        });

    }); //function end
</script>

</html>