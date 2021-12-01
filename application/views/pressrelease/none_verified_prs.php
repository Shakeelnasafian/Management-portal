<?php require_once APPPATH . 'views/inc/head.php';?>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once APPPATH . 'views/inc/header.php';?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->

        <?php require_once APPPATH . 'views/inc/sidebar.php';?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>None Verified Press Release</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
                                <li class="breadcrumb-item active">None Verified</li>
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
                        <div class="row">
                            <div class="col-md-3">
                                <h3 class="card-title">Latest None Verified Press Releases</h3>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-3">
                                        <form action="<?php echo BASE_URL . 'pressrelease/pr-filters' ?>" method="post">
                                        <input type="text" class="form-control" name="posts_author"
                                            placeholder="Enter Press Release Author">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="pr_title"
                                            placeholder="Enter Press Release Title">
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-default">Filter</button>
                                    </div>
                                    </form>
                                </div>

                            </div>
                            <div class="col-md-1">
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>

                            </div>
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
                                        <th>ICN Site </th>
                                        <th>Distribution</th>
                                        <th>Status</th>
                                        <th>Verify Now</th>
                                    </tr>
                                </thead>
                                <tbody>

                        <?php
                            if ($posts) {
                                foreach ($posts as $post) { ?>

                                    <tr id="<?php echo 'pr_' . $post->pr_id; ?>">
                                        <td style="width: 45%;">
                                        <a href="<?php echo 'https://icrowdnewswire.com/' . $post->pr_name; ?>"
                                                target="_blank"> 
                                                <?php echo $post->pr_title; ?>
                                            </a>
                                        </td>

                                        <td><?php echo $post->post_author; ?>
                                            <br>
                                            <div class="sparkbar" data-color="#00a65a" data-height="20">
                                                <?php echo $post->pr_publish_time; ?></div>
                                                
                                        </td>

                                        <?php 
                                          $archive_date = date('Y-m-d H:i:s', strtotime($post->pr_publish_time . ' +29 day'));   
                                          $date_now = date("Y-m-d h:i:s"); 

                                        if ($post->ID) {?>
                                           
                                        <td><span class="badge badge-success">Present</span></td>
                                        <?php } elseif($date_now > $archive_date) {
                                            ?>
                                        <td><span class="badge badge-success">Archive</span></td>
                                        <?php }else{?>
                                        <td><span class="badge badge-danger">Deleted</span></td>
                                        <?php } 

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

                                        <td><span class="badge badge-danger">Not Verified</span></td>

                                    <td>   <button type="button" class="btn btn-success verify_pr_now"
                                                data-toggle="modal" data-target="#modal-default"
                                                id="<?php echo $post->pr_id; ?>">
                                                Verify Now
                                            </button></td>
                                    </tr>

                                    <?php }
                                    }?>

                                </tbody>
                            </table>
                        </div>

                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
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
                <form id="verify_pr_form" method="post">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Verify Pressrelease Now</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body">

                            <div class="form-group col-md-12">
                                <label for="title">Pressrelease ID</label>
                                <input type="text" class="form-control pr_id" disabled>
                                <label for="title">Kiosk ID</label>
                                <input type="text" class="form-control kiosk_id" disabled>
                                <input type="hidden" class="form-control pr_id" name="pr_id" id="pressrelease_id">
                            </div>


                            <div class="form-group row col-md-12">

                                <div class="col-md-10">
                                    <label for="author">Transaction ID</label>
                                    <input type="text" class="form-control" name="transaction_id" id="transaction_id"
                                        autocomplete="off">
                                </div>
                                <div class="col-md-2">
                                    <label for="author">Verify</label>
                                    <button class="btn btn-success" id="paypal_verification">PayPal</button>
                                </div>
                                <span id="message_span"></span>
                                <span class="error" id="error_span"></span>

                            </div>

                            <div class="form-group col-md-12">
                                <label for="author">Coupon</label>
                                <input type="text" class="form-control" name="coupon_code" id="coupon_code"
                                    autocomplete="off">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="author">Additional Comments</label>
                                <textarea class="form-control" rows="3" placeholder="Enter Additional Comments"
                                    name="additional_comments"></textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <div class="form-check radio-button-inline">
                                    <input class="form-check-input" type="radio" name="payment_type" value="Invoice"
                                        checked>
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

                            <div id="none_verified_pr_text"></div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal"
                                id="modal_close_button">Close</button>
                            <button type="submit" class="btn btn-primary">Verify</button>
                        </div>
                    </div>

                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- modal end here -->
        <!-- /.content-wrapper -->
        <?php require_once APPPATH . 'views/inc/footer.php';?>
    </div>
    <!-- ./wrapper -->
    <?php require_once APPPATH . 'views/inc/js_scripts.php';?>
    <script type="text/javascript">
    $(function() {

        $(document).on('click', '.verify_pr_now', function() {
            var pr_id = $(this).attr("id");

            $.ajax({
                url: '<?php echo BASE_URL . 'pressrelease/get_pr_subscription_id/'; ?>',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    pr_id
                },

                success: function(data) {
                    $('.kiosk_id').val(data.subscription_id);
                    $("#coupon_code").val(data.coupon_code);
                },
                error: function(data) {

                }
            }); //ajax end

            $('.pr_id').val(pr_id);
        });

        $(document).on('submit', '#verify_pr_form', function(e) {

            e.preventDefault();

            if ($('#transaction_id').val() == "" && $('#coupon_code').val() == "") {
                $("#none_verified_pr_text").empty().append(
                "Please add either coupon or transaction ID");

            } else {

                let pressrelease_id = $('#pressrelease_id').val();

                $.ajax({
                    url: '<?php echo BASE_URL . 'pressrelease/verify_pressrelease/'; ?>',
                    type: 'POST',
                    data: $('#verify_pr_form').serialize(),

                    success: function(data) {
                        $('#pr_' + pressrelease_id).remove();
                        $('#verify_pr_form')[0].reset();
                        $('#message_span').empty();
                        $('#error_span').empty();
                        $('#modal_close_button').trigger('click');

                    },
                    error: function(data) {
                        $("#none_verified_pr_text").empty().append(
                            '<span class="alert alert-danger alert-dismissible" id="none_verified_pr_text">' +
                            data + '</span>');
                    }
                }); //ajax end
            }


        });


        $('#paypal_verification').click(function() {

            var transaction_id = $("#transaction_id").val();

            $.ajax({
                url: '<?php echo BASE_URL . 'utility/verify_transaction_id_paypal/'; ?>',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    transaction_id
                },

                success: function(data) {
                    if (data.payment_status != 'Null') {
                        $('#error_span').empty();
                        $('#message_span').empty().append('Status = ' + data
                            .payment_status + ' Amount = ' + data.amount);
                    } else {
                        $('#message_span').empty();
                        $('#error_span').empty().append(
                            "PayPal Does Not Verify Transaction ID Please Try Again With Valid ID"
                            );
                    }

                },
                error: function(data) {

                    console.log(data);

                }
            }); //ajax end

            return false;
        });



    }); //function end
    </script>
</body>

</html>