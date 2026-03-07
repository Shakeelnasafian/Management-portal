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
              <h1>Pressrelease Verification</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item active">Pressrelease Verification</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

      <?php //var_dump($post); ?>
        <!-- Default box -->
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Verify Pressrelease</h3>
              </div>
              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                  Launch Default Modal
                </button>
              <!-- /.card-header -->
              <!-- form start -->
              <form  id="verify_pr_form" >
                <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-12">
                    <label for="title">Pressrelease Title</label>
                    <input type="text" class="form-control" disabled value="<?php echo $post->pr_title; ?>">
                  </div>
                  </div>

                  <div class="row">
                  <div class="form-group col-md-4">
                    <label for="author">Pressrelease Author</label>
                    <input type="text" class="form-control" disabled value="<?php echo $post->post_author; ?>">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="author">Frankly Links</label>
                    <input type="text" class="form-control" disabled value="<?php echo $post->frankly_links ? 'YES' : 'NO'; ?>">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="author">BigPond Links</label>
                    <input type="text" class="form-control" disabled value="<?php echo $post->bignews_links ? 'YES' : 'NO'; ?>">
                  </div>
                  </div>

                  <div class="row">
                  <div class="form-group col-md-6">
                    <label for="author">Transaction ID / Coupon</label>
                    <input type="text" class="form-control" name="transaction_id" >
                  </div>
                  

                  <div class="form-group col-md-6">
                        
                  <div class="form-check radio-button-inline">
                    <input class="form-check-input" type="radio" name="payment_type" value="Invoice" checked>
                    <label class="form-check-label">Invoice</label>
                  </div>

                  <div class="form-check radio-button-inline">
                    <input class="form-check-input" type="radio" name="payment_type" value="PayPal">
                    <label class="form-check-label">PayPal</label>
                  </div>

                  <div class="form-check radio-button-inline">
                    <input class="form-check-input" type="radio" name="payment_type" value="Coupon">
                    <label class="form-check-label">Coupon</label>
                  </div>
                       

                  </div>
                 

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Verify Pressrelease</button>
                </div>
              </form>
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
  <script type="text/javascript">

$(document).on('submit', '#verify_pr_form' ,function(e) {

    var select_date =$("#verify_pr_form").val();
    e.preventDefault();

      $.ajax({
          url:'<?php echo BASE_URL.'pressrelease/verify_now_pr/'.$post->pr_id; ?>',
          type: 'POST',
          data: $('#verify_pr_form').serialize(),

          success: function(data) {
              console.log(data);
              $("#none_verified_pr_text").append(data);
          },
          error : function(data){
              console.log(data);
          }
      });
});

</script>

</body>

</html>




