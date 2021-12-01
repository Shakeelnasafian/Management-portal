<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pressrelease
 */
class Pressrelease extends CI_Controller
{

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		if (!($this->session->userdata('user_session')->logged_in && $this->session->userdata('user_session')->icn_role == 'Operations-Staff' or $this->session->userdata('user_session')->icn_role == 'Administrator')) {

			redirect(BASE_URL);
		}
		
	} //end function 


	/**
	 * verified_prs
	 *
	 * @return void
	 */
	public function verified_prs()
	{
		$config = [
			'base_url' => BASE_URL . 'pressrelease/verified_prs/',
			'per_page' => 20,
			'total_rows' => $this->pressrelease_model->verified_pagination(),
			'first_link' => false,
			'last_link'  => false,
			'prev_link' => '<i class="fa fa-caret-left"></i>',
			'next_link' => '<i class="fa fa-caret-right"></i>',
			'num_links' => 2,
			'uri_segment' => 3,
			'use_page_numbers' => FALSE,
		];


		$this->pagination->initialize($config);
		$offset =  $this->uri->segment(3) ?? 0;
		$data['posts'] = $this->pressrelease_model->get_all_verified_prs($config['per_page'], $offset);
		$this->load->view('pressrelease/verified_prs', $data);
	} //function end


	/**
	 * none_verified_prs
	 *
	 * @return void
	 */
	public function none_verified_prs()
	{
		
		$config = [
			'base_url' => BASE_URL . 'pressrelease/none_verified_prs/',
			'per_page' => 20,
			'total_rows' => $this->pressrelease_model->none_verified_pagination(),
			'first_link' => false,
			'last_link'  => false,
			'prev_link' => '<i class="fa fa-caret-left"></i>',
			'next_link' => '<i class="fa fa-caret-right"></i>',
			'num_links' => 2,
			'uri_segment' => 3,
			'use_page_numbers' => FALSE,
		];


		$this->pagination->initialize($config);
		$offset =  $this->uri->segment(3) ?? 0;
		$data['posts'] = $this->pressrelease_model->get_all_none_verified_prs($config['per_page'], $offset);
		$this->load->view('pressrelease/none_verified_prs', $data);
	} //function end



	/**
	 * verify_pressrelease
	 *
	 * @return void
	 */
	public function verify_pressrelease()
	{
		//$this->form_validation->set_rules('transaction_id', 'transaction_id', 'required');
		$this->form_validation->set_rules('payment_type', 'payment_type', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
			redirect(BASE_URL . 'pressrelease/none_verified_prs');
		} else {

			$update_data = [
				'transaction_id' => $this->input->post('transaction_id'),
				'payment_type' => $this->input->post('payment_type'),
				'coupon_code' => $this->input->post('coupon_code'),
				'verified_by' => $this->session->userdata('user_session')->user_login,
				'additional_comments' => $this->input->post('additional_comments'),
				'post_status' => 1,
			];

			$response = $this->pressrelease_model->verify_pressrelease($update_data, $this->input->post('pr_id'));
			echo  $response['message'];
		}
	} // fucntion ends


	/**
	 * pr_filters
	 *
	 * @return void
	 */
	public function pr_filters()
	{
		$pr_title = trim($this->input->post('pr_title'));
		$pr_title = $pr_title.'%';
		$post_author = trim($this->input->post('posts_author'));

		$data['posts'] = $this->pressrelease_model->get_filter_none_verified_prs($post_author, $pr_title);
		$this->load->view('pressrelease/none_verified_prs', $data);
	} //end function


	/**
	 * get_pr_subscription_id
	 *
	 * @return void
	 */
	public function get_pr_subscription_id()
	{
		$post_id = $this->input->post('pr_id');
		$response = $this->pressrelease_model->get_post_subsription_id($post_id);
	
		if ($response) {
			$return_array = array(
				'subscription_id' => $response['kiosk_data']->subscription_id,
				'coupon_code' => $response['coupon']->coupon_code
			);
			echo json_encode($return_array);
		}
	} //function end


}//class end
