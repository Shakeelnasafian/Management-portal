
createLocalStorage();

function saveCampaignSummary(e) {
  e.preventDefault();
  let campaign_AI = $("#campaign_AI").val();
  let campaign_TC = $("#campaign_TC").val();
  let campaign_PA = $("#campaign_PA").val();
  let campaign_EM = $("#campaign_EM").val();

  let validated = true;

  if(campaign_AI && campaign_TC)
  {
    if(campaign_PA == ''){
      campaign_PA = '250'
    }
    if(campaign_EM == ''){
      campaign_EM = '372'
    }

  }else{

    validated = false;
    
  }

  let keys = [{
      "Name": "AI",
      "value": campaign_AI
    },{
      "Name": "TC",
      "value": campaign_TC
    },{
      "Name": "PA",
      "value": campaign_PA
    },{
      "Name": "EM",
      "value": campaign_EM
    }];

  let status = validated && saveToLocalStorage("campaign_summary", keys);

  if (status) {
    successMessage('#CS_note', 'Campaign summary saved successfully!');
  } else {
    errorMessage('#CS_note', 'There is some error while saving data');
  }


}//function end

function saveTargetedKeywords(e) {
  e.preventDefault();
  let keywords = $("#keywords").val();
  var keywordItems = keywords.split(',');

  let validated = validate('targeted_keywords_form');

  let status = validated && saveToLocalStorage("keywords_targeted", keywordItems);

  if (status) {
    successMessage('#TKW_note', 'Targeted keywords saved successfully!');
  } else {
    errorMessage('#TKW_note', 'There is some error while saving data');
  }

}//function ends

function saveTargetingInformation(e) {
  e.preventDefault();
  let geoT = $("input[name=geoT]").val();
  let ageGroup = $("input[name=ageGroup]").val();

  let gender = '';

  if ($('#female').is(':checked')) {
    gender = 0;
  }

  if ($('#male').is(':checked')) {
    gender = 1;
  }

  if ($('#male').is(':checked') && $('#female').is(':checked')) {
    gender = 2;
  }

  let Tnetworks = [];

  if ($('#facebook').is(':checked')) {
    Tnetworks.push("Facebook");
  }

  if ($('#google').is(':checked')) {
    Tnetworks.push("Google");
  }


  if ($('#linkedIn').is(':checked')) {
    Tnetworks.push("LinkedIn");
  }


  let trigerdKeywords = [{
    "geoT": geoT,
    "ageGroup": ageGroup,
    "Gender": gender
  },
  {
    "Tnetworks": Tnetworks
  },
  ];

  let validated = validate('targeting_information_form');

  let status = validated && saveToLocalStorage("targeting_information", trigerdKeywords);

  if (status) {
    successMessage('#TI_note', 'Targeting information saved successfully!');
  } else {
    errorMessage('#TI_note', 'There is some error while saving data');
  }

}//function end

