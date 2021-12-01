<?php require_once(APPPATH . 'views/inc/head.php'); ?>

<body class="hold-transition sidebar-mini">

  <div class="wrapper">

    <?php require_once(APPPATH . 'views/inc/header.php'); ?>

    <?php require_once(APPPATH . 'views/inc/sidebar.php'); ?>

    <div class="content-wrapper">

      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>iCN Coupons</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active">Update Coupon</li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <section class="content">

        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Update Coupon</h3>
          </div>

          <div class="card-body">
            <form role="form" method="post" action="<?php echo BASE_URL . 'coupon/update-coupon/' . $coupon->coupon_id; ?>" id="validate_coupon">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Coupon Code</label>
                    <input type="text" class="form-control" placeholder="Enter Coupon Code" autocomplete="off" value="<?php echo $coupon->coupon_code; ?>" disabled>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Discount Type</label>
                    <select class="form-control" name="discount_type" required>
                      <option value="Fixed" <?php echo $coupon->discount_type == "Fixed" ? "Selected" : ''; ?>>Fixed</option>
                      <option value="Percentage" <?php echo $coupon->discount_type == "Percentage" ? "Selected" : ''; ?>>Percentage</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Coupon Price</label>
                    <input type="text" class="form-control" placeholder="Enter Coupon Price" autocomplete="off" name="discount_price" value="<?php echo $coupon->discount_price; ?>" required>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Expiry Date</label>
                    <input type="date" class="form-control" placeholder="Enter Coupon Price" autocomplete="off" name="date_expire" value="<?php echo $coupon->date_expire; ?>" required>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Product</label>
                    <select class="form-control" name="kiosk_instance" required>
                      <!-- <option value='All'>ALL</option> -->
                      <?php echo show_products_name_edit($coupon->kiosk_instance); ?>

                    </select>
                    <input type="hidden" id="kiosk_instance" value='<?php echo $coupon->kiosk_instance ?>' />
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Project</label>
                    <select class="form-control" name="pack_id">
                      <option>Select Package</option>
                      <?php echo show_package_name($coupon->pack_id, $coupon->kiosk_instance); ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Coupon Counter</label>
                    <input type="number" class="form-control" placeholder="Enter Coupon Counter"  autocomplete="off" name="coupon_counter" value="<?php echo $coupon->coupon_counter ?>" required>
                  </div>
                </div>

                <div class="col-sm-6">
                  <label>One Time Per User</label>
                  <div class="form-group">
                    <div class="form-check radio-button-inline-no-top">
                      <input class="form-check-input" type="radio" name="one_time_per_user" value="1" <?php echo $coupon->one_time_per_user == 1 ? 'checked' : ''; ?>>
                      <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check radio-button-inline-no-top">
                      <input class="form-check-input" type="radio" name="one_time_per_user" value="0" <?php echo $coupon->one_time_per_user == 0 ? 'checked' : ''; ?>>
                      <label class="form-check-label">No</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Emails Allow</label>
                    <textarea class="form-control" rows="3" placeholder="Write multiple emails with separated commas. e.g (nasir@icrowdnewswire.com, skhan@icrowdnewswire.com)" name="coupon_emails"><?php echo $coupon->coupon_emails ?></textarea>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label>Transaction ID</label>
                  <div class="row">
                    <div class="col-sm-9">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Transaction ID" autocomplete="off" name="transaction_id" id="transaction_id" value="<?php echo $coupon->transaction_id ?>">
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <button class="btn btn-info" id="verify_transation">Verify Transaction</button>
                    </div>
                  </div>
                  <span id="error_span" style="color: red;"></span>
                  <input type="hidden" name="payment_status" id="payment_status">
                  <input type="hidden" name="amount" id="amount">
                </div>
              </div>

              <button class="btn btn-info" type="submit" id="update_coupon">Update</button>

            </form>
          </div>
          <!-- /.card-body -->
        </div>

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php require_once(APPPATH . 'views/inc/footer.php'); ?>
  </div>
  <!-- ./wrapper -->
  <?php require_once(APPPATH . 'views/inc/js_scripts.php'); ?>
  <script type="text/javascript">
    $("#validate_coupon").validate({
      ignore: ":hidden"

    });


    $('#verify_transation').click(function() {

      var transaction_id = $("#transaction_id").val();

      $.ajax({
        url: '<?php echo BASE_URL . 'utility/verify_transaction_id_paypal/'; ?>',
        type: 'POST',
        dataType: 'JSON',
        data: {
          transaction_id
        },

        success: function(data) {
          console.log(data)
          if (data.payment_status != 'Null') {
            $('#payment_status').val(data.payment_status);
            $("#amount").val(data.amount);
            $('#error_span').empty();
            $("#update_coupon").prop('disabled', false);
          } else {
            $('#error_span').append("PayPal Does Not Verify Transaction ID Please Try Again With Valid ID");
            $("#update_coupon").prop('disabled', true);
          }

        },
        error: function(data) {

          console.log(data);

        }
      }); //ajax end

      return false;
    });

    // $(document).ready(function() {
    //   var kiosk_product_id = $('#kiosk_instance').val();
    //   var getUrl = window.location;
    //   var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    //   var json = baseUrl + '/assets/json/result.json';
    //   $.getJSON(json, function(data) {
    //     $.each(data[kiosk_product_id], function(index, value) {
    //       var markup = '<option value="' + value.id + '">' + value.name + '</option>';
    //       $('select[name="pack_id"]').append(markup)
    //     });
    //   });
    // })

    $('select[name="kiosk_instance"]').on('change', function() {
      var kiosk_instance_id = this.value;
      $('select[name="pack_id"]').html(null)
      var markup = '<option selected disabled>Select Package</option>';
      $('select[name="pack_id"]').append(markup)
      var baseUrl = '<?php echo BASE_URL."/assets/json/result.json" ?>';
      $.getJSON(baseUrl, function(data) {
        $.each(data[kiosk_instance_id], function(index, value) {
          var markup = '<option value="' + value.id + '">' + value.name + '</option>';
          $('select[name="pack_id"]').append(markup)
        });
      });
    })
  </script>
</body>

</html>