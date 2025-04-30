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
              <h1>example Users</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item active">Legal Users</li>
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
           
           
              <h3 class="card-title">Legal Newswire Users</h3>
              
          
             
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button> -->
            </div>
                
             
            
            
            

            
          </div>
          <!-- /.card-header -->

          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0">
                <thead>
                  <tr>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>User Email </th>
                    <th>Pressrelease</th>
                    <th>Registerd On</th>
                    <th>View Details</th>
                   

                  </tr>
                </thead>
                <tbody>
                
                  <?php

                  if(isset($legal_users['users'])){

                  foreach($legal_users['users'] as $user){ ?>

                <tr>
                    <td>
                        <?php echo $user->user_id ?>
                    </td>

                    <td>
                        <?php echo $user->username ?>
                    </td>

                    <td>
                        <?php echo $user->email;  ?>
                    </td>
                    <td>
                    <?php if (in_array($user->user_id, $user_posts)) { ?>
                    <span class="badge badge-success">Yes</span>
                    <?php } else { ?>
                    <span class="badge badge-danger">NO</span>
                    <?php } ?>
                    </td>

                    <td>
                        <?php echo $user->registration_date ?>
                    </td>

                    <td>
                        <button type="button" class="btn btn-info verify_pr_now" data-toggle="modal" id="<?php echo $user->user_id; ?>" data-target="#modal-default">
                          View Details
                        </button>
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
            <?php echo $this->pagination->create_links();   ?>
           
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
    <div class="modal fade show" id="modal-default" style="display: none;" aria-modal="true">
        <div class="modal-dialog">
        <form  id="verify_pr_form" method="post" >

          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">User Details</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
           
            <div class="modal-body">
            
            <div class="form-group col-md-12">
             <div id="user_details"></div>
              
          </div>

          <div id="none_verified_pr_text"></div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" id="modal_close_button">Close</button>
             
            </div>
          </div>
          
        </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    <!-- modal end here -->
    <!-- /.content-wrapper -->
    <?php require_once(APPPATH . 'views/inc/footer.php'); ?>
  </div>
  <!-- ./wrapper -->
  <?php require_once(APPPATH . 'views/inc/js_scripts.php'); ?>
  <script type="text/javascript">

  $(function() {

  $(document).on('click', '.verify_pr_now', function(){  
        var user_id = $(this).attr("id");
        
        $.ajax({
          url:'<?php echo BASE_URL.'kiosk_users/get_kiosk_user_details_ajax/'; ?>',
          type: 'POST',
          dataType: 'html',
          data:{
            user_id
            } ,

          success: function(data) {
            console.log(data)
            $('#user_details').html(data); 
            // $("#coupon_code").val(data.coupon_code);
          },
          error : function(data){
          
          }
      });//ajax end

         
    });


  });//function end

  
  </script>
</body>

</html>