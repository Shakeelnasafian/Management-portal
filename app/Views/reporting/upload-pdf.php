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
                            <h1>Upload Report PDF</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
                                <li class="breadcrumb-item active">Report PDF</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>


    
            <form id="upload_pdf_form" name="upload_pdf_form" method="post" enctype="multipart/form-data" action="#">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Upload Report PDF here for better user experience </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label for="pdf_file">Upload PDF</label>
                                    <input type="file" class="form-control-file" id="pdf_file" name="pdf_file" accept="application/pdf">
                                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info " id="upload_pdf_button" onclick="saveReportPDF(event)">Save Upload Report PDF</button>
                        <span id="PDF_note"></span>
                    </div>
                    <!-- /.card-body -->
                </div>
            </form>

            <!-- /.content -->
        </div>


        <!-- /.content-wrapper -->
        <?php require_once(APPPATH . 'Views/inc/footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <?php require_once(APPPATH . 'Views/inc/js_scripts.php'); ?>

    <script>
        function saveReportPDF(e) {
            e.preventDefault();

            let pdf_file = $('#pdf_file').prop('files').length;

            if (pdf_file != "") {

                let data = new FormData($('#upload_pdf_form')[0]);
    
                $.ajax({
                    type: 'POST',
                    url: "<?php echo BASE_URL ?>reporting/upload_report_pdf",
                    contentType: false,
                    processData: false,
                    data: data,
                    beforeSend: function() {
                        $("#upload_pdf_button").prop('disabled', true);
                    },
                    success: function(response) {
                        
                        if (response == 1) {

                            $("#upload_pdf_button").prop('disabled', false);
                            
                            $('#PDF_note').append("Report PDF saved Successfully");

                        }else{
                            $('#PDF_note').append("Report PDF Updated Successfully");
                            $("#upload_pdf_button").prop('disabled', false);
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        $('#PDF_note').append("There were some errors while uploading your report");
                    }
                });

            }

        } //function end
    </script>


</body>

</html>




