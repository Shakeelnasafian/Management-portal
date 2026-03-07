<?php

namespace App\Controllers;

use App\Models\ReportingModel;

ini_set('memory_limit', '-1');

class Reporting extends BaseController
{
    protected ReportingModel $reportingModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->reportingModel = new ReportingModel();
        $this->checkRole('SocialMedia-Staff', 'Administrator');
    }

	/**
	 * dashboard
	 *
	 * @return void
	 */
	public function dashboard()
	{
		$perPage = 10;
		$page = (int) ($this->request->getGet('page') ?? 1);
		$page = max($page, 1);
		$offset = ($page - 1) * $perPage;

		$totalRows = $this->reportingModel->reporting_dashboard_pagination()->post_id ?? 0;
		$pager = service('pager');
		$pager->setPath(base_url('reporting/dashboard'));
		$pager->makeLinks($page, $perPage, $totalRows);

		$data['posts'] = $this->reportingModel->get_icn_published_posts($perPage, $offset);
		$data['pager'] = $pager;

		return view('reporting/dashboard', $data);
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
		return view('reporting/create-report', $data);
	} //function end


	/**
	 * edit_report
	 *
	 * @param  mixed $post_id
	 * @return void
	 */
	public function edit_report($post_id)
	{
		$response = $this->reportingModel->get_edit_report($post_id);
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

			return view('reporting/update-report', $data);
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
		$data['post'] = $this->reportingModel->get_report_data($post_id);

		return view('reporting/view-report', $data);
	} //function end


	/**
	 * delete_report
	 *
	 * @param  mixed $post_id
	 * @return void
	 */
	public function delete_report($post_id)
	{
		$this->reportingModel->delete_report_data($post_id);
		return redirect()->to(base_url('reporting/dashboard'));
	} //function end


	/**
	 * upload_image_amazon
	 *
	 * @return void
	 */
	public function upload_image_amazon()
	{
		$files = $this->request->getFiles();
		$response = ['paths' => []];

		foreach ($files as $randomkey => $file) {
			if (! $file->isValid() || $file->hasMoved()) {
				continue;
			}

			$key = round(microtime(true)) . $file->getName();
			$url = service('amazon')->amazon_s3_upload($key, $file->getTempName());

			$response['paths'][] = [
				'url' => $url,
				'key' => $randomkey,
			];
		}

		$response['status'] = 'all ok';
		return $this->response->setJSON($response);
	} //function ends


	/**
	 * save_final_report
	 *
	 * @return void
	 */
	public function save_final_report()
	{
		$postData = $this->request->getPost();
		$post_id = $postData['ID'] ?? null;
		$create_array = serialize($postData);

		if (
			$post_id &&
			(
				(array_key_exists('campaign_summary', $postData) && is_array($postData['campaign_summary'])) ||
				(array_key_exists('targeting_information', $postData) && is_array($postData['targeting_information'])) ||
				(array_key_exists('keywords_targeted', $postData) && is_array($postData['keywords_targeted'])) ||
				(array_key_exists('fb_campaign_summary', $postData) && is_array($postData['fb_campaign_summary'])) ||
				(array_key_exists('link_campaign_summary', $postData) && is_array($postData['fb_campaign_summary'])) ||
				(array_key_exists('gaw_campaign_summary', $postData) && is_array($postData['gaw_campaign_summary'])) ||
				(array_key_exists('premium_website_summary', $postData) && is_array($postData['premium_website_summary']))
			)
		) {
			$insert_data = [
				'post_id' => $post_id,
				'post_reportdata' => $create_array,
				'time_stamp' => date('Y-m-d H:i:s'),
				'saved_by' => $this->currentUserLogin(),
			];
			$data = $this->reportingModel->save_final_report_data($insert_data);
			return $this->response->setBody($data['status'] ? '1' : '0');
		}

		return $this->response->setBody('0');
	} //function end


	/**
	 * update_final_report
	 *
	 * @return void
	 */
	public function update_final_report()
	{
		$postData = $this->request->getPost();
		$post_id = $postData['ID'] ?? null;
		$create_array = serialize($postData);

		if (
			$post_id &&
			(
				(array_key_exists('campaign_summary', $postData) && is_array($postData['campaign_summary'])) ||
				(array_key_exists('targeting_information', $postData) && is_array($postData['targeting_information'])) ||
				(array_key_exists('keywords_targeted', $postData) && is_array($postData['keywords_targeted'])) ||
				(array_key_exists('fb_campaign_summary', $postData) && is_array($postData['fb_campaign_summary'])) ||
				(array_key_exists('link_campaign_summary', $postData) && is_array($postData['fb_campaign_summary'])) ||
				(array_key_exists('gaw_campaign_summary', $postData) && is_array($postData['gaw_campaign_summary'])) ||
				(array_key_exists('premium_website_summary', $postData) && is_array($postData['premium_website_summary']))
			)
		) {
			$update_data = [
				'post_id' => $post_id,
				'post_reportdata' => $create_array,
				'time_stamp' => date('Y-m-d H:i:s'),
				'saved_by' => $this->currentUserLogin(),
			];

			$data = $this->reportingModel->update_final_report_data($update_data, $post_id);
			return $this->response->setBody($data['status'] ? '1' : '0');
		}

		return $this->response->setBody('0');
	} //function ends


	/**
	 * save_premium_website_states
	 *
	 * @return void
	 */
	public function save_premium_website_states()
	{

		$_websites  = implode(",", $this->request->getPost('_websites'));
		$_impressions = implode(",", $this->request->getPost('_impressions'));
		$_clicks = implode(",", $this->request->getPost('_clicks'));
		$post_id = $this->request->getPost('post_idd');
		$insert_data = array();
		$data_array = [
			'_websites'    => $_websites,
			'_impressions' => $_impressions,
			'_clicks'	   => $_clicks
		];

		foreach ($data_array as $key => $value) {
			$insert_data[] = array('post_id' => $post_id, 'meta_key' => $key, 'meta_value' => $value);
		}
		$existant_data = $this->reportingModel->check_premium_website_data($post_id);

		if ($existant_data) {
			$data = $this->reportingModel->update_premium_website_data($data_array, $post_id);
		} else {
			$data = $this->reportingModel->save_premium_website_data($insert_data);
		}

		if ($data) {
			return $this->response->setBody('1');
		}

		return $this->response->setBody('0');
	} //function ends


	/**
	 * reporting_filters
	 *
	 * @return void
	 */
	public function reporting_filters()
	{
		$post_id = $this->request->getPost('pr_id');
		$post_data = $this->request->getPost('publish_date');

		if ($post_id === '' && $post_data === '') {
			session()->setFlashdata('validation_failed', 'Please enter atleast one filter');
			return redirect()->to(base_url('reporting/dashboard'));
		}

		$day_start = date('Y-m-d 00:00:00', strtotime($post_data));
		$day_end = date('Y-m-d 23:59:59', strtotime($post_data));

		if ($post_id) {
			$data['posts'] = $this->reportingModel->reporting_filters_by_id($post_id);
		} else {
			$data['posts'] = $this->reportingModel->reporting_filters_by_date($day_start, $day_end);
		}

		return view('reporting/dashboard', $data);
	} //function ends


	/**
	 * validate_either
	 *
	 * @return void
	 */
	function validate_either()
	{
		if ($this->request->getPost('pr_id') != "" || $this->request->getPost('publish_date') != "") {
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
		return view('reporting/upload-pdf', $data);
	}//function ends

		
	/**
	 * upload_report_pdf
	 *
	 * @return void
	 */
	public function upload_report_pdf()
	{
		$file = $this->request->getFile('pdf_file');
		if (! $file || ! $file->isValid()) {
			return $this->response->setJSON('Nope');
		}

		$key = round(microtime(true)) . $file->getName();
		$responseUrl = service('amazon')->amazon_s3_upload($key, $file->getTempName());

		$post_id = $this->request->getPost('post_id');

		$insert_data = [
			'post_id' => $post_id,
			'meta_key' => 'Report_PDF_Link',
			'meta_value' => $responseUrl,
		];

		$response = $this->reportingModel->save_report_pdf($post_id, $insert_data);
		return $this->response->setBody((string) $response['message']);
	}//function ends

	protected function currentUserLogin(): ?string
	{
		$userSession = session()->get('user_session');
		return is_object($userSession)
			? ($userSession->user_login ?? null)
			: ($userSession['user_login'] ?? null);
	}


}//class ends








