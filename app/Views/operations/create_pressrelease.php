<?php require_once APPPATH . 'Views/inc/head.php';?>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once APPPATH . 'Views/inc/header.php';?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->

        <?php require_once APPPATH . 'Views/inc/sidebar.php';?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Edit Press Release </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Edit Pressrelease</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <?php //var_dump($categories);
?>

            <!-- Main content -->
            <section class="content">

                <!-- frankly links start here-->

                <!-- Default box -->
                <div class="row">
                    <div class="col-md-9">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Edit Press Release</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" id="create_pressrelease" method="post" action="<?php echo BASE_URL.'operations/create-pr-preview' ?>">
                                <input type="hidden" class="hidden" name="post_id" id="post_id">
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="post_title" placeholder="Press Release Title" autocomplete="off" name="post_title"  required>
                                    </div>

                                    <div class="form-group">
                                        <textarea class="form-control cf_description" name="post_content" id="mytextarea" rows="6" style="resize:none"></textarea>
                                    </div>

                                    <div class="row">

                                        <div class="form-group col-md-6">
                                            <label for="search">Publish Time</label>
                                            <input type="text" class="form-control" id="post_date" placeholder="Publish time" autocomplete="off" name="post_date" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="search">Campaign Link</label>
                                            <input type="text" class="form-control" id="c_link" placeholder="Campaign Link" autocomplete="off" name="cf_campaign_link">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="search">Keywords</label>
                                        <textarea class="form-control" name="cf_keywords" rows="1"></textarea>
                                    </div>


                                    <div class="form-group">
                                        <label for="search">Contact Details</label>
                                        <textarea class="form-control" name="cf_cont_info" rows="3"></textarea>
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-outline-info" id="update_post_button">Pending Review</button>
                                </div>
                            </form>
                        </div>


                        <!-- /.card -->
                    </div>

                    <div class="col-md-3">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title" style="height:21px"></h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                      

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
        <?php require_once APPPATH . 'Views/inc/footer.php';?>
    </div>
    <!-- ./wrapper -->
    <?php require_once APPPATH . 'Views/inc/js_scripts.php';?>
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
                    title: 'H1',
                    block: 'h1',

                },
                {
                    title: 'H2',
                    block: 'h2',

                },
                {
                    title: 'H3',
                    block: 'h3',

                },
                {
                    title: 'H4',
                    block: 'h4',

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

        $(function() {

          //Initialize Select2 Elements
          $("#post_date").datetimepicker({
            format: 'Y-m-d H:i:s',

          });


          $("#create_pressrelease").validate({
                ignore: ":hidden",
               
            });


        });


    </script>
</body>

</html>




