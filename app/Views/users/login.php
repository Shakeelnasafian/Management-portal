<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo SITE_NAME; ?> | <?= $title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo ASSETS_ADMIN_LTE; ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo ASSETS_ADMIN_LTE; ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo ASSETS_ADMIN_LTE; ?>dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="<?php echo BASE_URL; ?>"><b>example</b>Management</a>
    </div>

    <!-- message -->
    <?php if (session()->getFlashdata('login_failed')) : ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
        <h5><i class="icon fas fa-ban"></i>Credentials does not match!</h5>
        <?php echo session()->getFlashdata('login_failed'); ?>
      </div>
    <?php endif; ?>
    <!-- message -->

    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to view your dashboard</p>

        <?php echo validation_list_errors(); ?>
        <form method="post" action="<?php echo BASE_URL; ?>users/login">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="username" name="username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <!-- /.col -->

            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <a href="<?php echo BASE_URL.'users/forgot-password'; ?>">Lost Password?</a>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?php echo ASSETS_ADMIN_LTE; ?>plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo ASSETS_ADMIN_LTE; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo ASSETS_ADMIN_LTE; ?>dist/js/adminlte.min.js"></script>

</body>

</html>




