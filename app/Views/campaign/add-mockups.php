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
                <?php require_once(APPPATH . 'Views/inc/alerts.php'); ?>
                <!-- Default box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add PR Mockups</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form role="form" method="post" id="add_mockups"  enctype="multipart/form-data" action="#">

                            <div class="row">
                                <div class="col-sm-12">
                                    <h3> Pressrelease Title:</h3>
                                    <p id="pr_title">
                                        <?php echo $campaign->post_title; ?>
                                        
                                    </p>
                                    <button id="copy_text" class="btn btn-primary">Copy</button>
                                    
                                </div>
                                <input type="hidden" name="campaign_id" value="<?php echo $campaign->campaign_id; ?>">
                                <input type="hidden" name="post_id" value="<?php echo $campaign->post_id; ?>">
                               
                            </div>

                            <div class="row">
                            <div class="col-sm-6">
                            <label>Pressrelease Package:</label>
                                    <p><b> <?php echo '$' . $campaign->pr_package; ?></b></p>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Upload Zip File</label>
                                    <input type="file" class="form-control-file" id="mockups" name="mockups">
                                </div>
                            </div>


                            </div>



                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <select class="form-control" name="department" id="department">
                                            <option value="social-media">Social Media</option>
                                            <option value="graphics-design">Graphics Design</option>
                                            <option value="operations">Operations</option>
                                            <option value="sales">Sales-Team</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Campaign Status</label>
                                    <select class="form-control" name="campaign_status" id="campaign_status">
                                        <option value="in-progress">In Progress</option>
                                        <option value="started">Started</option>
                                        <option value="Mokup">Mokup</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit" id="add_mockups_button">Add Mockups</button><span id="message_span"></span>

                        </form>
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

            $('#copy_text').click(function(e) {
                e.preventDefault();
                var copyText = document.getElementById("pr_title");
                var textArea = document.createElement("textarea");
                textArea.value = copyText.textContent;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand("Copy");
                textArea.remove();
                $("#copy_text").html("Copied")
                return false;
            });

            // $("#add_mockups").validate({
            //     ignore: ":hidden",
            //     rules: {
            //         coupon_code: {
            //             required: true,
            //             remote: {
            //                 url: "<?php echo BASE_URL ?>coupon/check_coupon_code",
            //                 type: "post",
            //             }
            //         },

            //     },
            //     messages: {
            //         coupon_code: {
            //             required: 'Please Enter A Unique Coupon Code.',
            //             remote: "This Coupon Code already Exists"
            //         },

            //     },
            // });

            $('#add_mockups_button').click(function(e) {
                e.preventDefault();
               // let pdf_file = $('#pdf_file').prop('files').length;
                let data = new FormData($('#add_mockups')[0]);
               
                $.ajax({
                    url: '<?php echo BASE_URL . 'campaign/upload_pr_mockups'; ?>',
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    data: data,
                    beforeSend: function() {
                        $("#add_mockups_button").prop('disabled', true);
                    },
                    success: function(data) {
                        console.log(data)
                        if (data == 'Mockups Added successfully') {

                            $('#message_span').append("Mockups Added successfully");
                            $("#add_mockups_button").prop('disabled', false);
                            window.location = "<?php echo BASE_URL ?>campaign/graphics-dashboard/";

                        } else {
                            $('#message_span').append("There is some issue while uploading Mockups");
                            $("#add_mockups_button").prop('disabled', false);
                        }

                    },
                    error: function(data) {

                        $('#message_span').append("There is some issue while uploading Mockups");
                        $("#add_mockups_button").prop('disabled', false);

                    }
                }); //ajax end


               // return false;
            });

        });
    </script>
</body>

</html>




