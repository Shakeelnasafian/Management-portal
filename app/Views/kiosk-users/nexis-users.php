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
              <h1>Nexis Newswire </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item active">Nexis Users</li>
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
              <h3 class="card-title">Nexis Newswire Users</h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>     
            </div>        
            
          </div>
          <!-- /.card-header -->

          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0">
                <thead>
                  <tr>
                    <!-- <th>User ID</th> -->
                    <th>Client Name</th>
                    <th>Client Email </th>
                    <th>Credit Request</th>
                    <th>N SQA Email</th>
                    <th>N AM Email</th>
                    <th>N Seller Email</th>
                    <th>Acount</th>       
                  </tr>

                </thead>
                <tbody>
                
                  <?php
                  if($nexisnewsire_users){

                  foreach($nexisnewsire_users as $user){ ?>

                <tr>
                    <!-- <td>
                        <?php echo $user->ID ?>
                    </td> -->

                    <td>
                        <?php echo $user->client_name ?>
                    </td>

                    <td>
                        <?php echo $user->client_email ?>
                    </td>
                    <td>
                        <?php echo $user->credit_request ?>
                    </td>
                    <td>
                        <?php echo $user->nexis_sqa_email ?>
                    </td>
                    <td>
                        <?php echo $user->nexis_am_email ?>
                    </td>

                    <td>
                        <?php echo $user->nexis_seller_email ?>
                    </td>

                    <td>
                        <?php if($user->user_id){ ?>
                            <span class="badge badge-success">Created</span>
                          
                       
                          <?php }else{ ?>
                            <a href="<?php echo BASE_URL.'kiosk-users/create-nexis-account/'.$user->ID; ?>">  <button type="button" class="btn btn-info" >
                            Create Now
                        </button></a>

                        <?php } ?>
                    </td>
                </tr>

                  <?php } } ?>


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
 
</body>

</html>





