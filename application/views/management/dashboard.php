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
              <h1>Management Dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box" style="background: #4DA9D3;">
              <div class="inner">
                <h3><?= $response_data->total_posts_today; ?></h3>

                <p>Total Press Releases</p>
              </div>
              <div class="icon">
                <i class="ion-android-add"></i>
              </div>
              <a href="<?= BASE_URL . 'management/date-searching'; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box" style="background: #9CBF72;">
              <div class="inner">
                <h3><?= $response_data->today_verified_posts ?: 0; ?><sup style="font-size: 20px"></sup></h3>

                <p>Total Verified Press Releases</p>
              </div>
              <div class="icon">
                <i class="ion-android-checkmark-circle"></i>
              </div>
              <a href="<?= BASE_URL . 'management/date-searching'; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box" style="background: #E26D70;">
              <div class="inner">
                <h3><?= $response_data->today_unveified_posts; ?></h3>

                <p>Total None Verified Press Releases</p>
              </div>
              <div class="icon">
                <i class="ion-alert-circled"></i>
              </div>
              <a href="<?= BASE_URL . 'management/date-searching'; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->

        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box" style="background: #AA6DA7;">
              <div class="inner">
                <h3><?= $response_data->total_frankly_posts + $channels_data->total_frankly_posts; ?></h3>

                <p>Total Press Releases Published On Frankly</p>
              </div>
              <div class="icon">
                <i class="ion-android-exit"></i>
              </div>
              <a href="<?= BASE_URL . 'management/date-searching'; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box" style="background: #FBD69F;">
              <div class="inner">
                <h3><?= $response_data->total_bignews_links + $channels_data->total_bignews_links ; ?></h3>

                <p>Total Press Releases Published On Bignews</p>
              </div>
              <div class="icon">
                <i class="ion-android-exit"></i>
              </div>
              <a href="<?= BASE_URL . 'management/date-searching'; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>


          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box" style="background: #999999;">
              <div class="inner">
                <h3><?= $response_data->total_financial_links + $channels_data->total_financial_links ; ?></h3>

                <p>Total Press Releases Published On Financial Content</p>
              </div>
              <div class="icon">
                <i class="ion-android-exit"></i>
              </div>
              <a href="<?= BASE_URL . 'management/date-searching'; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>

        <div class="row">
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box" style="background: #999999;">
              <div class="inner">
                <h3><?= $channels_data->total_ips_links ; ?></h3>

                <p>Total Press Releases Published On IPS News</p>
              </div>
              <div class="icon">
                <i class="ion-android-exit"></i>
              </div>
              <a href="<?= BASE_URL . 'management/date-searching'; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-4">

            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Mostly Used Coupons</h3>

              </div>
              <div class="card-body">
                   
                <?php foreach ($mostly_used_coupons as $coupon_used) { ?>

                  <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                  <p class="d-flex flex-column text-left">
                      <span class="font-weight-bold"><?= $coupon_used->coupon_code; ?></span>
                    </p>
                    <p class="text-success text-xl">
                      <i class="ion"></i><?= $coupon_used->couponUsed; ?>
                    </p>
                    
                  </div>

                <?php  }  ?>

                <!-- /.d-flex -->
              </div>
            </div>
          </div>
        </div>

      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php require_once(APPPATH . 'views/inc/footer.php'); ?>
  </div>
  <!-- ./wrapper -->
  <?php require_once(APPPATH . 'views/inc/js_scripts.php'); ?>
  <script type="text/javascript">
  </script>
</body>

</html>