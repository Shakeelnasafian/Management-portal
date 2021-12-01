<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Management
 */
class Management extends CI_Controller
{
	
	
	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('user_session')->logged_in) {

			redirect(BASE_URL . 'users/login');
		}
		
	} //end function 
	
	
	/**
	 * index
	 *
	 * @return void
	 */
	public function index()
	{
		$day_start = date('Y-m-d');
		$day_end = date('Y-m-d 23:59:59');

		$data = $this->management_model->get_icn_management_dashboard_data($day_start, $day_end);

		$this->load->view('management/dashboard', $data);
	} //function end

	
	/**
	 * date_searching
	 *
	 * @return void
	 */
	public function date_searching()
	{
		$this->load->view('management/date_search.php');
	} //function end

	
	/**
	 * total_pressrelease_search_ajax
	 *
	 * @return void
	 */
	public function total_pressrelease_search_ajax()
	{
		$post_data = $this->input->post('select_date');
		$day_start = date('Y-m-d 00:00:00', strtotime($post_data));
		$day_end = date('Y-m-d 23:59:59', strtotime($post_data));

		$response = $this->management_model->get_total_day_count($day_start, $day_end);
		echo 'Total Pressreleases on ' . $post_data . ' are ' . $response . '<br>';
	} //function end
	
	
	/**
	 * verified_pressrelease_search_ajax
	 *
	 * @return void
	 */
	public function verified_pressrelease_search_ajax()
	{

		$post_data = $this->input->post('select_date');
		$day_start = date('Y-m-d 00:00:00', strtotime($post_data));
		$day_end = date('Y-m-d 23:59:59', strtotime($post_data));

		$response = $this->management_model->get_day_verified_count($day_start, $day_end);
		echo 'Verified Pressreleases on ' . $post_data . ' are ' . $response . '<br>';
	} //function end
	
	
	/**
	 * none_verified_pressrelease_search_ajax
	 *
	 * @return void
	 */
	public function none_verified_pressrelease_search_ajax()
	{

		$post_data = $this->input->post('select_date');
		$day_start = date('Y-m-d 00:00:00', strtotime($post_data));
		$day_end = date('Y-m-d 23:59:59', strtotime($post_data));

		$response = $this->management_model->get_day_unverified_count($day_start, $day_end);
		echo 'None Verified Pressreleases on ' . $post_data . ' are ' . $response . '<br>';
	} //function end
	
	
	/**
	 * frankly_pressrelease_search_ajax
	 *
	 * @return void
	 */
	public function frankly_pressrelease_search_ajax()
	{

		$post_data = $this->input->post('select_date');
		$day_start = date('Y-m-d 00:00:00', strtotime($post_data));
		$day_end = date('Y-m-d 23:59:59', strtotime($post_data));

		$response = $this->management_model->get_day_frankly_count($day_start, $day_end);
		echo 'Press Releases Sent to Frankly on ' . $post_data . ' are ' . $response . '<br>';
	} //function end

	
	/**
	 * bignews_pressrelease_search_ajax
	 *
	 * @return void
	 */
	public function bignews_pressrelease_search_ajax()
	{

		$post_data = $this->input->post('select_date');
		$day_start = date('Y-m-d 00:00:00', strtotime($post_data));
		$day_end = date('Y-m-d 23:59:59', strtotime($post_data));

		$response = $this->management_model->get_day_bignews_count($day_start, $day_end);
		echo 'Press Releases Sent to BigNews on ' . $post_data . ' are ' . $response . '<br>';
	} //function end

	
	/**
	 * financial_pressrelease_search_ajax
	 *
	 * @return void
	 */
	public function financial_pressrelease_search_ajax()
	{
		$post_data = $this->input->post('select_date');
		$day_start = date('Y-m-d 00:00:00', strtotime($post_data));
		$day_end = date('Y-m-d 23:59:59', strtotime($post_data));

		$response = $this->management_model->get_day_financial_count($day_start, $day_end);
		echo 'Press Releases Sent to Financial Content on ' . $post_data . ' are ' . $response . '<br>';
	} //function ends

}//class end
