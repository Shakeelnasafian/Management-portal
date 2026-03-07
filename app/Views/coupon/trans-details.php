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
                            <h1>iCN Coupons</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                                <li class="breadcrumb-item active">Transaction Details</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Transaction Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Post ID</label>
                                    <div class="input-group">
                                        <input type="number" placeholder="Enter Post ID To Find Transaction Deatils"
                                            class="form-control mr-2" autocomplete="off" id="post_id" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" id="track_trans" type="button">Transaction
                                                Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <div class="table-responsive" id="tran_det_display">
                                                
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php require_once(APPPATH . 'Views/inc/footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <?php require_once(APPPATH . 'Views/inc/js_scripts.php'); ?>
    <script type="text/javascript">
    $(function() {

        $('#track_trans').click(function() {

            var post_id = $("#post_id").val();

            if (post_id == '') exit();

            $.ajax({
                url: '<?php echo BASE_URL . 'coupon/get_transaction_details'; ?>',
                type: 'POST',
                dataType: 'html',
                data: {
                    post_id
                },

                success: function(data) {
                    console.log(data)
                    if (data != '') {

                        $('#tran_det_display').empty().append(data);

                    } else {


                    }

                },
                error: function(data) {

                    console.log(data);

                }
            }); //ajax end

        });

    });
    </script>
</body>

</html>




