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
                            <form role="form" id="edit_pressrelease" method="post">
                                <input type="hidden" class="hidden" name="post_id" value="<?php echo $post->ID; ?>" id="post_id">
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="post_title" placeholder="Press Release Title" autocomplete="off" name="post_title" value="<?php echo $post->post_title; ?>" required>
                                    </div>

                                    <?php
                                    if ($post->post_name) {
                                        $post_slug = $post->post_name;
                                    } else {
                                        $post_slug = slugify($post->post_title);
                                    }
                                    ?>

                                    <div class="form-group">
                                        <input type="text" class="form-control" id="post_name" placeholder="Press Release Slug" autocomplete="off" name="post_name" value="<?php echo $post_slug; ?>" required>
                                    </div>


                                    <div class="form-group">
                                        <textarea class="form-control cf_description" name="post_content" id="mytextarea" rows="6" style="resize:none">
                    <?php echo $post->post_content; ?></textarea>
                                    </div>

                                    <div class="row">

                                        <div class="form-group col-md-6">
                                            <label for="search">Publish Time</label>
                                            <input type="text" class="form-control" id="post_date" placeholder="Publish time" autocomplete="off" name="post_date" required value="<?php echo $post->post_date; ?>">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="search">Campaign Link</label>
                                            <input type="text" class="form-control" id="c_link" placeholder="Campaign Link" autocomplete="off" name="cf_campaign_link" value="<?php echo $post->cf_campaign_link; ?>">
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label for="search">Kiosk Information</label>
                                            <input type="text" class="form-control" id="Kiosk_information" placeholder="Kiosk Information" autocomplete="off" disabled value="<?php echo get_product_name($post->cf_kiosk_id); ?>">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="search">Package</label>
                                            <input type="text" class="form-control" id="package" placeholder="Package" autocomplete="off" disabled value="<?php echo $post->cf_payGo; ?>">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="search">Post Status</label>
                                            <input type="text" class="form-control" id="status" placeholder="Post Status" autocomplete="off" disabled value="<?php echo $post->post_status; ?>">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="search">Keywords</label>
                                        <textarea class="form-control" name="cf_keywords" rows="1" ><?php echo $post->cf_keywords; ?></textarea>
                                    </div>


                                    <div class="form-group">
                                        <label for="search">Contact Details</label>
                                        <textarea class="form-control" name="cf_cont_info" rows="3"><?php echo $post->cf_cont_info; ?></textarea>
                                    </div>



                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-outline-success" id="update_post_button">Publish</button>
                                    <a href="<?php echo 'https://icrowdnewswire.com/?p=' . $post->ID . '&preview=true'; ?>" target="_blank"><button type="button" class="btn btn-outline-info">Preview</button></a>
                                    <span id="message_span"></span>
                                </div>
                            </form>
                        </div>


                        <!-- /.card -->
                    </div>

                    <div class="col-md-3">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Add Categories</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <form role="form" id="add_categories" method="post" action="#">

                                    <div class="form-group">
                                        <ul id="add_categories_ul">
                                            <?php echo pressrelease_categories($categories->icn_terms); ?>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="pr_id" id="pr_id" value="<?php echo $post->ID; ?>">

                                    <button type="submit" class="btn btn-outline-info" id="add_cate_button">Add Categories</button>
                                </form>

                            </div>

                        </div>

                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Remove Categories</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <form role="form" id="remove_categories" method="post" action="#">
                                    <div class="form-group">

                                        <ul id="remove_categories_ul">
                                            <?php echo selected_pressrelease_categories($categories->icn_terms); ?>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="pr_id" value="<?php echo $post->ID; ?>">

                                    <button type="submit" class="btn btn-outline-danger" id="remove_cate_button">Remove Categories</button>
                                </form>
                            </div>

                        </div>


                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Client Information</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <form role="form" id="client_information_form" method="post" action="#">
                                    <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>">
                                    <input type="hidden" name="kiosk_id" value="<?php echo $post->cf_kiosk_id; ?>">
                                    <input type="hidden" name="post_author" value="<?php echo $post->post_author; ?>">

                                    <button type="submit" class="btn btn-outline-info" id="client_information">Load Client Information </button>
                                </form>
                                <table class="table table-striped">
                                    <tbody id="display_cust_details">

                                    </tbody>
                                </table>

                            </div>
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

            $("#edit_pressrelease").validate({
                ignore: ":hidden",
                rules: {
                    post_name: {
                        required: true,
                        remote: {
                            url: "<?php echo BASE_URL ?>operations/check_unique_slug",
                            type: "post",
                        }
                    },

                },
                messages: {
                    post_name: {
                        required: 'Please Enter Make The Slug Unique.',
                        remote: "This Slug is Already Assign to a Pressrelease Kindly Make it Unique URL"
                    },

                },
            });

            $(document).on('submit', '#add_categories', function(e) {

                e.preventDefault();

                let data = new FormData($('#add_categories')[0]);


                $.ajax({
                    type: 'POST',
                    url: "<?php echo BASE_URL ?>operations/add_categories",
                    contentType: false,
                    processData: false,
                    dataType: 'JSON',
                    data: data,
                    beforeSend: function() {
                        $("#add_cate_button").prop('disabled', true);
                    },
                    success: function(response) {

                        if (response.message == 1) {

                            let items = response.li_ids;
                            items.forEach(function(items) {
                                $('#remove_categories_ul').prepend($('#add_categories_ul #' + items));
                                $(".cate-check").prop('checked', false);
                            });

                            $("#add_cate_button").prop('disabled', false);

                        } else {

                            $("#add_cate_button").prop('disabled', false);

                        }


                    },
                    error: function(xhr, textStatus, errorThrown) {

                    }
                });

            });

            $(document).on('submit', '#remove_categories', function(e) {

                e.preventDefault();

                let data = new FormData($('#remove_categories')[0]);

                $.ajax({
                    type: 'POST',
                    url: "<?php echo BASE_URL ?>operations/remove_categories",
                    contentType: false,
                    processData: false,
                    dataType: 'JSON',
                    data: data,
                    beforeSend: function() {
                        $("#remove_cate_button").prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.message == 1) {

                            let items = response.li_ids;
                            items.forEach(function(items) {
                                $('#add_categories_ul').prepend($('#remove_categories_ul #' + items));
                                $(".cate-check").prop('checked', false);
                            });

                            $("#remove_cate_button").prop('disabled', false);

                        } else {

                            $("#remove_cate_button").prop('disabled', false);

                        }


                    },
                    error: function(xhr, textStatus, errorThrown) {

                    }
                });

            });


            $(document).on('submit', '#edit_pressrelease', function(e) {

                e.preventDefault();

                let data = new FormData($('#edit_pressrelease')[0]);

                $.ajax({
                    type: 'POST',
                    url: "<?php echo BASE_URL . 'operations/update_pending_pressrelease/' . $post->ID ?>",
                    contentType: false,
                    processData: false,
                    data: data,
                    beforeSend: function() {
                        $("#update_post_button").prop('disabled', true);
                    },
                    success: function(response) {
                        console.log(response)
                        if (response == 1) {

                            $("#message_span").text('Press Release has been Updated');
                            $("#update_post_button").prop('disabled', false);

                        } else {

                            $("#message_span").text('Press Release Updation Field');
                            $("#update_post_button").prop('disabled', false);

                        }


                    },
                    error: function(xhr, textStatus, errorThrown) {

                    }
                });

            });

            $(document).on('submit', '#client_information_form', function(e) {

                e.preventDefault();

                let data = new FormData($('#client_information_form')[0]);

                $.ajax({
                    type: 'POST',
                    url: "<?php echo BASE_URL ?>operations/show_client_information",
                    contentType: false,
                    processData: false,
                    dataType: 'JSON',
                    data: data,

                    beforeSend: function() {
                        $("#client_information").prop('disabled', true);
                    },
                    success: function(response) {

                        if (response) {
                            let table = `
                <tr>
                    <td>Name</td>
                    <td>${response.full_name}</td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td>${response.username}</td>
                </tr>
                <tr>
                    <td>User Email</td>
                    <td>${response.email}</td>
                </tr>`;

                            $("#display_cust_details").empty().append(table)
                            $("#client_information").prop('disabled', false);

                        } else {

                            $("#display_cust_details").append("There is an issue while loading Client details")
                            $("#client_information").prop('disabled', false);

                        }


                    },
                    error: function(xhr, textStatus, errorThrown) {

                    }
                });

            });

        });
    </script>
</body>

</html>