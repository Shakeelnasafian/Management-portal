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
                                <li class="breadcrumb-item active">View PR</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <?php require_once(APPPATH . 'Views/inc/alerts.php'); ?>
            <!-- Main content -->
            <section class="content">

            <div class="row">
          <div class="col-md-12">
            <!-- Widget: user widget style 2 -->
            <div class="card card-primary card-outline">
            
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-read-info">
                <h5><?php echo $post->post_title;  ?></h5>
                <h6>
                  <span class="mailbox-read-time float-right"><?php echo $post->post_date;  ?></span></h6>
              </div>
              <!-- /.mailbox-read-info -->
              <div class="mailbox-controls with-border text-center" style="height: 30px;">
               
                <!-- /.btn-group -->
                <span class="mailbox-read-time float-right">Status :<?php echo $post->post_status; ?></span>
              </div>
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
               <?php echo $post->post_content; ?>
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer bg-white">
             
            </div>
            <!-- /.card-footer -->
            <div class="card-footer">
              <div class="float-right">
                <!-- <button type="button" class="btn btn-success"><i class="fas fa-reply"></i> Approve</button>
                <button type="button" class="btn btn-danger"><i class="fas fa-share"></i> Trash</button> -->
              </div>
              
            </div>
            <!-- /.card-footer -->
          </div>
            <!-- /.widget-user -->
          </div>
         
         
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
        // $(function() {

        //     $('#coupon-table').DataTable({
        //         "paging": true,
        //         "lengthChange": true,
        //         "searching": true,
        //         "ordering": false,
        //         "info": true,
        //         "autoWidth": false,
        //     });
        // });
    </script>
</body>

</html>




