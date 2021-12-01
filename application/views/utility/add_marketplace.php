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
                            <h1>Marketplace </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                                <li class="breadcrumb-item active">Add Marketpalce</li>
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
                        <h3 class="card-title">Add marketplace</h3>
                    </div>
                    <?php if ($this->session->flashdata('success-message') != ''){?>
                    <div class="alert alert-success mt-2" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo ($this->session->flashdata('success-message'));
                                ?>
                        </div>
                       <?php }?> 
                    <?php if ($this->session->flashdata('error-message') != ''){?>  
                    <div class="alert alert-danger  mt-2" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php  echo ($this->session->flashdata('error-message'));
                                ?>
                    </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('validation_failed') != ''){?>  
                    <div class="alert alert-warning  mt-2" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php  echo ($this->session->flashdata('validation_failed'));
                                ?>
                    </div>
                    <?php } ?>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form role="form" method="post" action="<?php echo BASE_URL . 'utility/create_marketplace'; ?>" id="validate_marketplace">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Post id</label>
                                        <input type="text" class="form-control" placeholder="Enter Post ID" autocomplete="off" name="post_id" required>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Add Marketplace URL</label>
                                        <textarea class="form-control" rows="3" placeholder="Add URL for market place" name="market_place_url" required></textarea>
                                    </div>
                                </div>

                            </div>

                            <button class="btn btn-primary" type="submit" id="create_marketplace">Add Marketplace</button>

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

</body>

</html>