function saveFacebookCampaignSummary(e) {
  e.preventDefault();

  let achievedViews = $('#fbAI').val();
  let totalLinks = $('#fbTLC').val();

  let demographicImagesCount = $('#fbDI').prop('files').length;
  let adPreviewImagesCount = $('#fbAPI').prop('files').length;

  let validated = validate('facebook_campaign_form');

  if (validated && demographicImagesCount != "" && adPreviewImagesCount != "") {

    let data = new FormData($('#facebook_campaign_form')[0]);
    let fbCampgainData = [];
    $.ajax(
      {
        type: 'POST',
        url: BASE_URL + "reporting/upload_image_amazon",
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function () {
          $("#facebook_campgain_sumary").prop('disabled', true);
        },
        success: function (response) {
          let data = JSON.parse(response);
          if (data.status === 'all ok') {

            $("#facebook_campgain_sumary").prop('disabled', false);
            // successMessage($(`#FCS_note_${campaignId}`), 'Image(s) uploaded successfully!');

            var paths = data.paths;

            fbCampgainData.push({ fbAI: achievedViews, fbTLC: totalLinks });
            fbCampgainData.push(paths);

            saveToLocalStorage('fb_campaign_summary', fbCampgainData);
            successMessage($('#FB_note'), 'Facebook Campaign saved successfully!');
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          errorMessage($('#FB_note'), 'Error occure while uploading your data');
        }
      });
  }


}//function ends

function saveGoogleCampaignSummary(e) {
  e.preventDefault();

  let achievedViews = $('#gAI').val();
  let totalLinkClicks = $('#gTLC').val();

  let googleGraphicImage = $('#GIfile').prop('files').length;

  let validated = validate('google_campaign_form');

  if (validated && googleGraphicImage != "") {


    let data = new FormData($('#google_campaign_form')[0]);
    let googleCampgainData = [];
    $.ajax(
      {
        type: 'POST',
        url: BASE_URL + "reporting/upload_image_amazon",
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function () {
          $("#google_campaign_summary").prop('disabled', true);
        },
        success: function (response) {
          let data = JSON.parse(response);
          if (data.status === 'all ok') {

            $("#google_campaign_summary").prop('disabled', false);
            // successMessage($(`#FCS_note_${campaignId}`), 'Image(s) uploaded successfully!');

            var paths = data.paths;

            googleCampgainData.push({ gAI: achievedViews, gTLC: totalLinkClicks });
            googleCampgainData.push(paths);

            saveToLocalStorage('gaw_campaign_summary', googleCampgainData);
            successMessage($('#GCS_note'), 'Google Campaign saved successfully!');
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          errorMessage($('#GCS_note'), 'Error occure while uploading your data');
        }
      });

  }

}//function end

function saveLexusNexusFactivaSummary(e) {
  e.preventDefault();

  // let achievedViews = $('#gAI').val();
  // let totalLinkClicks = $('#gTLC').val();

  let lexusGraphicImage = $('#LNfile').prop('files').length;
   let factivaGraphicImage = $('#FTfile').prop('files').length;

  let validated = validate('lexusnexus_campaign_form');

  if (validated && lexusGraphicImage != "" && factivaGraphicImage != "" ) {


    let data = new FormData($('#lexusnexus_campaign_form')[0]);
    let lexusnexusfactivaCampgainData = [];
    $.ajax(
      {
        type: 'POST',
        url: BASE_URL + "reporting/upload_image_amazon",
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function () {
          $("#lexusnexus_factiva_campaign_summary").prop('disabled', true);
        },
        success: function (response) {
          let data = JSON.parse(response);
          if (data.status === 'all ok') {

            $("#lexusnexus_factiva_campaign_summary").prop('disabled', false);
            // successMessage($(`#FCS_note_${campaignId}`), 'Image(s) uploaded successfully!');

            var paths = data.paths;

            // googleCampgainData.push({ gAI: achievedViews, gTLC: totalLinkClicks });
            lexusnexusfactivaCampgainData.push(paths);

            saveToLocalStorage('ln_ft_campaign_summary', lexusnexusfactivaCampgainData);
            successMessage($('#Ln_Ft_note'), 'Lexus Nexus and Factiva saved successfully!');
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          errorMessage($('#Ln_Ft_note'), 'Error occure while uploading your data');
        }
      });

  }

}//function end


function saveGoogleIndexSummary(e) {
  // alert("waqas");
  e.preventDefault();
  // let achievedViews = $('#gAI').val();
  // let totalLinkClicks = $('#gTLC').val();
  let googleIndexImage = $('#GIIfile').prop('files').length;

  let validated = validate('google_index_form');

  if (validated && googleIndexImage != "" ) {

    let data = new FormData($('#google_index_form')[0]);
    let google_indexCampaignData = [];
    $.ajax(
      {
        type: 'POST',
        url: BASE_URL + "reporting/upload_image_amazon",
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function () {
          $("#google_index_campaign_summary").prop('disabled', true);
        },
        success: function (response) {
          let data = JSON.parse(response);
          if (data.status === 'all ok') {

            $("#google_index_campaign_summary").prop('disabled', false);
            // successMessage($(`#FCS_note_${campaignId}`), 'Image(s) uploaded successfully!');

            var paths = data.paths;
            // googleCampgainData.push({ gAI: achievedViews, gTLC: totalLinkClicks });
            google_indexCampaignData.push(paths);

            saveToLocalStorage('goog_ind_campaign_summary', google_indexCampaignData);
            successMessage($('#GII_note'), 'Google indexing saved successfully!');
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          errorMessage($('#GII_note'), 'Error occure while uploading your data');
        }
      });

  }

}//function end

function saveLinkedinCampaignSummary(e) {

  e.preventDefault();

  let achievedViews = $('#linkAI').val();
  let totalLinkClicks = $('#linkTLC').val();

  let linkdinGraphicImage = $('#linkDI').prop('files').length;
  let linkdinJobFunctions = $('#linkAPI').prop('files').length;
  let linkLocations = $('#linkLOC').prop('files').length;
 let linkdinAdPreview= $('#linkAP').prop('files').length;

  let validated = validate('linkedin_campaign_form');

  if (validated && linkdinGraphicImage != "" && linkdinJobFunctions != "" && linkLocations != "" && linkdinAdPreview != "") {

    let data = new FormData($('#linkedin_campaign_form')[0]);
    let linkdinCampgainData = [];
    $.ajax(
      {
        type: 'POST',
        url: BASE_URL + "reporting/upload_image_amazon",
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function () {
          $("#linkedin_campaign_summary").prop('disabled', true);
        },
        success: function (response) {
          let data = JSON.parse(response);
          if (data.status === 'all ok') {

            $("#linkedin_campaign_summary").prop('disabled', false);
            // successMessage($(`#FCS_note_${campaignId}`), 'Image(s) uploaded successfully!');

            var paths = data.paths;

            linkdinCampgainData.push({ linkAI: achievedViews, linkTLC: totalLinkClicks });
            linkdinCampgainData.push(paths);

            saveToLocalStorage('link_campaign_summary', linkdinCampgainData);
            successMessage($('#LinkCS_note'), 'Linkdin Campaign saved successfully!');
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          errorMessage($('#LinkCS_note'), 'Error occure while uploading your data');
        }
      });

  }

}//function end

function savePremiumWebsiteData(e) {
  e.preventDefault();

  let achievedViews = $('#pwAI').val();
  let totalLinkClicks = $('#pwTLC').val();

  let permiumPwfile = $('#pwfile').prop('files').length;
  let permiumPwaddPrev = $('#pwaddPrev').prop('files').length;
  let permiumPwfinance = $('#pwfinance').prop('files').length;

  let validated = validate('premium_website_form');

  if (achievedViews != "" && totalLinkClicks != "" && permiumPwfile != "" && permiumPwaddPrev != "" && permiumPwfinance != "") {

    let data = new FormData($('#premium_website_form')[0]);
    let premiumWebsiteData = [];
    $.ajax(
      {
        type: 'POST',
        url: BASE_URL + "reporting/upload_image_amazon",
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function () {
          $("#premium_website_data").prop('disabled', true);
        },
        success: function (response) {
          let data = JSON.parse(response);
          if (data.status === 'all ok') {

            $("#premium_website_data").prop('disabled', false);
            // successMessage($(`#FCS_note_${campaignId}`), 'Image(s) uploaded successfully!');

            var paths = data.paths;

            premiumWebsiteData.push({ pwAI: achievedViews, pwTLC: totalLinkClicks });
            premiumWebsiteData.push(paths);

            saveToLocalStorage('premium_website_summary', premiumWebsiteData);
            successMessage($('#PWD_note'), 'Premium websites data saved successfully!');
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          errorMessage($('#PWD_note'), 'Error occure while uploading your data');
        }
      });

  }

}//function end

function saveWebsiteTargetedReportsStats(e) {
  e.preventDefault();

  let site_name = [], achived_views = [], achived_clicks = [] , urls =[];

  $('.site_name').each(function () {
    site_name.push($(this).val());
  });

  $('.achived_views').each(function () {
    achived_views.push($(this).val());
  });

  $('.achived_clicks').each(function () {
    achived_clicks.push($(this).val());
  });

  site_name = site_name.toString();
  achived_views = achived_views.toString();
  achived_clicks = achived_clicks.toString();

  let logo1 = $('#logo1').prop('files').length;
  let logo2 = $('#logo2').prop('files').length;
 

  if (site_name != "" && achived_views != "" && achived_clicks != "" && logo1 != "" && logo2 != "") {

    let data = new FormData($('#website_targeted_reports_stats_form')[0]);
    let premiumWebsiteData = [];
    $.ajax(
      {
        type: 'POST',
        url: BASE_URL + "reporting/upload_image_amazon",
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function () {
          $("#website_targeted_reports_stats").prop('disabled', true);
        },
        success: function (response) {
          let data = JSON.parse(response);
         // console.log(data.paths);
          if (data.status === 'all ok') {

            $("#website_targeted_reports_stats").prop('disabled', false);
            // successMessage($(`#FCS_note_${campaignId}`), 'Image(s) uploaded successfully!');

            var paths = data.paths;

            paths.forEach(function(paths) {
              urls.push(paths.url)
          });
          
            urls = urls.toString();
            premiumWebsiteData.push({ site_name: site_name, achived_views: achived_views, achived_clicks:achived_clicks, logo:urls});
           
            saveToLocalStorage('website_targeted_reports_stats', premiumWebsiteData);
            successMessage($('#WTRSD_note'), 'Premium websites data saved successfully!');
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          errorMessage($('#WTRSD_note'), 'Error occure while uploading your data');
        }
      });

  }

}//function ends



function saveSocialMediaData(e) {
  e.preventDefault();


  let g_anyalistic = $('#g_anyalistic').prop('files').length;
  let facebook = $('#facebook_data').prop('files').length;
  let linkedin = $('#linkedin').prop('files').length;


  if (g_anyalistic != "" && facebook != "" && linkedin != "") {

    let data = new FormData($('#social_media_data_form')[0]);
    let socialMediaData = [];
    $.ajax(
      {
        type: 'POST',
        url: BASE_URL + "reporting/upload_image_amazon",
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function () {
          $("#social_media_data").prop('disabled', true);
        },
        success: function (response) {
          let data = JSON.parse(response);
          if (data.status === 'all ok') {

            $("#social_media_data").prop('disabled', false);
            // successMessage($(`#FCS_note_${campaignId}`), 'Image(s) uploaded successfully!');

            var paths = data.paths;

            socialMediaData.push(paths);

            saveToLocalStorage('social_media_data', socialMediaData);
            successMessage($('#SMD_note'), 'Google Anyalistic And Social Media data saved successfully!');
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          errorMessage($('#SMD_note'), 'Error occure while uploading your data');
        }
      });

  }

}//function end


function saveHeatMapImage(e) {
  e.preventDefault();

  let HMAP_file = $('#HMAP_file').prop('files').length;

  if (HMAP_file != "") {

    let data = new FormData($('#heat_map_image_form')[0]);
    let heatMapData = [];
    $.ajax(
      {
        type: 'POST',
        url: BASE_URL + "reporting/upload_image_amazon",
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function () {
          $("#heat_map_image").prop('disabled', true);
        },
        success: function (response) {
          let data = JSON.parse(response);
          if (data.status === 'all ok') {

            $("#heat_map_image").prop('disabled', false);
            // successMessage($(`#FCS_note_${campaignId}`), 'Image(s) uploaded successfully!');

            var paths = data.paths[0].url;

            heatMapData.push(paths);

            saveToLocalStorage('heat_maps', heatMapData);
            successMessage($('#HMP_note'), 'Heat map Image saved successfully!');
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          errorMessage($('#HMP_note'), 'Error occure while uploading your data');
        }
      });

  }

}//function end

function saveKeywordsTriggered(e) {
  e.preventDefault();

  let HMAP_file = $('#KWT_file').prop('files').length;

  if (HMAP_file != "") {

    let data = new FormData($('#keyword_trigger_form')[0]);
    let heatMapData = [];
    $.ajax(
      {
        type: 'POST',
        url: BASE_URL + "reporting/upload_image_amazon",
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function () {
          $("#keyword_trigger").prop('disabled', true);
        },
        success: function (response) {
          let data = JSON.parse(response);
          if (data.status === 'all ok') {

            $("#keyword_trigger").prop('disabled', false);
            // successMessage($(`#FCS_note_${campaignId}`), 'Image(s) uploaded successfully!');

            var paths = data.paths[0].url;

            heatMapData.push(paths);

            saveToLocalStorage('keywords_triggered', heatMapData);
            successMessage($('#SKW_note'), 'Keywords Image saved successfully!');
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          errorMessage($('#SKW_note'), 'Error occure while uploading your data');
        }
      });

  }

}//function end

function savePremiumDistributionSites(e) {
  e.preventDefault();

  let PDS_file = $('#PDS_file').prop('files').length;

  if (PDS_file != "") {

    let data = new FormData($('#premium_distribution_sites_form')[0]);
    let pDSites = [];
    $.ajax(
      {
        type: 'POST',
        url: BASE_URL + "reporting/upload_image_amazon",
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function () {
          $("#premium_image").prop('disabled', true);
        },
        success: function (response) {
          let data = JSON.parse(response);
          if (data.status === 'all ok') {

            $("#premium_image").prop('disabled', false);
            // successMessage($(`#FCS_note_${campaignId}`), 'Image(s) uploaded successfully!');

            var paths = data.paths[0].url;

            pDSites.push(paths);

            saveToLocalStorage('premium_distribution', pDSites);
            successMessage($('#PSM_note'), 'Premium Distribution Sites Image!');
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          errorMessage($('#PSM_note'), 'Premium Distribution Sites Image');
        }
      });

  }

}//function end

function saveReportDates(e) {
  e.preventDefault();
  let prDate = $("#pr_date").val();
  let reportDate = $("#rpt_date").val();

  let dates = [{
    "Name": "pr_date",
    "value": prDate
  }, {
    "Name": "rpt_date",
    "value": reportDate
  }
  ];
  let validated = validate('save_report_dates_form');

  let status = validated && saveToLocalStorage("report_dates", dates);

  if (status) {
    successMessage('#PPD_note', 'Report Dates saved successfully!');
  } else {
    errorMessage('#PPD_note', 'There is some error while saving data');
  }


}//function end

function saveEmailMediaStats(e) {

  e.preventDefault();
  let your_media_list = $('#your_media_list').prop('files').length;
  let email_media_list = $('#email_media_list').prop('files').length;


  if (your_media_list != "" || email_media_list != "") {

    let data = new FormData($('#save_email_media_list')[0]);
    let emailMediaData = [];
    $.ajax(
      {
        type: 'POST',
        url: BASE_URL + "reporting/upload_image_amazon",
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function () {
          $("#EmailMediaStatsButton").prop('disabled', true);
        },
        success: function (response) {
          let data = JSON.parse(response);
          if (data.status === 'all ok') {

            $("#EmailMediaStatsButton").prop('disabled', false);
            // successMessage($(`#FCS_note_${campaignId}`), 'Image(s) uploaded successfully!');

             var paths = data.paths;
            paths.forEach(function(paths) {
              emailMediaData.push(paths)
          });

            saveToLocalStorage('mail_media_list', emailMediaData);
            successMessage($('#eml_note'), 'Email Media saved successfully!');
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          errorMessage($('#eml_note'), 'Error occure while uploading your data');
        }
      });

  }



}//function end


function saveCampaign(campaignId) {

  let post_id = $('#post_id').val();

  $.ajax({
    type: 'POST',
    url: BASE_URL + "reporting/save_final_report",
    dataType: 'json',
    cache: false,
    data: {
      ID: post_id,
      campaign_id: campaignId,
      campaign_summary: fetchFromLocalStorage('campaign_summary'),
      keywords_triggered: fetchFromLocalStorage('keywords_triggered'), 
      premium_distribution: fetchFromLocalStorage('premium_distribution'),
      keywords_targeted: fetchFromLocalStorage('keywords_targeted'),
      fb_campaign_summary: fetchFromLocalStorage('fb_campaign_summary'),
      // linkedin
      link_campaign_summary: fetchFromLocalStorage('link_campaign_summary'),
      gaw_campaign_summary: fetchFromLocalStorage('gaw_campaign_summary'),
      ln_ft_campaign_summary: fetchFromLocalStorage('ln_ft_campaign_summary'),
      goog_ind_campaign_summary: fetchFromLocalStorage('goog_ind_campaign_summary'),
      // premium website
      premium_website_summary: fetchFromLocalStorage('premium_website_summary'),
      website_targeted_reports_stats: fetchFromLocalStorage('website_targeted_reports_stats'),
      targeting_information: fetchFromLocalStorage('targeting_information'),  
      social_media_data: fetchFromLocalStorage('social_media_data'),
      heat_maps: fetchFromLocalStorage('heat_maps'),
      report_dates: fetchFromLocalStorage('report_dates'),
      mail_media_list: fetchFromLocalStorage('mail_media_list')
      
    },
    beforeSend: function () {
      jQuery('#save_final_report').prop('disabled', true);
    },
    success: function (response) {

      $("#save_final_report").prop('disabled', false);

      if (response == 1) {

        localStorage.removeItem('campaign_summary');
        localStorage.removeItem('keywords_triggered');
        localStorage.removeItem('premium_distribution');
        localStorage.removeItem('fb_campaign_summary');
        localStorage.removeItem('fb_campaign_summary');
        localStorage.removeItem('link_campaign_summary');
        localStorage.removeItem('gaw_campaign_summary');
        localStorage.removeItem('ln_ft_campaign_summary');
        localStorage.removeItem('goog_ind_campaign_summary');
        localStorage.removeItem('premium_website_summary');
        localStorage.removeItem('targeting_information');
        localStorage.removeItem('social_media_data');
        localStorage.removeItem('website_targeted_reports_stats');
        localStorage.removeItem('heat_maps');
        localStorage.removeItem('report_dates');
        localStorage.removeItem('mail_media_list');
        

        successMessage("#report_message", "Report Saved successfully");

        window.location = BASE_URL + "reporting/view-report/" + post_id;

      } else {
        errorMessage('#report_message', 'There was a problem while saving your report');
      }
    },
    error: function (xhr, textStatus, errorThrown) {

      errorMessage('#report_message', 'There was a problem while saving your report');
    }
  })
}//function end

function validate(formId) {

  let validated = true;

  $(`#${formId} input`).each(function () {
    let value = $(this).val();
    if (value === 'undefined' || value.toString().trim() === '') {
      validated = false;
    }
  });

  return validated;

}//function end


function successMessage(messageContainerSelector, message) {

  $(messageContainerSelector).css('color', 'green');
  $(messageContainerSelector).html(`<strong>${message}</strong>`);

}//function end

function errorMessage(messageContainerSelector, message) {

  $(messageContainerSelector).css('color', 'red');
  $(messageContainerSelector).html(`<strong>${message}</strong>`);

}//function end


function saveToLocalStorage(key, value, stringify = true) {
  if (typeof (Storage) === "undefined") {
    return false;
  }

  localStorage.setItem(key, stringify ? JSON.stringify(value) : value);
  return true;

}//function end


function fetchFromLocalStorage(key, parseJSON = true) {
  if (typeof (Storage) === "undefined") {
    return null;
  }
  return parseJSON ? JSON.parse(localStorage.getItem(key)) : localStorage.getItem(key);
}//fucntion end

function createLocalStorage() {

        saveToLocalStorage('campaign_summary', []);
        saveToLocalStorage('keywords_targeted', []);
        saveToLocalStorage('targeting_information', []);
        saveToLocalStorage('gaw_campaign_summary', []);
        saveToLocalStorage('ln_ft_campaign_summary', []);
        saveToLocalStorage('goog_ind_campaign_summary', []);
        saveToLocalStorage('fb_campaign_summary', []);
        saveToLocalStorage('link_campaign_summary', []);
        saveToLocalStorage('premium_website_summary', []);
        saveToLocalStorage('social_media_data', []);
        saveToLocalStorage('report_dates', []);
        saveToLocalStorage('keywords_triggered', []);
        saveToLocalStorage('premium_distribution', []);
        saveToLocalStorage('website_targeted_reports_stats', []);
        saveToLocalStorage('heat_maps', []);
        saveToLocalStorage('mail_media_list', []);

}//function end


function addNewField(event) {

  event.preventDefault();

  let addField = `<div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        
                        <input type="text" class="form-control _websites" name="_websites[]"  placeholder="Website Name" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        
                        <input type="number" class="form-control _impressions" name="_impressions[]"  placeholder="Total Clicks">
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                      
                        <input type="number" class="form-control _clicks" name="_clicks[]" placeholder="Total Clicks">
                      </div>
                    </div>
                    </div>`;
  $('#add_field').append(addField);

}//function ends


function savePremiumReportsStats(event) {

  event.preventDefault();

  let keyword = $('#get_keywords_impressions').find('input[name="_keywords[]"]').val();
  let impressions = $('#get_keywords_impressions').find('input[name="_impressions[]"]').val();
  let clicks = $('#get_keywords_impressions').find('input[name="_clicks[]"]').val();

  if (keyword == '' || impressions == '' || clicks == '') {

    console.log("get lost");
    return false;
  } else {

    let data = new FormData($('#get_keywords_impressions')[0]);

    $.ajax(
      {
        type: 'POST',
        url: BASE_URL + "reporting/save_premium_website_states",
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function () {
          $("#premiumReportsStatButton").prop('disabled', true);
        },
        success: function (response) {

          $("#premiumReportsStatButton").prop('disabled', false);
          successMessage($('#PRS_note'), 'Premium Report Stats saved successfully!');

        },
        error: function (xhr, textStatus, errorThrown) {
          errorMessage($('#HMP_note'), 'Error occure while uploading your data');
        }
      });

  }
}