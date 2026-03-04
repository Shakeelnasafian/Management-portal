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
              <h1>iCN Reporting</h1>
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
          <div class="card-header border-transparent">
            <h3 class="card-title">View Report</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <?php 
         
          
          
          ?>

          <div class="container">
          <a href="<?php check_report_kiosk_id($post->kiosk_id,$ID); ?>" target="_blank"><button class="btn-info btn-lg">Click Here to view Report</button></a>
          <a href="<?php echo BASE_URL.'reporting/add-pdf/'.$ID; ?>" target="_blank"><button class="btn-success btn-lg">Upload Report PDF Here</button></a>
          </div>
       
         
          <!-- /.card-body -->
          <div class="card-footer clearfix">
           
            <!-- <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Add New PR</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All PRs</a> -->
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->

        <!-- calender -->

        <!-- calender end -->

      </section>
      <!-- /.content -->
    </div>

    <!-- modal start here -->
   
    <!-- /.content-wrapper -->
    <?php require_once(APPPATH . 'Views/inc/footer.php'); ?>
  </div>
  <!-- ./wrapper -->
  <?php require_once(APPPATH . 'Views/inc/js_scripts.php'); ?>
  <script type="text/javascript">


  
  </script>
</body>

</html>




