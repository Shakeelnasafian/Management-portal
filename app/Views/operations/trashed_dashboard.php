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
                    <?php if (session()->getFlashdata('validation_failed')) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
                            <h5><i class="icon fas fa-check"></i>Validation Error</h5>
                            <?php echo session()->getFlashdata('validation_failed'); ?>
                        </div>
                    <?php endif; ?>
                    <?php echo validation_list_errors(); ?>
                    <div class="card-header border-transparent" style="background: #F8D7DA;">
                        <div class="row">
                            <div class="col-md-3">
                                <h3 class="card-title">Trashed Press Releases</h3>
                            </div>

                            <div class="col-md-9">
                            <!-- form start here -->
                            <?php require_once(APPPATH . 'Views/operations/filter_form.php'); ?>
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
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Date</th>
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
                                                    <?php echo $post->ID; ?>
                                                </td>

                                                <td style="width: 40%;">
                                                    <a href="<?php echo BASE_URL . 'operations/view-pressrelease/' . $post->ID ?>">
                                                        <?php echo $post->post_title; ?></a>
                                                </td>

                                                <td>
                                                    <?php echo $post->post_date; ?>
                                                </td>
                                                <td>
                                                    <?php echo $post->user_login; ?>
                                                </td>

                                                <td>
                                                <button type="button" class="btn btn-outline-info undo_pr" id="<?php echo $post->ID; ?>">Undo   <i class="fa fa-undo" aria-hidden="true"></i></button>
                                                    

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

    <script>
        $(function() {

            $(document).on('click', '.undo_pr', function(e) {

                e.preventDefault();

                let post_id = $(this).attr('id');
                let confrm = confirm('Are you sure to remove this Pressrelease from Trash ??');
                    
                if(confrm){
                $.ajax({
                    url: '<?php echo BASE_URL . 'operations/move_trash_pending'; ?>',
                    type: 'POST',
                    data: {
                        post_id
                    },

                    success: function(data) {
                        if (data == 1) {
                            $('#pr_' + post_id).remove();
                        } else {
                            alert("PR Rejection Failed");
                        }

                    },
                    error: function(data) {
                       
                    }
                }); //ajax end
            }

            });




        });
    </script>

</body>

</html>




