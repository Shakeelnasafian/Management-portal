<?php require_once(APPPATH . 'views/inc/head.php'); ?>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <?php //var_dump($social_media_data); ?>
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
              <h1>iCN Reporting</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item active">Update Report</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      
      <div class="post_title">
        <?php echo get_post_title_reporting($post_id); ?>
      </div>
      <!-- Main content -->
      <section class="content">

        <div class="card card-success ">
          <div class="card-header main-container-header">
            <h3 class="card-title">Update Master Distribution Report</h3>
          </div>
          <!-- /.card-header main container  -->

          <div class="main-content-area">

            <!-- row start here-->
            <div class="row">
              <div class="col-md-6">
              <form id="campaign_summary_form" name="campaign_summary_form" method="post"  action="#">
                <div class="card card-info">
                  <div class="card-header first-row">
                    <h3 class="card-title">Campaign Summary</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Achieved Views</label>
                          <input type="number" class="form-control" name="AI" id="campaign_AI" value="<?php echo @$campaign_summary[0]['value']; ?>" placeholder="Enter Achieved Views" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Total Clicks</label>
                          <input type="number" class="form-control" name="TC" id="campaign_TC" value="<?php echo @$campaign_summary[1]['value']; ?>" placeholder="Enter Total Clicks">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label>Potential Audience</label>
                            <input type="number" class="form-control" name="PA" id="campaign_PA" placeholder="Enter Potential Audience" value="<?php echo @$campaign_summary[2]['value']; ?>" autocomplete="off">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Exact Matches</label>
                            <input type="number" class="form-control" name="EM" id="campaign_EM" value="<?php echo @$campaign_summary[3]['value']; ?>" placeholder="Enter Exact Matches">
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info first-row" id="campaign_summary" onclick="saveCampaignSummary(event)">Save Campaign Summary</button>
                    <span id="CS_note"></span>
                  </div>
                  <!-- /.card-body -->
                </div>
              </form>

              </div>
              <div class="col-md-6">
              <form id="targeted_keywords_form" name="targeted_keywords_form" method="post"  action="#">
                <div class="card card-info">
                  <div class="card-header first-row">
                    <h3 class="card-title">Targeted Keywords</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Targeted Keywords </label>
                          <input type="text" class="form-control" id="keywords" placeholder="Enter Targeted Keywords" autocomplete="off" value="<?php echo implode(',' , @$keywords_targeted); ?>">
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info first-row" onclick="saveTargetedKeywords(event)">Save Targeted Keywords</button>
                    <span id="TKW_note"></span>  
                  </div>
                  <!-- /.card-body -->
                </div>

              </form>
              </div>
            </div>
            <!--row end here-->


            <!-- row start here-->
            <div class="row">
              <div class="col-md-6">
              <form id="targeting_information_form" name="targeting_information_form" method="post"  action="#">
                <div class="card card-info">
                  <div class="card-header second-row">
                    <h3 class="card-title">Targeting Information</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-7">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Geographic Targeting</label>
                          <input type="text" class="form-control" name="geoT" id="geoT" value="<?php echo @$targeting_information[0]['geoT']; ?>" placeholder="Enter Geographic Targeting" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <label>Age Group</label>
                          <input type="text" class="form-control" name="ageGroup" value="<?php echo @$targeting_information[0]['ageGroup']; ?>" id="ageGroup" placeholder="Enter Age Group">
                        </div>
                      </div>
                    </div>

                    <div class="row">

                    <?php 
                        $networks =  @$targeting_information[1]['Tnetworks'];
                        $facebook  = '';
                        $google    = '';
                        $linkdin   = '';

                        if (in_array("Facebook", $networks)) {
                            $facebook ='Checked';
                        }
                        if (in_array("Google", $networks)) {
                            $google ='Checked';
                        }
                        if (in_array("LinkedIn", $networks)) {
                            $linkdin ='Checked';
                        }    
                    ?>
              
                      <div class="col-sm-7">
                        <label for="">Targeted Networks</label>
                        <div class="form-group">
                          <div class="custom-control custom-checkbox checkbox-inline">
                            <input class="custom-control-input Tnetworks" type="checkbox" id="facebook" name="Facebook" value="Facebook" <?php echo $facebook ?>>
                            <label for="facebook" class="custom-control-label">Facebook</label>
                          </div>
                          <div class="custom-control custom-checkbox checkbox-inline">
                            <input class="custom-control-input Tnetworks" type="checkbox" id="google" name="Google" value="Google" <?php echo $google ?>>
                            <label for="google" class="custom-control-label">Google</label>
                          </div>
                          <div class="custom-control custom-checkbox checkbox-inline">
                            <input class="custom-control-input Tnetworks" type="checkbox" id="linkedIn" name="LinkedIn" value="LinkedIn" <?php echo $linkdin ?>>
                            <label for="linkedIn" class="custom-control-label">LinkedIn</label>
                          </div>
                        </div>
                      </div>

                      <?php 
                        $male ='';
                        $female='';
                        if(@$targeting_information[0]['Gender'] == 0){
                            $female ='Checked';
                        }elseif(@$targeting_information[0]['Gender'] == 1){
                            $male ='Checked';
                        }else{
                            $male ='Checked';
                            $female ='Checked';
                        }
                    
                    ?>

                      <div class="col-sm-5">
                        <!-- text input -->
                        <label for="">Gender</label>
                        <div class="form-group">
                          <div class="custom-control custom-checkbox radio-button-inline-no-top">
                            <input class="custom-control-input" type="checkbox" id="female" name="Female" value="0" <?php echo $female ?>>
                            <label for="female" class="custom-control-label">Female</label>
                          </div>
                          <div class="custom-control custom-checkbox radio-button-inline-no-top">
                            <input class="custom-control-input" type="checkbox" id="male" name="Male" value="1" <?php echo $male ?>>
                            <label for="male" class="custom-control-label">Male</label>
                          </div>
                        </div>
                      </div>

                    </div>

                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info second-row" onclick="saveTargetingInformation(event)">Targeting Information</button>
                    <span id="TI_note"></span>
                  </div>
                </form>
                  <!-- /.card-body -->
                </div>

              </div>
              <div class="col-md-6">
             <form id="facebook_campaign_form" name="facebook_campaign_form" method="post" enctype="multipart/form-data" action="#">
                <div class="card card-info">
                  <div class="card-header second-row">
                    <h3 class="card-title">Facebook Campaign Summary</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Achieved Views </label>
                          <input type="number" class="form-control" name="fbAI" id="fbAI" value="<?php echo @$fb_campaign_summary[0]['fbAI'] ?>" placeholder="Enter Achieved Views" autocomplete="off">
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Total Link Clicks </label>
                          <input type="number" class="form-control" name="fbTLC" id="fbTLC" value="<?php echo @$fb_campaign_summary[0]['fbTLC'] ?>" placeholder="Enter Total Link Clicks" autocomplete="off">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="fbDI">Demographic information Image</label>
                          <input type="file" class="form-control-file" id="fbDI" name="fbDI">
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="fbAPI">Ad Preview Image</label>
                          <input type="file" class="form-control-file" id="fbAPI" name="fbAPI">
                        </div>
                      </div>

                    </div>
                    <?php echo @$fb_campaign_summary[1][0]['url'].'<br>' ?>
                    <?php echo @$fb_campaign_summary[1][1]['url'].'<br>' ?>

                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info second-row" id="facebook_campgain_sumary" onclick="saveFacebookCampaignSummary(event)">Facebook Campaign Summary</button>
                    <span id="FB_note"></span>
                  </div>
                  <!-- /.card-body -->
                </div>

                </form>
              </div>
            </div>
            <!--row end here-->



            <!-- row start here-->
            <div class="row">
              <div class="col-md-6">
              <form id="google_campaign_form" name="google_campaign_form" method="post" enctype="multipart/form-data" action="#">
                <div class="card card-info">
                  <div class="card-header third-row">
                    <h3 class="card-title">Google Adwords Ads Campaign Summary</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Achieved Views</label>
                          <input type="number" class="form-control" name="gAI" id="gAI" value="<?php echo @$gaw_campaign_summary[0]['gAI'] ?>" placeholder="Enter Achieved Views" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Total Link Clicks</label>
                          <input type="number" class="form-control" name="gTLC" id="gTLC" value="<?php echo @$gaw_campaign_summary[0]['gTLC'] ?>" placeholder="Enter Total Clicks">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="fbDI">Graph Image</label>
                          <input type="file" class="form-control-file" id="GIfile" name="GIfile">
                        </div>
                      </div>
                    </div>
                    <?php echo @$gaw_campaign_summary[1][0]['url'].'<br>' ?>

                  </div>

                  <div class="card-footer">
                    <button type="submit" class="btn btn-info third-row" id="google_campaign_summary" onclick="saveGoogleCampaignSummary(event)">Save Google Campaign Summary</button>
                    <span id="GCS_note"></span>
                  </div>
                  <!-- /.card-body -->
                </div>
              </form>
              </div>
              <div class="col-md-6">

              <form id="linkedin_campaign_form" name="linkedin_campaign_form" method="post" enctype="multipart/form-data" action="#">
                <div class="card card-info">
                  <div class="card-header third-row">
                    <h3 class="card-title">Linkedin Campaign Summary</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Achieved Views </label>
                          <input type="text" class="form-control" id="linkAI" name="linkAI" value="<?php echo @$link_campaign_summary[0]['linkAI'] ?>" placeholder="Enter Achieved Views" autocomplete="off">
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Total Link Clicks </label>
                          <input type="text" class="form-control" id="linkTLC" value="<?php echo @$link_campaign_summary[0]['linkTLC'] ?>" name="linkTLC" placeholder="Enter Total Link Clicks" autocomplete="off">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="fbDI">Graph information Image</label>
                          <input type="file" class="form-control-file" id="linkDI" name="linkDI">
                        </div>
                      </div>

                      <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="fbAPI">Job Functions</label>
                          <input type="file" class="form-control-file" id="linkAPI" name="linkAPI">
                        </div>
                      </div>

                      <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="fbAPI">Locations</label>
                          <input type="file" class="form-control-file" id="linkLOC" name="linkLOC">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="fbAPI">Ad Preview</label>
                          <input type="file" class="form-control-file" id="linkAP" name="linkAP">
                        </div>
                      </div>

                    </div>

                    <?php echo @$link_campaign_summary[1][0]['url'].'<br>' ?>
                    <?php echo @$link_campaign_summary[1][1]['url'].'<br>' ?>
                    <?php echo @$link_campaign_summary[1][2]['url'].'<br>' ?>
                    <?php echo @$link_campaign_summary[1][3]['url'].'<br>' ?>


                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info second-row" id="linkedin_campaign_summary" onclick="saveLinkedinCampaignSummary(event)">Linkedin Campaign Summary</button>
                    <span id="LinkCS_note"></span>
                  </div>
                  <!-- /.card-body -->
                </div>

              </form>
              </div>
            </div>
            <!--row end here-->

            <div class="row">
             
              <div class="col-md-6">

              <form id="lexusnexus_campaign_form" name="lexusnexus_campaign_form" method="post" enctype="multipart/form-data" action="#">
                <div class="card card-info">
                  <div class="card-header third-row">
                    <h3 class="card-title">Lexis Nexis and Factiva Summary</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="lnDI">Lexis Nexis Image</label>
                          <input type="file" class="form-control-file" id="LNfile" name="LNfile">
                        </div>
                      </div>
                        <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="ftDI">Factiva Image</label>
                          <input type="file" class="form-control-file" id="FTfile" name="FTfile">
                        </div>
                      </div>
                    </div>

                    <?php echo @$ln_ft_campaign_summary[0][0]['url'].'<br>' ?>
                    <?php echo @$ln_ft_campaign_summary[0][1]['url'].'<br>' ?>

                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info third-row" id="lexusnexus_factiva_campaign_summary" onclick="saveLexusNexusFactivaSummary(event)">Save Lexis Nexis & Factiva Summary</button>
                    <span id="Ln_Ft_note"></span>
                  </div>
                  <!-- /.card-body -->
                </div>

              </form>
              </div>
               <div class="col-md-6">
                <form id="google_index_form" name="google_index_form" method="post" enctype="multipart/form-data" action="#">
                 <div class="card card-info"> 
                    <div class="card-header third-row">
                      <h3 class="card-title">Google Indexing</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="row">
                       <div class="col-md-12">
                          <div class="form-group">
                            <label for="GII">Google index Image</label>
                            <input type="file" class="form-control-file" id="GIIfile" name="GIIfile">
                          </div>
                        </div>
                       
                    </div>
                     <?php echo @$goog_ind_campaign_summary[0][0]['url'].'<br>' ?>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-info third-row" id="google_index_campaign_summary" onclick="saveGoogleIndexSummary(event)">Save Google index Summary</button>
                      <span id="GII_note"></span>
                    </div>
                    <!-- /.card-body -->
                  </div>
                    </form>
              </div>
            </div>
            <!--row end here-->

          <!-- row start here-->
          <div class="row">
            <div class="col-md-12">
              <form id="premium_website_form" name="premium_website_form" method="post" enctype="multipart/form-data" action="#">
                <div class="card card-info ">
                  <div class="card-header fourth-row">
                    <h3 class="card-title">Premium Website Data</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Achieved Views</label>
                          <input type="number" class="form-control" name="pwAI" id="pwAI" placeholder="Enter Achieved Views" value="<?php echo @$premium_website_summary[0]['pwAI'] ?>" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label>Total Clicks</label>
                          <input type="number" class="form-control" name="pwTLC" id="pwTLC" placeholder="Enter Total Clicks" value="<?php echo @$premium_website_summary[0]['pwTLC'] ?>">
                        </div>
                      </div>

                      <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="fbDI">Graph Image</label>
                          <input type="file" class="form-control-file" id="pwfile" name="pwfile">
                        </div>
                      </div>

                    </div>

                    <div class="row">
                      <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="fbDI">Ad Preview Image</label>
                          <input type="file" class="form-control-file" id="pwaddPrev" name="pwaddPrev">
                        </div>
                      </div>

                      <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="fbAPI">Premium Websites Mockups</label>
                          <input type="file" class="form-control-file" id="pwfinance" name="pwfinance">
                        </div>
                      </div>

                      <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="fbAPI">Ad Creatives</label>
                          <input type="file" class="form-control-file" id="pwnytimes" name="pwnytimes">
                        </div>
                      </div>
                    </div>

                    <?php 
                        echo @$premium_website_summary[1][0]['url'].'<br>';
                        echo @$premium_website_summary[1][1]['url'].'<br>';
                        echo @$premium_website_summary[1][2]['url'].'<br>';
                        echo @$premium_website_summary[1][3]['url'].'<br>';
                    ?>

                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info fourth-row" id="premium_website_data" onclick="savePremiumWebsiteData(event)">Save Premium Website Data</button>
                    <span id="PWD_note"></span>
                  </div>
                  <!-- /.card-body -->
                </div>
              </form>

            </div>
          </div>
          <!--row end here-->

          <!-- row start here-->
          <div class="row">
            <div class="col-md-12">
              <form id="website_targeted_reports_stats_form" name="website_targeted_reports_stats_form" method="post" enctype="multipart/form-data" action="#">
                <div class="card card-info ">
                  <div class="card-header">
                    <h3 class="card-title">Website Targeted Reports Stats</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">

                  <?php  
                  $name_array = explode(',',@$website_targeted_reports_stats[0]['site_name']);
                  $views_array = explode(',',@$website_targeted_reports_stats[0]['achived_views']);
                  $logo_array = explode(',',@$website_targeted_reports_stats[0]['logo']);
                  $clicks_array = explode(',',@$website_targeted_reports_stats[0]['achived_clicks']);
          
                  ?>

                    <div class="row">
                    
                      <div class="col-sm-2">
                        <label>Site Logo</label>
                        <input type="file" class="form-control-file" id="logo1" name="logo1" >
                        <?php echo $logo_array[0]?>
                      </div>
                      <div class="col-sm-4">
                        <label>Site Name</label>
                        <input type="text" class="form-control site_name"  name="site_name[]" placeholder="Site One Name" value="<?php echo @$name_array[0]; ?>" autocomplete="off">
                      </div>
                      <div class="col-sm-3">
                        <label>Achieved Impressions</label>
                        <input type="text" class="form-control achived_views"  name="achived_views[]" placeholder="Achieved Impressions" value="<?php echo @$views_array[0]; ?>" autocomplete="off">
                      </div>
                      <div class="col-sm-3">
                        <label>Achieved Clicks</label>
                        <input type="text" class="form-control achived_clicks"  name="achived_clicks[]" placeholder="Achieved Clicks" value="<?php echo @$clicks_array[0]; ?>" autocomplete="off">
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-2">
                        <input type="file" class="form-control-file" id="logo2" name="logo2">
                        <?php echo $logo_array[1]?>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" class="form-control site_name"  name="site_name[]" placeholder="Site Two Name"  value="<?php echo @$name_array[1]; ?>" autocomplete="off"> 
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_views"  name="achived_views[]" placeholder="Achieved Impressions" value="<?php echo @$views_array[1]; ?>" autocomplete="off">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_clicks"  name="achived_clicks[]" placeholder="Achieved Clicks" value="<?php echo @$clicks_array[1]; ?>" autocomplete="off">
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-2">
                        <input type="file" class="form-control-file" id="logo3" name="logo3">
                        <?php echo $logo_array[2]?>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" class="form-control site_name"  name="site_name[]" placeholder="Site Three Name"  value="<?php echo @$name_array[2]; ?>" autocomplete="off">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_views"  name="achived_views[]" placeholder="Achieved Impressions" value="<?php echo @$views_array[2]; ?>" autocomplete="off">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_clicks"  name="achived_clicks[]" placeholder="Achieved Clicks" value="<?php echo @$clicks_array[2]; ?>" autocomplete="off">
                      </div>
                    </div>
                    <hr>

                    <div class="row">
                      <div class="col-sm-2">
                        <input type="file" class="form-control-file" id="logo4" name="logo4">
                        <?php echo $logo_array[3]?>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" class="form-control site_name"  name="site_name[]" placeholder="Site Four Name"  value="<?php echo @$name_array[3]; ?>" autocomplete="off">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_views"  name="achived_views[]" placeholder="Achieved Impressions" value="<?php echo @$views_array[3]; ?>" autocomplete="off">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_clicks"  name="achived_clicks[]" placeholder="Achieved Clicks" value="<?php echo @$clicks_array[3]; ?>" autocomplete="off">
                      </div>
                    </div>


                    <hr>

                    <div class="row">
                      <div class="col-sm-2">
                        <input type="file" class="form-control-file" id="logo5" name="logo5">
                        <?php echo $logo_array[4]?>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" class="form-control site_name"  name="site_name[]" placeholder="Site Five Name"  value="<?php echo @$name_array[4]; ?>" autocomplete="off">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_views"  name="achived_views[]" placeholder="Achieved Impressions" value="<?php echo @$views_array[4]; ?>" autocomplete="off">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_clicks"  name="achived_clicks[]" placeholder="Achieved Clicks" value="<?php echo @$clicks_array[4]; ?>" autocomplete="off">
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-2">
                        <input type="file" class="form-control-file" id="logo6" name="logo6">
                        <?php echo $logo_array[5]?>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" class="form-control site_name"  name="site_name[]" placeholder="Site Five Name" autocomplete="off" value="<?php echo @$name_array[5]; ?>">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_views"  name="achived_views[]" placeholder="Achieved Impressions" autocomplete="off" value="<?php echo @$views_array[5]; ?>">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_clicks"  name="achived_clicks[]" placeholder="Achieved Clicks" autocomplete="off" value="<?php echo @$clicks_array[5]; ?>"> 
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-2">
                        <input type="file" class="form-control-file" id="logo7" name="logo7">
                        <?php echo $logo_array[6]?>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" class="form-control site_name"  name="site_name[]" placeholder="Site Five Name" autocomplete="off" value="<?php echo @$name_array[6]; ?>">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_views"  name="achived_views[]" placeholder="Achieved Impressions" autocomplete="off" value="<?php echo @$views_array[6]; ?>">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_clicks"  name="achived_clicks[]" placeholder="Achieved Clicks" autocomplete="off" value="<?php echo @$clicks_array[6]; ?>"> 
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-2">
                        <input type="file" class="form-control-file" id="logo8" name="logo8">
                        <?php echo $logo_array[7]?>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" class="form-control site_name"  name="site_name[]" placeholder="Site Five Name" autocomplete="off"
                        value="<?php echo @$name_array[7]; ?>">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_views"  name="achived_views[]" placeholder="Achieved Impressions" autocomplete="off" value="<?php echo @$views_array[7]; ?>">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_clicks"  name="achived_clicks[]" placeholder="Achieved Clicks" autocomplete="off" value="<?php echo @$clicks_array[7]; ?>"> 
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-2">
                        <input type="file" class="form-control-file" id="logo9" name="logo9">
                        <?php echo $logo_array[8]?>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" class="form-control site_name"  name="site_name[]" placeholder="Site Five Name" autocomplete="off"
                        value="<?php echo @$name_array[8]; ?>">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_views"  name="achived_views[]" placeholder="Achieved Impressions" autocomplete="off" value="<?php echo @$views_array[8]; ?>">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_clicks"  name="achived_clicks[]" placeholder="Achieved Clicks" autocomplete="off" value="<?php echo @$clicks_array[8]; ?>"> 
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-2">
                        <input type="file" class="form-control-file" id="logo10" name="logo10">
                        <?php echo $logo_array[9]?>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" class="form-control site_name"  name="site_name[]" placeholder="Site Five Name" autocomplete="off"
                        value="<?php echo @$name_array[9]; ?>">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_views"  name="achived_views[]" placeholder="Achieved Impressions" autocomplete="off" value="<?php echo @$views_array[9]; ?>">
                      </div>
                      <div class="col-sm-3">
                        <input type="text" class="form-control achived_clicks"  name="achived_clicks[]" placeholder="Achieved Clicks" autocomplete="off" value="<?php echo @$clicks_array[9]; ?>"> 
                      </div>
                    </div>


                  </div>

                  <div class="card-footer">
                    <button type="submit" class="btn btn-info " id="website_targeted_reports_stats" onclick="saveWebsiteTargetedReportsStats(event)">Save Website Targeted Data</button>
                    <span id="WTRSD_note"></span>
                  </div>
                  <!-- /.card-body -->
                </div>
              </form>

            </div>
          </div>
          <!--row end here-->


             <!-- row start here-->
             <div class="row">
              <div class="col-md-12">
              <form id="social_media_data_form" name="social_media_data_form" method="post" enctype="multipart/form-data" action="#">
                <div class="card card-info ">
                  <div class="card-header social-media-stats">
                    <h3 class="card-title">Google Anyalistic And Social Media Channel</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    
                    <div class="row">
                      <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="g_anyalistic">Google Anyalistic</label>
                          <input type="file" class="form-control-file" id="g_anyalistic" name="g_anyalistic">
                        </div>
                      </div>

                      <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="facebook">Facebook</label>
                          <input type="file" class="form-control-file" id="facebook_data" name="facebook">
                        </div>
                      </div>

                      <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="linkedin">LinkeDin</label>
                          <input type="file" class="form-control-file" id="linkedin" name="linkedin"> 
                        </div>
                      </div>
                    </div>

                    
                    <div class="row">
                      <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="twitter">Twitter</label>
                          <input type="file" class="form-control-file" id="twitter" name="twitter">
                        </div>
                      </div>

                      <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="pinterest">Pinterest</label>
                          <input type="file" class="form-control-file" id="pinterest" name="pinterest">
                        </div>
                      </div>

                      <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="instagram">Instagram</label>
                          <input type="file" class="form-control-file" id="instagram" name="instagram">
                        </div>
                      </div>
                    </div>

                    <?php 
                         echo @$social_media_data[0][0]['url'].'<br>'; 
                         echo @$social_media_data[0][1]['url'].'<br>';
                         echo @$social_media_data[0][2]['url'].'<br>';
                         echo @$social_media_data[0][3]['url'].'<br>';
                         echo @$social_media_data[0][4]['url'].'<br>';
                         echo @$social_media_data[0][5]['url'].'<br>';
                        
                   ?>
                    
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn social-media-stats" id="social_media_data" onclick="saveSocialMediaData(event)">Save Social Media Data</button>
                    <span id="SMD_note"></span>
                  </div>
                  <!-- /.card-body -->
                </div>
              </form>

              </div>
      
            </div>
            <!--row end here-->



            <!-- row start here-->
            <div class="row">
              <div class="col-md-4">
              <form id="heat_map_image_form" name="heat_map_image_form" method="post" enctype="multipart/form-data" action="#">

                <div class="card card-info">
                  <div class="card-header fifth-row">
                    <h3 class="card-title">Heat Map Images</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="HMAP_file">Heat Map Image</label>
                          <input type="file" class="form-control-file" id="HMAP_file" name="HMAP_file">
                        </div>
                      </div>
                    </div>
                    <?php echo @$heat_maps[0]; ?>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info fifth-row" id="heat_map_image" onclick="saveHeatMapImage(event)">Save Heat Map Image</button>
                    <span id="HMP_note"></span>
                  </div>
                  <!-- /.card-body -->
                </div>
              </form>

              </div>
              <div class="col-md-4">
              <form id="keyword_trigger_form" name="keyword_trigger_form" method="post" enctype="multipart/form-data" action="#">
                <div class="card card-info">
                  <div class="card-header fifth-row">
                    <h3 class="card-title"> Keywords that triggered your Ads</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <!-- text input --> 
                        <div class="form-group">
                          <label for="fbAPI">Keyword Image</label>
                          <input type="file" class="form-control-file" id="KWT_file" name="KWT_file">
                        </div>
                      </div>
                    </div>
                    <?php echo @$keywords_triggered[0]; ?>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info fifth-row" id="keyword_trigger" onclick="saveKeywordsTriggered(event)">Save Keywords triggered</button>
                    <span id="SKW_note"></span>
                  </div>
                  <!-- /.card-body -->
                </div>
              </form>
              </div>

              <div class="col-md-4">
              <form id="premium_distribution_sites_form" name="premium_distribution_sites_form" method="post" enctype="multipart/form-data" action="#">
                <div class="card card-info">
                  <div class="card-header fifth-row">
                    <h3 class="card-title">Premium Distribution Sites Image</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="PDS_file">Premium Image</label>
                          <input type="file" class="form-control-file" id="PDS_file" name="PDS_file">
                        </div>
                      </div>
                    </div>
                    <?php echo @$premium_distribution[0]; ?>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info fifth-row" id="premium_image" onclick="savePremiumDistributionSites(event)">Save Premium Distribution Image</button>
                    <span id="PSM_note"></span>
                  </div>
                  <!-- /.card-body -->
                </div>
              </form>
            </div>


            </div>
            <!--row end here-->


              <!-- row start here-->
              <div class="row">
              <div class="col-md-6">
              <form id="get_keywords_impressions" name="get_keywords_impressions" method="post" enctype="multipart/form-data" action="#">
                <div class="card card-info">
                  <div class="card-header sixth-row">
                    <h3 class="card-title">Class-Action Websites Stats</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body"id="add_field">
                    
                    <div class="row" >
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Website Name</label>
                          <input type="text" class="form-control _websites" name="_websites[]"  placeholder="Website Name" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>Impressions</label>
                          <input type="number" class="form-control _impressions" name="_impressions[]"  placeholder="Total Impressions">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>Clicks</label>
                          <input type="number" class="form-control _clicks" name="_clicks[]"  placeholder="Total Clicks">
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="post_idd" id="post_idd" value="<?php echo $post_id; ?>">

                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info sixth-row" id="premiumReportsStatButton" onclick="savePremiumReportsStats(event)">Save Class-Action Websites Stats</button>
                    <button type="button" class="btn btn-default" onclick="addNewField(event)">Add New Field</button>
                    <br>
                    <span id="PRS_note"></span>
                  </div>
                  <!-- /.card-body -->
                </div>
                </form>

              </div>

              <div class="col-md-6">
              <form id="save_report_dates_form" name="save_report_dates_form" method="post" enctype="multipart/form-data" action="#">
                <div class="card card-info">
                  <div class="card-header sixth-row">
                    <h3 class="card-title">Important Report Dates</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Press Release Date </label>
                          <input type="date" class="form-control" name="pr_date" id="pr_date"  autocomplete="off" value="<?php echo @$report_dates[0]['value']; ?>">
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Report issue Date </label>
                          <input type="date" class="form-control" name="rpt_date" id="rpt_date"  autocomplete="off" value="<?php echo @$report_dates[1]['value']; ?>">
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info sixth-row" id="reports_date" onclick="saveReportDates(event)">Save Report Dates</button>
                    <span id="PPD_note"></span>
                  </div>
                  <!-- /.card-body -->
                </div>
              </form>


              </div>
            </div>
            <!--row end here-->
            <!-- row start here-->
          <div class="row">
            <div class="col-md-6">
              <form id="save_email_media_list" name="save_email_media_list" method="post" action="#" enctype="multipart/form-data">
                <div class="card card-info">
                  <div class="card-header fourth-row">
                    <h3 class="card-title">Email Media Stats Section</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body" >
                    <div class="row">
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="your_media_list">Your Media List</label>
                          <input type="file" class="form-control-file" id="your_media_list" name="your_media_list" data-toggle="tooltip" data-placement="top" title="For nexis and all other reports">
                        </div>
                      </div> 
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label for="email_media_list">Email Media List</label>
                          <input type="file" class="form-control-file" id="email_media_list" name="email_media_list" data-toggle="tooltip" data-placement="top" title="For nexis reporting only">
                      </div>
                      </div>
                    </div>
                    <?php 
                    echo @$mail_media_list[0]['url'].'<br>' ?>
                    <?php echo @$mail_media_list[1]['url'].'<br>' ?>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info fourth-row" id="EmailMediaStatsButton" onclick="saveEmailMediaStats(event)"  data-toggle="tooltip" data-placement="top" title="If wanted to upload another file need to upload already uploaded as well">Save Email Media Stats</button>
                    <span id="eml_note"></span>
                  </div>
                  <!-- /.card-body -->
                </div>
              </form>

            </div>
          </div>
          <!--row end here-->


          </div>



          <!-- main container footer -->
          <div class="card-footer">
            <input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>">
            <button type="submit" class="btn btn-lg btn-success" id="save_final_report" onclick="saveCampaign()">Update Report Data</button>
            <span id="report_message"></span>
          </div>
          </form>
        </div>
        <!-- main container end here -->

      </section>
      <!-- /.content -->
    </div>


    <!-- /.content-wrapper -->
    <?php require_once(APPPATH . 'views/inc/footer.php'); ?>
  </div>
  <!-- ./wrapper -->
  <?php require_once(APPPATH . 'views/inc/js_scripts.php'); ?>

  <script type="text/javascript">

        let BASE_URL = "<?php echo BASE_URL; ?>";

        let campaign_summary_data = <?php echo json_encode($campaign_summary ?: []) ?>;
        let keywords_targeted_data =  <?php echo json_encode( $keywords_targeted ?: []) ?>;
        let targeting_information_data = <?php echo json_encode( $targeting_information ?: []) ?>;
        let fb_campaign_summary_data = <?php echo json_encode($fb_campaign_summary ?: []) ?>;
        let link_campaign_summary_data =  <?php echo json_encode( $link_campaign_summary ?: []) ?>;
        let gaw_campaign_summary_data =  <?php  echo json_encode($gaw_campaign_summary ?: []) ?>;
        let ln_ft_campaign_summary_data =  <?php  echo json_encode($ln_ft_campaign_summary ?: []) ?>;
        let goog_ind_campaign_summary_data =  <?php  echo json_encode($goog_ind_campaign_summary ?: []) ?>;
        
        let keywords_triggered_data = <?php echo json_encode($keywords_triggered ?: []) ?>;
        let heat_maps_data = <?php  echo json_encode($heat_maps ?: []) ?>;
        let premium_distribution = <?php echo json_encode($premium_distribution ?: []) ?>;
        let report_dates_data = <?php  echo json_encode($report_dates ?: []) ?>;
        let premium_website_summary_data =  <?php  echo json_encode($premium_website_summary ?: []) ?>;
        let social_media_Screen_shots =  <?php  echo json_encode($social_media_data ?: []) ?>;
        let website_targeted_reports_data =  <?php  echo json_encode($website_targeted_reports_stats ?: []) ?>;
        let mail_media_list_data = <?php  echo json_encode($mail_media_list ?: []) ?>;
    
        $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
  </script>
  <script src="<?php echo ASSETS; ?>js/update-report.js?123"></script>
 
</body>

</html>