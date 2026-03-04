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
              <h1>iCN Coupons </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item active">iCN Coupons</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <?php require_once(APPPATH . 'Views/inc/alerts.php'); ?>
      <!-- Main content -->
      <section class="content">

        <div class="row">
          <div class="col-md-6">
            <!-- Widget: user widget style 2 -->
            <div class="card card-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">

                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">Coupon Code : <?php echo $coupon->coupon_code; ?></h3>

              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <?php if ($coupon->discount_price) : ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        Discount Price <span class="float-right badge bg-primary"><?php echo $coupon->discount_price; ?></span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if ($coupon->discount_type) : ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        Discount Type <span class="float-right badge bg-info"><?php echo $coupon->discount_type; ?></span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if ($coupon->date_added) : ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        Creation Date <span class="float-right badge bg-success"><?php echo $coupon->date_added; ?></span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if ($coupon->transaction_id) : ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        Transaction ID <span class="float-right badge bg-success"><?php echo $coupon->transaction_id; ?></span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if ($coupon->date_expire) : ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        Expiry Date <span class="float-right badge badge bg-danger"><?php echo $coupon->date_expire; ?></span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if ($coupon->kiosk_instance) : ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        Kiosk Instance <span class="float-right badge ">
                          <?php if ($coupon->kiosk_instance == 'All') {
                            echo $coupon->kiosk_instance;
                          } else {
                            echo show_products_name_view($coupon->kiosk_instance);
                          }; ?></span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if ($coupon->pack_id) : ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        Package Name <span class="float-right badge ">
                          <?php if ($coupon->kiosk_instance == 0) {
                            echo 'All Packages';
                          } else {
                            echo get_package_name($coupon->pack_id, $coupon->kiosk_instance);
                          }; ?></span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if ($coupon->one_time_per_user) : ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        One Time Per User <span class="float-right badge "><?php echo $coupon->one_time_per_user == 0 ? 'NO' : 'YES'; ?></span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if ($coupon->coupon_emails) : ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        Coupon Emails <span class="float-right badge "><?php echo $coupon->coupon_emails; ?></span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if ($coupon->created_by) : ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        Create By<span class="float-right badge"><?php echo $coupon->created_by; ?></span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if ($coupon->edited_by) : ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        Last Edited By<span class="float-right badge"><?php echo $coupon->edited_by; ?></span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if ($coupon->payment_status) : ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        Payment Status<span class="float-right badge bg-success"><?php echo $coupon->payment_status; ?></span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if ($coupon->amount) : ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        Amount<span class="float-right badge bg-success">$<?php echo $coupon->amount; ?></span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Coupon Counter <span class="float-right badge "><?php echo $coupon->coupon_counter == 0 ? 'NO' : $coupon->coupon_counter; ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Status <?php if ($coupon->status == 1) { ?>
                        <span class="float-right badge bg-success">Active</span>
                      <?php } else { ?>
                        <span class="float-right badge bg-danger">Not Active</span>
                      <?php } ?>
                    </a>
                  </li>

                </ul>
              </div>
            </div>
            <!-- /.widget-user -->
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <h3 class="widget-user-username">Coupon Used : <?php echo $coupon_usage->coupon_used == "" ? '0' : $coupon_usage->coupon_used . ' Times'; ?></h3>
                <h3 class="widget-user-username">Coupon Apply : <?php echo $coupon_usage->coupon_applied == "" ? '0' : $coupon_usage->coupon_applied . ' Times'; ?></h3>
              </div>


            </div>
            <!-- /.widget-user -->

            <div class="card">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <h3 class="card-header bg-info text-center">Coupon History</h3>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>
                          Updated By
                        </th>
                        <th>
                          Coupon Price
                        </th>
                        <th>
                          Coupon Type
                        </th>
                        <th>
                          Coupon Counter
                        </th>
                        <th>
                          Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($coupon_history) :

                        foreach ($coupon_history as $r) : ?>
                          <tr>
                            <td><?php echo $r->updated_by; ?></td>
                            <td>$<?php echo $r->coupon_price; ?></td>
                            <td><?php echo $r->coupon_type; ?></td>
                            <td><?php echo $r->counter; ?></td>
                            <td><?php echo $r->action; ?></td>
                          </tr>
                      <?php endforeach;
                      endif;
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>

            </div>

          </div>
          <!-- /.col -->

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




