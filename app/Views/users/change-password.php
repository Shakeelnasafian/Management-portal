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
  <link rel="stylesheet" href="<?php echo ASSETS; ?>css/theme-default.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <style>
  .input-group>.form-control {
    width: 100%;
}
  </style>
</head>

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  <a href="<?php echo BASE_URL; ?>"><b>example</b>Management</a>
  </div>

   <!-- message -->
   <?php if (session()->getFlashdata('password_changed')) : ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
        <h5></i>Email Sent!</h5>
        <?php echo session()->getFlashdata('password_changed'); ?>
      </div>
    <?php endif; ?>

    <!-- message -->
   <?php if (session()->getFlashdata('password_error')) : ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
        <h5></i>Email Sent!</h5>
        <?php echo session()->getFlashdata('password_error'); ?>
      </div>
    <?php endif; ?>

  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

      <form action="<?php echo BASE_URL.'users/update-password' ?>" method="post" id="reset_password">
        
          <input type="hidden" name="user_token" value="<?php echo $secret_string; ?>">
          <div class="input-group mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password">
         
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
        
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Change password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="<?php echo BASE_URL; ?>">Login</a>
      </p>
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

  <script src="<?php echo ASSETS ?>js/jquery.validate.min.js"></script>

  <script type="text/javascript">

        $("#reset_password").validate({

            ignore: ":hidden",
            rules: {
              password: {
                    required: true,
                    minlength: 6,
            },
            confirm_password: {
                    required: true,
                    equalTo: '#password',
            },
        },
           
        });

</script>
</body>

</html>




