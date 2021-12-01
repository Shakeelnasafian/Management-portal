<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('memory_limit', '-1');


/**
 * Reporting
 */
class Reporting extends CI_Controller
{

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		if (!($this->session->userdata('user_session')->logged_in && $this->session->userdata('user_session')->icn_role == 'SocialMedia-Staff' or $this->session->userdata('user_session')->icn_role == 'Administrator')) {

			redirect(BASE_URL);
		}
		
	} //end function 


	/**
	 * dashboard
	 *
	 * @return void
	 */
	public function dashboard()
	{
	
		$config = [
			'base_url' => BASE_URL . 'reporting/dashboard/',
			'per_page' => 10,
			'total_rows' => $this->reporting_model->reporting_dashboard_pagination()->post_id,
			'first_link' => false,
			'last_link'  => false,
			'prev_link' => '<i class="fa fa-caret-left"></i>',
			'next_link' => '<i class="fa fa-caret-right"></i>',
			'num_links' => 2,
			'uri_segment' => 3,
			'use_page_numbers' => FALSE,
		];

		$this->pagination->initialize($config);

		$data['posts'] = $this->reporting_model->get_icn_published_posts($config['per_page'], $this->uri->segment(3));

		$this->load->view('reporting/dashboard', $data);
	} //function end


	/**
	 * add_report
	 *
	 * @param  mixed $post_id
	 * @return void
	 */
	public function add_report($post_id)
	{
		$data['post_id'] = $post_id;
		$this->load->view('reporting/create-report', $data);
	} //function end


	/**
	 * edit_report
	 *
	 * @param  mixed $post_id
	 * @return void
	 */
	public function edit_report($post_id)
	{
		$response = $this->reporting_model->get_edit_report($post_id);
		if ($response) {


			$report_data = unserialize($response->post_reportdata);

			$data['campaign_summary'] = 	(($report_data['campaign_summary'] != '') ? $report_data['campaign_summary'] : '');

			$data['keywords_targeted'] = (($report_data['keywords_targeted'] != '') ? $report_data['keywords_targeted'] : '');

			$data['targeting_information'] = (($report_data['targeting_information'] != '') ? $report_data['targeting_information'] : '');

			$data['fb_campaign_summary'] = (($report_data['fb_campaign_summary'] != '') ? $report_data['fb_campaign_summary'] : '');

			$data['link_campaign_summary'] =  (($report_data['link_campaign_summary'] != '') ? $report_data['link_campaign_summary'] : '');

			$data['gaw_campaign_summary'] =  (($report_data['gaw_campaign_summary'] != '') ? $report_data['gaw_campaign_summary'] : '');
			
			$data['ln_ft_campaign_summary'] =  (($report_data['ln_ft_campaign_summary'] != '') ? $report_data['ln_ft_campaign_summary'] : '');
			$data['goog_ind_campaign_summary'] =  (($report_data['goog_ind_campaign_summary'] != '') ? $report_data['goog_ind_campaign_summary'] : '');
			
			$data['keywords_triggered'] = (($report_data['keywords_triggered'] != '') ? $report_data['keywords_triggered'] : '');

			$data['heat_maps'] = (($report_data['heat_maps'] != '') ? $report_data['heat_maps'] : '');

			$data['report_dates'] = (($report_data['report_dates'] != '') ? $report_data['report_dates'] : '');

			$data['premium_website_summary'] = (($report_data['premium_website_summary'] != '') ? $report_data['premium_website_summary'] : '');

			$data['social_media_data'] = @(($report_data['social_media_data'] != '') ? $report_data['social_media_data'] : '');
			$data['website_targeted_reports_stats'] = @(($report_data['website_targeted_reports_stats'] != '') ? $report_data['website_targeted_reports_stats'] : '');

			$data['premium_distribution'] = @(($report_data['premium_distribution'] != '') ? $report_data['premium_distribution'] : '');

			$data['mail_media_list'] = (($report_data['mail_media_list'] != '') ? $report_data['mail_media_list'] : '');

			

			$data['post_id'] = $response->post_id;

			$this->load->view('reporting/update-report', $data);
		}
	} //function end


	/**
	 * view_report
	 *
	 * @param  mixed $post_id
	 * @return void
	 */
	public function view_report($post_id)
	{
		$data['ID'] = $post_id;
		$data['post'] = $this->reporting_model->get_report_data($post_id);

		$this->load->view('reporting/view-report', $data);
	} //function end


	/**
	 * delete_report
	 *
	 * @param  mixed $post_id
	 * @return void
	 */
	public function delete_report($post_id)
	{
		$this->reporting_model->delete_report_data($post_id);
		redirect(BASE_URL . 'reporting/dashboard');
	} //function end


	/**
	 * upload_image_amazon
	 *
	 * @return void
	 */
	public function upload_image_amazon()
	{
		require  FCPATH . '/vendor/autoload.php';

		if (isset($_FILES)) {

			$response = array();
			$count = 0;
			$result = null;


			foreach ($_FILES as $randomkey => $file) {
				if ($file['name'] != "") {

					$argv[1] = 'icnimage';
					$bucket = $argv[1];
					$key = round(microtime(true)) . $file['name'];
					$file_Path = file_get_contents($file['tmp_name']);

					try {
						//Create a S3Client
						$s3 = new Aws\S3\S3Client([
							'region'  => 'us-west-2',
							'version' => 'latest',
							'scheme'    => 'https',
							'credentials' => [
								'key'    => "AKIAJ3PIT5AXJPCL667A",
								'secret' => "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",
							]
						]);

						$result = $s3->putObject([
							'Bucket' => $bucket,
							'Key'    => $key,
							'SourceFile' => $source,
							'Body'   => $file_Path,
							'ACL'    => 'public-read',
							//'SourceFile' => 'c:\samplefile.png' -- use this if you want to upload a file from a local location
						]);
					} catch (Exception $e) {
						echo json_encode('Nope');
						exit;
					}

					if ($result['ObjectURL']) {
						$response['paths'][$count]['url'] = $result['ObjectURL'];
					}
					$response['paths'][$count]['key'] = $randomkey;

					$count++;
				}
			}

			$response['status'] = 'all ok';
			echo json_encode($response);
		}
		exit();
	} //function ends


	/**
	 * save_final_report
	 *
	 * @return void
	 */
	public function save_final_report()
	{
		$post_id = $this->input->post('ID');
		$create_array = serialize($this->input->post());
		if (
			array_key_exists('ID', $this->input->post())
			and array_key_exists('campaign_summary', $this->input->post()) and (is_array($this->input->post('campaign_summary')))
			and array_key_exists('targeting_information', $this->input->post()) and (is_array($this->input->post('targeting_information')))
			and array_key_exists('keywords_targeted', $this->input->post()) and (is_array($this->input->post('keywords_targeted')))
			or array_key_exists('fb_campaign_summary', $this->input->post()) and (is_array($this->input->post('fb_campaign_summary')))
			or array_key_exists('link_campaign_summary', $this->input->post()) and (is_array($this->input->post('fb_campaign_summary')))
			or array_key_exists('gaw_campaign_summary', $this->input->post()) and (is_array($this->input->post('gaw_campaign_summary')))
			or array_key_exists('premium_website_summary', $this->input->post()) and (is_array($this->input->post('premium_website_summary')))

		) {

			$insert_data = [
				'post_id' => $post_id,
				'post_reportdata' => $create_array,
				'time_stamp' => date("Y-m-d H:i:s"),
				'saved_by' => $this->session->userdata('user_session')->user_login
			];
			$data = $this->reporting_model->save_final_report_data($insert_data);
			if ($data['status']) {
				echo 1;
			} else {
				echo 0;
			}
			exit();
		}
	} //function end


	/**
	 * update_final_report
	 *
	 * @return void
	 */
	public function update_final_report()
	{

		$post_id = $this->input->post('ID');
		$create_array = serialize($this->input->post());
		if (
			array_key_exists('ID', $this->input->post())
			and array_key_exists('campaign_summary', $this->input->post()) and (is_array($this->input->post('campaign_summary')))
			and array_key_exists('targeting_information', $this->input->post()) and (is_array($this->input->post('targeting_information')))
			and array_key_exists('keywords_targeted', $this->input->post()) and (is_array($this->input->post('keywords_targeted')))
			or array_key_exists('fb_campaign_summary', $this->input->post()) and (is_array($this->input->post('fb_campaign_summary')))
			or array_key_exists('link_campaign_summary', $this->input->post()) and (is_array($this->input->post('fb_campaign_summary')))
			or array_key_exists('gaw_campaign_summary', $this->input->post()) and (is_array($this->input->post('gaw_campaign_summary')))
			or array_key_exists('premium_website_summary', $this->input->post()) and (is_array($this->input->post('premium_website_summary')))

		) {

			$update_data = [
				'post_id' => $post_id,
				'post_reportdata' => $create_array,
				'time_stamp' => date("Y-m-d H:i:s"),
				'saved_by' => $this->session->userdata('username')
			];

			$data = $this->reporting_model->update_final_report_data($update_data, $post_id);
			if ($data['status']) {
				echo 1;
			} else {
				echo 0;
			}
			exit();
		}
	} //function ends


	/**
	 * save_premium_website_states
	 *
	 * @return void
	 */
	public function save_premium_website_states()
	{

		$_websites  = implode(",", $this->input->post('_websites'));
		$_impressions = implode(",", $this->input->post('_impressions'));
		$_clicks = implode(",", $this->input->post('_clicks'));
		$post_id = $this->input->post('post_idd');
		$insert_data = array();
		$data_array = [
			'_websites'    => $_websites,
			'_impressions' => $_impressions,
			'_clicks'	   => $_clicks
		];

		foreach ($data_array as $key => $value) {
			$insert_data[] = array('post_id' => $post_id, 'meta_key' => $key, 'meta_value' => $value);
		}
		$existant_data = $this->reporting_model->check_premium_website_data($post_id);

		if ($existant_data) {
			$data = $this->reporting_model->update_premium_website_data($data_array, $post_id);
		} else {
			$data = $this->reporting_model->save_premium_website_data($insert_data);
		}

		if ($data) {
			echo 1;
		} else {
			echo 0;
		}
	} //function ends


	/**
	 * reporting_filters
	 *
	 * @return void
	 */
	public function reporting_filters()
	{
		$this->form_validation->set_rules('pr_id', 'PR ID', 'trim|strip_tags|callback_validate_either');
		$this->form_validation->set_rules('publish_date', 'Date', 'trim|strip_tags|callback_validate_either');

		if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('validation_failed', 'Please enter atleast one filter');
			redirect(BASE_URL . 'reporting/dashboard');
		} else {
			$post_id = $this->input->post('pr_id');
			$post_data = $this->input->post('publish_date');
			$day_start = date('Y-m-d 00:00:00', strtotime($post_data));
			$day_end = date('Y-m-d 23:59:59', strtotime($post_data));

			if ($post_id) {
				$data['posts'] = $this->reporting_model->reporting_filters_by_id($post_id);
			} else {
				$data['posts'] = $this->reporting_model->reporting_filters_by_date($day_start, $day_end);
			}

			$this->load->view('reporting/dashboard', $data);
		}
	} //function ends


	/**
	 * validate_either
	 *
	 * @return void
	 */
	function validate_either()
	{
		if ($this->input->post('pr_id') != "" || $this->input->post('publish_date') != "") {
			return TRUE;
		} else {
			return FALSE;
		}
	} //function ends
	

	/**
	 * add_pdf
	 *
	 * @return void
	 */
	public function add_pdf($post_id)
	{
		$data['post_id'] = $post_id;
		$this->load->view('reporting/upload-pdf', $data);
	}//function ends

		
	/**
	 * upload_report_pdf
	 *
	 * @return void
	 */
	public function upload_report_pdf()
	{
		require  FCPATH . '/vendor/autoload.php';

			$argv[1] = 'icnimage';
			$bucket = $argv[1];
			$key = round(microtime(true)) . $_FILES["pdf_file"]["name"];
			$file_Path = file_get_contents($_FILES["pdf_file"]['tmp_name']);

			try {
				//Create a S3Client
				$s3 = new Aws\S3\S3Client([
					'region'  => 'us-west-2',
					'version' => 'latest',
					'scheme'    => 'https',
					'credentials' => [
						'key'    => "AKIAJ3PIT5AXJPCL667A",
						'secret' => "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",
					]
				]);

				$result = $s3->putObject([
					'Bucket' => $bucket,
					'Key'    => $key,
					'SourceFile' => $source,
					'Body'   => $file_Path,
					'ACL'    => 'public-read',
					//'SourceFile' => 'c:\samplefile.png' -- use this if you want to upload a file from a local location
				]);
			} catch (Exception $e) {
				echo json_encode('Nope');
				exit;
			}

			if ($result['ObjectURL']) {
				$response = $result['ObjectURL'];
			}
			$post_id = $this->input->post('post_id');

			$insert_data = [
				'post_id' =>$post_id,
				'meta_key' => 'Report_PDF_Link',
				'meta_value' => $response
			];
			
			$response = $this->reporting_model->save_report_pdf($post_id,$insert_data);
			echo $response['message'];

		
	}//function ends


}//class ends