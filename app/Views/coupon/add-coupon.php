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
                            <h1>iCN Coupons</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                                <li class="breadcrumb-item active">Add Coupon</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Coupon</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form role="form" method="post" action="<?php echo BASE_URL . 'coupon/create-coupon/'; ?>" id="validate_coupon">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Coupon Code</label>
                                        <div class="input-group">
                                            <input type="text" placeholder="Enter Coupon Code" class="form-control mr-2" placeholder="Enter Coupon Code" autocomplete="off" name="coupon_code" required>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" id="coupon_btn" type="button">Generate Coupon</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Discount Type</label>
                                        <select class="form-control" name="discount_type" id="discount_type">
                                            <option value="Fixed">Fixed</option>
                                            <option value="Percentage">Percentage</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Coupon Price</label>
                                        <input type="text" class="form-control" placeholder="Enter Coupon Price" autocomplete="off" name="discount_price" id="discount_price" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Expiry Date</label>
                                        <input type="date" class="form-control" placeholder="Enter Coupon Price" autocomplete="off" name="date_expire" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Product</label>
                                        <select class="form-control" name="kiosk_instance">
                                            <option value='19' selected>Release Live</option>
                                            <option value='56'>Wire.RealEstate</option>
                                            <option value='47'>Legal Newswire</option>
                                            <option value='55'>examplemarketing.com</option>
                                            <option value='58'>Class Action Marketing</option>
                                            <option value='60'>Latin America</option>

                                            <!-- <?php echo show_kiosks_name_edit($coupon->kiosk_instance); ?> -->
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Package</label>
                                        <select class="form-control" name="pack_id">
                                            <option disabled selected>Select Package</option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Coupon Counter</label>
                                        <input type="number" class="form-control" placeholder="Enter Coupon Counter" autocomplete="off" name="coupon_counter" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>One Time Per User</label>
                                    <div class="form-group">
                                        <div class="form-check radio-button-inline-no-top">
                                            <input class="form-check-input" type="radio" name="one_time_per_user" value="1">
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                        <div class="form-check radio-button-inline-no-top">
                                            <input class="form-check-input" type="radio" name="one_time_per_user" value="0" checked>
                                            <label class="form-check-label">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Emails Allow</label>
                                        <textarea class="form-control" rows="3" placeholder="Write multiple emails with separated commas. e.g (nasir@examplenewswire.com, skhan@examplenewswire.com)" name="coupon_emails"></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Transaction ID</label>
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Enter Transaction ID" autocomplete="off" name="transaction_id" id="transaction_id">
                                            </div>
                                        </div>
                                        <div class="col-sm-3sss">
                                            <button class="btn btn-info" id="verify_transation">Verify Transaction</button>
                                        </div>
                                    </div>
                                    <span id="error_span" style="color: red;"></span>
                                    <input type="hidden" name="payment_status" id="payment_status">
                                    <input type="hidden" name="amount" id="amount">
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit" id="create_coupon">Create Coupon</button>

                        </form>
                    </div>
                    <!-- /.card-body -->
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
        $(function() {

            //this code is for validation purpose added by shakeel
            var discount_type = document.getElementById('discount_type');
            var discount_price = document.getElementById('discount_price');
            var timeout = null;
            // trigger on key change discount price textfield keyup event 
            discount_price.onkeyup = function(e) {

                var newPrice = discount_price.value.replace(/[^0-9\.]/g, '');
                document.getElementById('discount_price').value = newPrice;

                if (discount_type.value == 'Percentage' && newPrice > 100) {
                    document.getElementById('discount_price').value = 100;
                }
            };
            //  trigger on value change of select option
            $('#discount_type').change(function() {
                var discount_price = $('#discount_price').val();
                var data = $(this).val();
                if (data == 'Percentage' && discount_price > 100) {
                    $('#discount_price').val(100);
                }
            });

            $("#expiry_time").datetimepicker({

            });

            $("#validate_coupon").validate({
                ignore: ":hidden",
                rules: {
                    coupon_code: {
                        required: true,
                        remote: {
                            url: "<?php echo BASE_URL ?>coupon/check_coupon_code",
                            type: "post",
                        }
                    },

                },
                messages: {
                    coupon_code: {
                        required: 'Please Enter A Unique Coupon Code.',
                        remote: "This Coupon Code already Exists"
                    },

                },
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
                            $("#create_coupon").prop('disabled', false);
                        } else {
                            $('#error_span').append("PayPal Does Not Verify Transaction ID Please Try Again With Valid ID");
                            $("#create_coupon").prop('disabled', true);
                        }

                    },
                    error: function(data) {

                        console.log(data);

                    }
                }); //ajax end

                return false;
            });

            $('#coupon_btn').click(function(e) {
                e.preventDefault();
                var counpon_generated = generateCoupon()
                $("input[name=coupon_code]").val(counpon_generated);
            });

            function generateCoupon() {
                var length = 8;
                var result = '';
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                var charactersLength = characters.length;
                for (var i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() *
                        charactersLength));
                }
                return result;
            }


            $(document).ready(function() {
                var baseUrl = '<?php echo BASE_URL . "/assets/json/result.json" ?>';
                $.getJSON(baseUrl, function(data) {
                    $.each(data[19], function(index, value) {
                        var markup = '<option value="' + value.id + '">' + value.name + '</option>';
                        $('select[name="pack_id"]').append(markup)
                    });
                });
            })

            $('select[name="kiosk_instance"]').on('change', function() {
                var kiosk_instance_id = this.value;
                $('select[name="pack_id"]').html(null)
                var markup = '<option selected disabled>Select Package</option>';
                $('select[name="pack_id"]').append(markup)
                var baseUrl = '<?php echo BASE_URL . "/assets/json/result.json" ?>';
                $.getJSON(baseUrl, function(data) {
                    $.each(data[kiosk_instance_id], function(index, value) {
                        var markup = '<option value="' + value.id + '">' + value.name + '</option>';
                        $('select[name="pack_id"]').append(markup)
                    });
                });
            })
        });
    </script>
</body>

</html>




