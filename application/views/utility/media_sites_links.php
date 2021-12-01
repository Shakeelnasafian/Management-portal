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
              <h1>Search Media Sites Links</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Search Pressrelease</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- frankly links start here-->

        <!-- Default box -->
        <div class="row">
          <div class="col-md-4">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Search Frankly Links</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="search_frankly_links">
                <div class="card-body">
                  <div class="form-group">
                    <label for="search">Post ID</label>
                    <input type="number" class="form-control" id="post_id" placeholder="Enter Pressrelease ID" autocomplete="off" name="post_id" required>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Search</button>
                </div>
              </form>
            </div>

            <!-- bigpond start here -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Search BigPond Links</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="search_bignews_links">
                <div class="card-body">
                  <div class="form-group">
                    <label for="search">Post ID</label>
                    <input type="number" class="form-control" id="post_id" placeholder="Enter Pressrelease ID" autocomplete="off" name="post_id" required>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Search</button>
                </div>
              </form>
            </div>
            <!-- bigpond end here -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Frankly Links will Apprear Here</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th style="width: 10px">Links</th>

                    </tr>
                  </thead>
                  <tbody id="frankly_links_table">

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>

        </div>
        <!-- /.row -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php require_once(APPPATH . 'views/inc/footer.php'); ?>
  </div>
  <!-- ./wrapper -->
  <?php require_once(APPPATH . 'views/inc/js_scripts.php'); ?>
  <script type="text/javascript">
    $(document).on('submit', '#search_frankly_links', function(e) {


      e.preventDefault();

      $.ajax({
        url: '<?php echo BASE_URL . 'utility/search_frankly_links'; ?>',
        type: 'POST',
        data: $('#search_frankly_links').serialize(),

        success: function(data) {
          console.log(data);

          $("#frankly_links_table").append(data);
        },
        error: function(data) {
          console.log(data);
        }
      });
    });



    $(document).on('submit', '#search_bignews_links', function(e) {


      e.preventDefault();

      $.ajax({
        url: '<?php echo BASE_URL . 'utility/search_bignews_links'; ?>',
        type: 'POST',
        data: $('#search_bignews_links').serialize(),

        success: function(data) {
          console.log(data);

          $("#frankly_links_table").append(data);
        },
        error: function(data) {
          console.log(data);
        }
      });
    });
  </script>
</body>

</html>