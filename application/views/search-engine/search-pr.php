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
              <h1>Search Pressrelease </h1>
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
        <?php require_once(APPPATH . 'views/inc/alerts.php'); ?>
        <!-- Default box -->
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Search Pressrelease In Archive</h3>
              </div>

              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="search_archive_pr" method="post" action="<?php echo BASE_URL . 'search-engine/search_archive_pressrelease' ?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="search">Pressrelease Name</label>
                    <input type="text" class="form-control" id="post_name" placeholder="Enter Pressrelease Name" autocomplete="off" name="post_name" required>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Search</button>
                </div>
              </form>

              <?php
              if (!empty($post)) { ?>
                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th style="width: 62%;">Title</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr>
                        <td><?php echo $post->ID ?></td>
                        <td><?php echo $post->post_title ?></td>
                        <td>
                        <a href="<?php echo BASE_URL.'search-engine/edit-pressrelease/'.$post->ID; ?>"><button type="button" class="btn btn-primary">Edit Post</button></a>
                        <a href="<?php echo 'https://examplenewswire.com/' . $post->post_name; ?>" target="_blank"><button type="button" class="btn btn-info">View Post</button></a>
                        <a href="<?php echo BASE_URL . 'search-engine/delete-archive-pr/'.$post->ID ?>"  onclick="return confirm('Are you sure to delete the Press Release? You will not be able to recover it.');"><button type="button" class="btn btn-danger">Delete Post</button></a>
                        
                      </td>
                      </tr>

                  </tbody>
                </table>
              <?php
              } ?>
            </div>


            <!-- /.card -->
          </div>
          <!-- /.col -->


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



  </script>
</body>

</html>