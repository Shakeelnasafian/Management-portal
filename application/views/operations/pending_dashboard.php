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
                    <div class="card-header border-transparent" style="background: #CCE5FF;">
                        <div class="row">
                            <div class="col-md-3">
                                <h3 class="card-title">Pending Press Releases</h3>
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
                        <div class="table table-hover table-striped">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>Preview</th>
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
                                                    <a href="<?php echo 'https://examplenewswire.com/?p=' . $post->ID . '&preview=true' ?>" target="_blank">
                                                        <?php echo $post->ID; ?></a>
                                                </td>

                                                <td style="width: 40%;">
                                                    <a href="<?php echo BASE_URL . 'operations/view-pressrelease/' . $post->ID ?>">
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

                                                    <button type="button" class="btn btn-outline-info view_pressrelease" data-toggle="modal" data-target="#modal-xl" id="<?php echo $post->ID; ?>">
                                                        View PR
                                                    </button>

                                                    <a href="<?php echo BASE_URL . 'operations/edit-pending-pressrelease/' . $post->ID ?>">
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

            <!-- modal start here -->

            <div class="modal fade show" id="modal-xl" aria-modal="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="post_title"></h4>
                            <button type="button" class="close close_modal" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" id="post_content">

                        </div>
  
                        <input type="hidden" name="post_id" id="post_id">

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default close_modal" data-dismiss="modal" id="modal_close_button">Close</button>
                            <!-- <button type="button" class="btn btn-outline-success" id="approve_pr">Approve</button> -->
                            <a href="" id="edit_link"> <button type="button" class="btn btn-outline-primary" id="edit_pr">Edit</button></a>
                            <button type="button" class="btn btn-outline-danger" id="reject_pr">Reject</button>
                        </div>
                    </div>
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

    <script>
        $(function() {

            // $('.select2').select2();
            // //Initialize Select2 Elements
            // $("#post_date").datetimepicker({

            // });


            $(document).on('click', '.view_pressrelease', function() {
                var pr_id = $(this).attr("id");

                $.ajax({
                    url: '<?php echo BASE_URL . 'operations/get_pr_details_ajax'; ?>',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        pr_id
                    },

                    success: function(data) {

                        if (data.post_title && data.post_id != 'Null') {

                            $('#post_id').val(data.post_id);
                            $("#post_title").html(data.post_title);
                            $("#post_content").html(data.post_content);
                            $("#edit_link").attr("href", "<?php echo BASE_URL?>operations/edit-pending-pressrelease/"+data.post_id)
                            // $("#post_name").val(data.post_name);
                            // $("#post_status").val(data.post_status);
                            // $("#post_date").val(data.post_date);
                            // $("#user_login").val(data.user_login);
                            // $("#user_email").val(data.user_email);


                            $('#error_span').empty();
                            $("#create_coupon").prop('disabled', false);

                        } else {

                            $('#error_span').html(
                                "There is an error while loading PR details Please insert manually!"
                            )
                            $("#create_coupon").prop('disabled', false);

                        }

                    },
                    error: function(data) {

                    }
                }); //ajax end
            });


            $(document).on('click', '#approve_pr', function(e) {

                e.preventDefault();

                let post_id = $('#post_id').val();

                $.ajax({
                    url: '<?php echo BASE_URL . 'operations/approve_pressrelease'; ?>',
                    type: 'POST',
                    data: {
                        post_id
                    },

                    success: function(data) {
                        if (data == 'PR Approved successfully') {

                            $('#pr_' + post_id).remove();
                            $('#modal_close_button').trigger('click');

                        } else {
                            alert("PR Does no Approved");
                        }

                    },
                    error: function(data) {
                        $("#none_verified_pr_text").empty().append(
                            '<span class="alert alert-danger alert-dismissible" id="none_verified_pr_text">' +
                            data + '</span>');
                    }
                }); //ajax end

            });


            $(document).on('click', '#reject_pr', function(e) {

                e.preventDefault();

                let post_id = $('#post_id').val();
                let confmtin = confirm('Are You sure to Trash this PR ??');
                    
                if(confmtin){
                $.ajax({
                    url: '<?php echo BASE_URL . 'operations/reject_pressrelease'; ?>',
                    type: 'POST',
                    data: {
                        post_id
                    },

                    success: function(data) {
                        if (data == 'PR Rejected successfully') {

                            $('#pr_' + post_id).remove();
                            $('#modal_close_button').trigger('click');
                            // $('#modal-default').css("display", "none");
                            // $("body").removeClass('modal-open');
                        } else {
                            alert("PR Rejection Failed");
                        }

                    },
                    error: function(data) {
                        $("#none_verified_pr_text").empty().append(
                            '<span class="alert alert-danger alert-dismissible" id="none_verified_pr_text">' +
                            data + '</span>');
                    }
                }); //ajax end
            }

            });




        });
    </script>
</body>

</html>