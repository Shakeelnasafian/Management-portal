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
              <h1>Update Pressrelease </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Update Pressrelease</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <?php //var_dump($post); 
      ?>

      <!-- Main content -->
      <section class="content">

        <!-- frankly links start here-->

        <!-- Default box -->
        <div class="row">
          <div class="col-md-12">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Update Pressrelease</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="search_archive_pr" method="post" action="<?php echo BASE_URL . 'search-engine/update_archive_pressrelease/' . $post->ID ?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="search">Pressrelease Title</label>
                    <input type="text" class="form-control" id="post_title" placeholder="Enter Pressrelease Name" autocomplete="off" name="post_title" value="<?php echo $post->post_title; ?>" required>
                  </div>



                  <div class="form-group">
                    <label for="search">Pressrelease Content</label>
                    <textarea class="form-control cf_description" name="post_content" id="mytextarea" rows="6" style="resize:none">
                    <?php echo $post->post_content; ?></textarea>
                  </div>


                  <div class="form-group">
                    <label for="search">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" placeholder="Enter Meta Title" autocomplete="off" name="meta_title" value="<?php echo $post->meta_title; ?>" required>
                  </div>

                  <div class="form-group">
                    <label for="search">Meta Description</label>
                    <textarea class="form-control" name="meta_description" id="mytextarea" rows="4" required><?php echo $post->meta_description; ?></textarea>
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-info">Update</button>
                </div>
              </form>
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
  <script src="<?php echo ASSETS ?>tinymce/tinymce.min.js"></script>
  <script type="text/javascript">
    tinymce.init({
      selector: "#mytextarea",
      theme: "modern",
      width: '100%',
      ignore: '',
      height: 600,
      plugins: [
        "advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor responsivefilemanager code"
      ],
      toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent |  print preview media fullpage | forecolor backcolor emoticons",
      toolbar2: "| link unlink anchor | forecolor backcolor  | print preview code ",
      toolbar3: "| responsivefilemanager",
      image_advtab: true,
      relative_urls: false,
      convert_urls: false,
      external_filemanager_path: "<?php echo ASSETS ?>filemanager/",
      filemanager_title: "Filemanager",
      external_plugins: {
        "filemanager": "<?php echo ASSETS ?>tinymce/plugins/responsivefilemanager/plugin.min.js"
      },
      style_formats: [{
          title: 'Bold text',
          inline: 'b'
        },
        {
          title: 'Red text',
          inline: 'span',
          styles: {
            color: '#ff0000'
          }
        },
        {
          title: 'Red header',
          block: 'h1',
          styles: {
            color: '#ff0000'
          }
        },
        {
          title: 'Example 1',
          inline: 'span',
          classes: 'example1'
        },
        {
          title: 'Example 2',
          inline: 'span',
          classes: 'example2'
        },
        {
          title: 'Table styles'
        },
        {
          title: 'Table row 1',
          selector: 'tr',
          classes: 'tablerow1'
        }
      ]
    });
  </script>
</body>

</html>