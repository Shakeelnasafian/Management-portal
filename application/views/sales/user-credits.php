<?php require_once APPPATH . 'views/inc/head.php';?>

<body class="hold-transition sidebar-mini">

    <div class="wrapper">
        <?php require_once APPPATH . 'views/inc/header.php';?>

        <?php require_once APPPATH . 'views/inc/sidebar.php';?>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>iCN Sales</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
                                <li class="breadcrumb-item active">Users Credits</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">

                <div class="card">
                    <div class="card-header border-transparent" style="background: #D4EDDA;">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="card-title">Users Credits</h3>
                            </div>

                            <div class="col-md-6">
                            <form action="<?php echo BASE_URL . 'sales/credits-filters' ?>" method="post">

                            <div class="row">
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="user_email" placeholder="Search By User Email" autocomplete="off">
                                </div>

                                <div class="col-md-2">
                                    <button class="btn btn-outline-dark">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>

                        </div>
                    </div>

                    <div class="card-body p-0" id="app">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Author ID</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Total Credits</th>
                                        <th>Used Credits</th>
                                        <th>Remaining Credits</th>
                                        <th>Package</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                    if ($credits) {
                                        foreach ($credits as $user) {
                                            ?>
                                            <tr>
                                                <td>
                                                <?php echo $user->user_id ?>
                                                </td>

                                                <td>
                                                <?php echo $user->user_login ?>
                                                </td>

                                                <td>
                                                <?php echo $user->user_email ?>
                                                </td>

                                                <td>
                                                <?php echo $user->total_credit ?>
                                                </td>

                                                <td>
                                                <?php echo $user->current_credit ?>
                                                </td>

                                                <td>
                                                <?php echo $user->total_credit - $user->current_credit ?>
                                                </td>

                                                <td>
                                                <?php
                                                    if ($user->package_selected == 3) {
                                                                echo 'Ultimate';
                                                            } elseif ($user->package_selected == 3) {
                                                                echo 'Premium';
                                                            } else {
                                                                echo 'Standard';
                                                            }
                                                            ?>
                                                </td>

                                                <td>
                                                <?php echo $user->subscription_date ?>
                                                </td>

                                            </tr>

                                    <?php }
                                            }else{ ?>
                                                <tr rowspan="3">
                                                 <td colspan="8" style="text-align: center;">
                                                  It seems we haven't any user against this email
                                                </td>                                              
                                                </tr>
                                               
                                         <?php   }?>


                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <?php echo $this->pagination->create_links() . ' Total Result <a data-ci-pagination-page="" style="width: 100px !important;">' . $total_rows . '</a>'; ?>
                    </div>
                </div>
            </section>
        </div>

        <?php require_once APPPATH . 'views/inc/footer.php';?>
    </div>
    <?php require_once APPPATH . 'views/inc/js_scripts.php';?>

</body>

</html>