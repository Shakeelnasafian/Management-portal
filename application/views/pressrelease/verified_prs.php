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
              <h1>Verified Press Releases</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item active">Verified</li>
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
            <h3 class="card-title">Latest Verified Press Releases</h3>

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

          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Author </th>
                    <th>Distribution</th>
                    <th>T-ID / Coupon</th>
                    <th>Payment Type</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($posts) {

                    foreach ($posts as $post) { ?>

                      <tr>
                        <td style="width: 40%;"><?php echo $post->pr_title; ?>
                        </td>

                        <td><?php echo $post->post_author; ?>
                          <br>

                          <div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $post->pr_publish_time; ?></div>
                        </td>
                        <?php 
                          if($post->channel){ 
                                  echo '<td>';
                                  $channels = explode(',', $post->channel);
                                  foreach ($channels as $channel) {
                                      echo '<span class="success-color">'.ucwords(str_replace('_', ' ', $channel)).'<i class="fas fa-check"></i></span><br>';
                                    } 
                                echo '</td>';
                            }else{ ?>
                                <td><?php if ($post->frankly_links == 1) {?>
                                    <span class="success-color">Frankly<i class="fas fa-check"></i></span>
                                    <?php }?>
                                    <br>
                                    <?php if ($post->bignews_links == 1) {?>
                                    <span class="success-color">Bigpond<i class="fas fa-check"></i></span>
                                    <?php }?>
                                    <br>
                                    <?php if ($post->financial_links == 1) {?>
                                    <span class="success-color">Financial<i class="fas fa-check"></i></span>
                                    <?php }?>
                                </td>
                        <?php } ?>

                        <td>
                          <span class="badge badge-info">
                            <?php echo empty($post->transaction_id) ? $post->coupon_code : $post->transaction_id; ?>
                          </span>
                        </td>

                        <td>
                          <span class="badge badge-success"><?php echo $post->payment_type; ?></span>
                        </td>

                        <td><span class="badge badge-success">Verified</span></td>
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
    <!-- /.content-wrapper -->
    <?php require_once(APPPATH . 'views/inc/footer.php'); ?>
  </div>
  <!-- ./wrapper -->
  <?php require_once(APPPATH . 'views/inc/js_scripts.php'); ?>
</body>

</html>