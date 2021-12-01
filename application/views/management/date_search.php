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
                            <h1>Management Date Searching</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>>">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <!-- content -->
                <div class="row">

                    <div class="col-lg-4 col-4">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Total Pressreleases </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Date</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="total_pr_date" name="total_pr" placeholder="Select Date" autocomplete="off" required>
                                    </div>
                                </div>
                                <div id="total_pr_text">

                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info" id="total_pr_button">Search</button>

                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </div>

                    <div class="col-lg-4 col-4">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Verified Pressreleases </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Date</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="verified_pr" name="verified_pr" placeholder="Select Date" autocomplete="off" required>
                                    </div>
                                </div>
                                <div id="verified_pr_text">

                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success" id="verifed_pr_button">Search</button>

                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </div>

                    <div class="col-lg-4 col-4">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">None Verified Pressreleases </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Date</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="none_verified_pr" name="none_verified_pr" placeholder="Select Date" autocomplete="off" required>
                                    </div>
                                </div>

                                <div id="none_verified_pr_text">

                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-danger" id="none_verifed_pr_button">Search</button>

                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </div>



                </div>

                <div class="row">

                    <div class="col-lg-4 col-4">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Press Releases Went to Frankly </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Date</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="frankly_pr" name="frankly_pr" placeholder="Select Date" autocomplete="off" required>
                                    </div>
                                </div>
                                <div id="frankly_pr_text">

                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info" id="frankly_pr_button">Search</button>

                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </div>

                    <div class="col-lg-4 col-4">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Press Releases Went to BigNews</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Date</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="bignews_pr" name="bignews_pr" placeholder="Select Date" autocomplete="off" required>
                                    </div>
                                </div>
                                <div id="bignews_pr_text">

                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success" id="bignews_pr_button">Search</button>

                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </div>

                    <div class="col-lg-4 col-4">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Press Releases Went to Financial Content</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Date</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="financial_pr" name="financial_pr" placeholder="Select Date" autocomplete="off" required>
                                    </div>
                                </div>
                                <div id="financial_pr_text">

                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-secondary" id="financial_pr_button">Search</button>

                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </div>




                </div>

                <!-- content ends -->

            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php require_once(APPPATH . 'views/inc/footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <?php require_once(APPPATH . 'views/inc/js_scripts.php'); ?>
    <script type="text/javascript">
        $(document).on('click', '#total_pr_button', function() {

            var select_date = $("#total_pr_date").val();

            $.ajax({
                url: '<?php echo BASE_URL; ?>management/total_pressrelease_search_ajax/',
                type: 'POST',
                data: {
                    select_date
                },
                success: function(data) {
                    console.log(data);
                    $("#total_pr_text").append(data);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });


        $(document).on('click', '#verifed_pr_button', function() {

            var select_date = $("#verified_pr").val();

            $.ajax({
                url: '<?php echo BASE_URL; ?>management/verified_pressrelease_search_ajax/',
                type: 'POST',
                data: {
                    select_date
                },
                success: function(data) {
                    console.log(data);
                    $("#verified_pr_text").append(data);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });


        $(document).on('click', '#none_verifed_pr_button', function() {

            var select_date = $("#none_verified_pr").val();

            $.ajax({
                url: '<?php echo BASE_URL; ?>management/none_verified_pressrelease_search_ajax/',
                type: 'POST',
                data: {
                    select_date
                },
                success: function(data) {
                    console.log(data);
                    $("#none_verified_pr_text").append(data);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });


        $(document).on('click', '#frankly_pr_button', function() {

            var select_date = $("#frankly_pr").val();

            $.ajax({
                url: '<?php echo BASE_URL; ?>management/frankly_pressrelease_search_ajax/',
                type: 'POST',
                data: {
                    select_date
                },
                success: function(data) {
                    console.log(data);
                    $("#frankly_pr_text").append(data);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });


        $(document).on('click', '#bignews_pr_button', function() {

            var select_date = $("#bignews_pr").val();

            $.ajax({
                url: '<?php echo BASE_URL; ?>management/bignews_pressrelease_search_ajax/',
                type: 'POST',
                data: {
                    select_date
                },
                success: function(data) {
                    console.log(data);
                    $("#bignews_pr_text").append(data);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $(document).on('click', '#financial_pr_button', function() {

            var select_date = $("#financial_pr").val();

            $.ajax({
                url: '<?php echo BASE_URL; ?>management/financial_pressrelease_search_ajax/',
                type: 'POST',
                data: {
                    select_date
                },
                success: function(data) {
                    console.log(data);
                    $("#financial_pr_text").append(data);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    </script>
</body>

</html>