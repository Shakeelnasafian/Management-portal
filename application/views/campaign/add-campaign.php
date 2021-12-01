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
                            <h1>iCN Campaigns </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                                <li class="breadcrumb-item active">Add Campaign</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
            <?php require_once(APPPATH . 'views/inc/alerts.php'); ?>
                <!-- Default box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add New Campaign</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form role="form" method="post" action="<?php echo BASE_URL . 'campaign/create-campaign/' . $coupon->coupon_id; ?>" id="validate_campaign">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Pressrelease ID</label>
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Enter Pressrelease ID" autocomplete="off" name="post_id" id="post_id">
                                            </div>
                                        </div>
                                        <div class="col-sm-3sss">
                                            <button class="btn btn-info" id="get_post_details">Fetch PR Details</button>
                                        </div>
                                    </div>
                                    <span id="error_span" style="color: red;"></span>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>PR Title</label>
                                        <input type="text" class="form-control" placeholder="PR Title Will Display Here" autocomplete="off" name="post_title" id="post_title" required>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>PR Name</label>
                                        <input type="text" class="form-control" placeholder="PR Name Will Display Here" autocomplete="off" name="post_name" id="post_name" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Package</label>
                                        <input type="text" class="form-control" placeholder="Enter PR Package" autocomplete="off" name="pr_package" id="pr_package" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Client Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Client Name" autocomplete="off" name="client_name" id="client_name" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Product / Kiosk Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Product / Kiosk Name" autocomplete="off" name="product_name" id="product_name" required >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="date" class="form-control" placeholder="Enter Start Date" autocomplete="off" name="start_date" id="start_date" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">

                                    <label>End Date</label>
                                    <input type="date" class="form-control" placeholder="Enter End Date" autocomplete="off" name="end_date" id="end_date" required>
                                </div>
                            </div>

                            <div class="row">
                            
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <select class="form-control" name="department" id="department">
                                            <option value="graphics-design">Graphics Design</option>
                                            <option value="social-media">Social Media</option>
                                            <option value="operations">Operations</option>
                                            <option value="sales">Sales-Team</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Campaign Status</label>
                                    <select class="form-control" name="campaign_status" id="campaign_status">
                                        <option value="started">Started</option>
                                        <option value="in-progress">In Progress</option>
                                        <option value="Mokup">Mokup</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit" id="create_campaign">Add New Campaign</button>

                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>

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

            $("#validate_campaign").validate({
                ignore: ":hidden",
                rules: {
                    post_id: {
                        required: true,
                        remote: {
                            url: "<?php echo BASE_URL ?>campaign/check_existing_campaign",
                            type: "post",
                        }
                    },
                    post_title:{
                        required:true,
                    },
                    post_name:{
                        required:true,
                    },
                    pr_package:{
                        required:true,
                    },
                    start_date:{
                        required:true,
                    },
                    end_date:{
                        required:true,
                    },
                    product_name:{
                        required:true,
                    },
                    client_name:{
                        required:true,
                    }

                },
                messages: {
                    post_id: {
                        required: 'Please enter a unique pressrelease ID.',
                        remote: "The campaign of this pressrelease already exists"
                    },
                    post_title: {
                        required: 'Please enter title of pressrelease.',
                    },
                    post_name: {
                        required: 'Please enter postname pressrelease.',
                    },
                    pr_package: {
                        required: 'Please enter package of pressrelease.',
                    },
                    start_date: {
                        required: 'Please enter start date of campaign.',
                    },
                    end_date: {
                        required: 'Please enter end date of campaign.',
                    },
                    product_name: {
                        required: 'Please enter product/kiosk name of Pressrelease.',
                    },
                    client_name: {
                        required: 'Please enter client name of campaign.',
                    },


                },
            });

            $('#get_post_details').click(function() {

                var post_id = $("#post_id").val();

                $.ajax({
                    url: '<?php echo BASE_URL . 'campaign/get_pressrelease_details/'; ?>',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        post_id
                    },

                    success: function(data) {
                        if (data.post_title && data.post_name != 'Null') {
                            $('#post_title').val(data.post_title);
                            $("#post_name").val(data.post_name);
                            $("#pr_package").val(data.pr_package);
                            $("#start_date").val(data.start_date);
                            $("#end_date").val(data.end_date);
                            $("#product_name").val(data.product_name);


                            $('#error_span').empty();
                            $("#create_coupon").prop('disabled', false);
                        } else {
                            $('#error_span').html("There is an error while loading PR details Please insert manually!")
                            $("#create_coupon").prop('disabled', false);
                        }

                    },
                    error: function(data) {

                        console.log(data);

                    }
                }); //ajax end


                return false;
            });

        });
    </script>
</body>

</html>