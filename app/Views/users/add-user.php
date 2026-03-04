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
              <h1>Add Management Portal Users</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item active">Add User</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- frankly links start here-->
        <?php require_once(APPPATH . 'Views/inc/alerts.php'); ?>
        <!-- Default box -->
        <div class="row">
          <div class="col-md-12">

            <!-- card start here -->

            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Add New User</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form role="form" action="<?php echo BASE_URL . 'users/create-new_user'; ?>" id="create_user" method="post">
                  <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>User Name</label>
                        <input type="text" class="form-control" placeholder="Enter Username" autocomplete="off" name="user_login">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>User Email</label>
                        <input type="email" class="form-control" placeholder="Enter User Email" name="user_email">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="row">
                        <div class="col-sm-8">
                          <div class="form-group">
                            <label>User Password</label>
                            <input type="text" class="form-control" name="user_pass" id="user_pass" placeholder="Enter User Password" autocomplete="off" required>
                          </div>

                        </div>
                        <div class="col-sm-4">
                          <label>Random</label>
                          <button class="btn btn-info d-block" onclick="generatePassword(event)">Gererate Password</button>

                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>User Cell Phone</label>
                        <input type="text" class="form-control" name="cell_phone" placeholder="Enter User Cell-phone" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label>User Role</label>
                        <select class="form-control" name="icn_role" required>
                          <option value="SocialMedia-Staff">SocialMedia-Staff</option>
                          <option value="SEO-Staff">SEO-Staff</option>
                          <option value="Operations-Staff">Operations-Staff</option>
                          <option value="Editor">Editorial-Staff</option>
                          <option value="Sales">Sales-Staff</option>
                          <option value="Stake Holders">Stake Holders</option>
                          <option value="Administrator">Administrator</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">

                        <button class="btn btn-info" id="add-button">Add User</button>
                      </div>
                    </div>


                </form>
              </div>
              <!-- /.card-body -->
            </div>

            <!-- card end here -->


            <!-- /.card -->
          </div>
          <!-- /.col -->


        </div>
        <!-- /.row -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php require_once(APPPATH . 'Views/inc/footer.php'); ?>
  </div>
  <!-- ./wrapper -->
  <?php require_once(APPPATH . 'Views/inc/js_scripts.php'); ?>
  <script type="text/javascript">
    $("#create_user").validate({

      ignore: ":hidden",
      rules: {
        user_login: {
          required: true,
          remote: {
            url: "<?php echo BASE_URL ?>users/check_user_login_ajax",
            type: "post",
          }
        },
        user_email: {
          required: true,
          remote: {
            url: "<?php echo BASE_URL ?>users/check_user_email_ajax",
            type: "post",
          }
        },

      },
      messages: {
        user_login: {
          required: 'Please Enter Username.',
          remote: "This Username is Already Present"
        },
        user_email: {
          required: 'Please Enter Email.',
          remote: "This Email is Already Present"
        }
      },
    });

    function generatePassword(event) {
      event.preventDefault();

      let random_pass = randomPassword(20, false);

      $("#user_pass").val(random_pass);
    }


    function randomPassword(length, special) {

      var iteration = 0;
      var password = "";
      var randomNumber;
      if (special == undefined) {
        var special = false;
      }
      while (iteration < length) {
        randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
        if (!special) {
          if ((randomNumber >= 33) && (randomNumber <= 47)) {
            continue;
          }
          if ((randomNumber >= 58) && (randomNumber <= 64)) {
            continue;
          }
          if ((randomNumber >= 91) && (randomNumber <= 96)) {
            continue;
          }
          if ((randomNumber >= 123) && (randomNumber <= 126)) {
            continue;
          }
        }
        iteration++;
        password += String.fromCharCode(randomNumber);
      }
      return password;

    }
  </script>
</body>

</html>




