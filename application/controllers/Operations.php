<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('memory_limit', '-1');


/**
 * Operations
 */
class Operations extends CI_Controller
{

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		if (!($this->session->userdata('user_session')->logged_in && $this->session->userdata('user_session')->icn_role == 'Editor' or $this->session->userdata('user_session')->icn_role == 'Administrator')) {

			redirect(BASE_URL);
		}
	} //end function 


	public function create_pressrelease()
	{
		$this->load->view('operations/create_pressrelease');
	}//function ends


	public function create_pr_preview()
	{
		$this->form_validation->set_rules('post_title', 'Post Title', 'required');
		$this->form_validation->set_rules('post_content', 'Post Content', 'required');
		$this->form_validation->set_rules('post_date', 'Post Date', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
			redirect(BASE_URL . 'operations');
		} else {

			$post_date_gmt = date("Y-m-d H:i:s", strtotime("+4 hours",strtotime($this->input->post('post_date'))));
			
			
			$insert_data = [
				'post_title'     => $this->input->post('post_title'),
				'post_content'   => $this->input->post('post_content'),
				'post_date'      => $this->input->post('post_date'),
				'post_date_gmt'  => $post_date_gmt,
				'post_modified'  => $this->input->post('post_date'),
				'post_modified_gmt'=> $post_date_gmt,
				'post_status'    =>'pending',
				'post_type'      => 'post',
				'post_author'    => 4395,
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
				
				
				
			];

			$insert_meta = [
				'cf_campaign_link' => $this->input->post('cf_campaign_link'),
				'cf_cont_info' => $this->input->post('cf_cont_info'),
				'cf_keywords' => $this->input->post('cf_keywords'),
				'pr_created_by' => $this->session->userdata('user_session')->user_login
			];

			$response = $this->operations_model->create_pressrelease($insert_data,$insert_meta);

			

			redirect(BASE_URL . 'operations/edit-pending-pressrelease/'.$response['post_id']);
			
		}

	}//function ends



	/**
	 * pending_pressreleases
	 *
	 * @return void
	 */
	public function pending_pressreleases()
	{

		$config = [
			'base_url' => BASE_URL . 'operations/pending-pressreleases/',
			'per_page' => 20,
			'total_rows' => $this->operations_model->pending_dashboard_pagination()->post_id,
			'first_link' => false,
			'last_link'  => false,
			'prev_link' => '<i class="fa fa-caret-left"></i>',
			'next_link' => '<i class="fa fa-caret-right"></i>',
			'num_links' => 2,
			'uri_segment' => 3,
			'use_page_numbers' => FALSE,
		];

		$this->pagination->initialize($config);

		$data['posts'] = $this->operations_model->get_icn_pending_posts($config['per_page'], $this->uri->segment(3));

		$this->load->view('operations/pending_dashboard', $data);
	} //function end


	/**
	 * schedule_pressreleases
	 *
	 * @return void
	 */
	public function schedule_pressreleases()
	{

		$config = [
			'base_url' => BASE_URL . 'operations/schedule-pressreleases/',
			'per_page' => 20,
			'total_rows' => $this->operations_model->scheduled_dashboard_pagination()->post_id,
			'first_link' => false,
			'last_link'  => false,
			'prev_link' => '<i class="fa fa-caret-left"></i>',
			'next_link' => '<i class="fa fa-caret-right"></i>',
			'num_links' => 2,
			'uri_segment' => 3,
			'use_page_numbers' => FALSE,
		];

		$this->pagination->initialize($config);

		$data['posts'] = $this->operations_model->get_icn_schedule_posts($config['per_page'], $this->uri->segment(3));

		$this->load->view('operations/schedule_dashboard', $data);
	} //function end


	/**
	 * published_pressreleases
	 *
	 * @return void
	 */
	public function published_pressreleases()
	{

		$config = [
			'base_url' => BASE_URL . 'operations/published-pressreleases/',
			'per_page' => 20,
			'total_rows' => $this->operations_model->published_dashboard_pagination()->post_id,
			'first_link' => false,
			'last_link'  => false,
			'prev_link' => '<i class="fa fa-caret-left"></i>',
			'next_link' => '<i class="fa fa-caret-right"></i>',
			'num_links' => 2,
			'uri_segment' => 3,
			'use_page_numbers' => FALSE,
		];

		$this->pagination->initialize($config);

		$data['posts'] = $this->operations_model->get_icn_published_posts($config['per_page'], $this->uri->segment(3));

		$this->load->view('operations/published_dashboard', $data);
	} //function end


	/**
	 * trashed_pressreleases
	 *
	 * @return void
	 */
	public function trashed_pressreleases()
	{

		$config = [
			'base_url' => BASE_URL . 'operations/trashed-pressreleases/',
			'per_page' => 20,
			'total_rows' => $this->operations_model->trashed_dashboard_pagination()->post_id,
			'first_link' => false,
			'last_link'  => false,
			'prev_link' => '<i class="fa fa-caret-left"></i>',
			'next_link' => '<i class="fa fa-caret-right"></i>',
			'num_links' => 2,
			'uri_segment' => 3,
			'use_page_numbers' => FALSE,
		];

		$this->pagination->initialize($config);

		$data['posts'] = $this->operations_model->get_icn_trashed_posts($config['per_page'], $this->uri->segment(3));

		$this->load->view('operations/trashed_dashboard', $data);
	} //function end


	/**
	 * draft_pressreleases
	 *
	 * @return void
	 */
	public function draft_pressreleases()
	{

		$config = [
			'base_url' => BASE_URL . 'operations/draft-pressreleases/',
			'per_page' => 20,
			'total_rows' => $this->operations_model->draft_dashboard_pagination()->post_id,
			'first_link' => false,
			'last_link'  => false,
			'prev_link' => '<i class="fa fa-caret-left"></i>',
			'next_link' => '<i class="fa fa-caret-right"></i>',
			'num_links' => 2,
			'uri_segment' => 3,
			'use_page_numbers' => FALSE,
		];

		$this->pagination->initialize($config);

		$data['posts'] = $this->operations_model->get_icn_draft_posts($config['per_page'], $this->uri->segment(3));

		$this->load->view('operations/draft_dashboard', $data);

	}//function ends


	public function view_pressrelease($post_id = 1231)
	{
		$data['post'] = $this->operations_model->get_pr_view_screen($post_id);
		$this->load->view('operations/view_pressrelease', $data);
	} //function ends



	/**
	 * get_pr_details_ajax
	 *
	 * @return void
	 */
	public function get_pr_details_ajax()
	{
		$post_id  = $this->input->post('pr_id');
		$response = $this->operations_model->get_pr_view_screen($post_id);

		$return_array = array(

			'post_id' => $response->ID,
			'post_title'  => $response->post_title,
			'post_content' => $response->post_content,
			'post_name'  => $response->post_name,
			'post_status' => $response->post_status,
			'post_date'  => $response->post_date,
			'user_login' => $response->user_login,
			'user_email'  => $response->user_email,

		);

		echo json_encode($return_array);
	} //function ends


	/**
	 * approve_pressrelease
	 *
	 * @return void
	 */
	public function approve_pressrelease()
	{
		$post_id = $this->input->post('post_id');
		$update_data = [
			'post_status' => 'future'
		];
		$response = $this->operations_model->get_approve_pressrelease($post_id, $update_data);

		echo $response['message'];
	} //function ends


	/**
	 * reject_pressrelease
	 *
	 * @return void
	 */
	public function reject_pressrelease()
	{
		$post_id = $this->input->post('post_id');
		$update_data = [
			'post_status' => 'trash'
		];
		$response = $this->operations_model->get_reject_pressrelease($post_id, $update_data);

		echo $response['message'];
	} //function ends


	/**
	 * edit_pressrelease
	 *
	 * @param  mixed $post_id
	 * @return void
	 */
	public function edit_pressrelease($post_id)
	{
		$response = $this->operations_model->get_edit_pressrelease($post_id);
		$this->load->view('operations/edit_pressrelease', $response);
	} //function ends


	public function edit_pending_pressrelease($post_id)
	{
		$response = $this->operations_model->get_edit_pressrelease($post_id);
		$this->load->view('operations/edit_pending_pressrelease', $response);
	} //function ends



	/**
	 * update_pressrelease
	 *
	 * @param  mixed $post_id
	 * @return void
	 */
	public function update_pressrelease()
	{

		$this->form_validation->set_rules('post_title', 'Expirey Date', 'required');
		$this->form_validation->set_rules('post_content', 'Discount Price', 'required');
		$this->form_validation->set_rules('post_date', 'Discount Price', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
			redirect(BASE_URL . 'operations');
		} else {

			$post_id = $this->input->post('post_id');
			$post_date = $this->input->post('post_date');
			$post_date_gmt = date("Y-m-d H:i:s", strtotime("+4 hours",strtotime($this->input->post('post_date'))));
			
			
			$post_update = [
				'post_title' => $this->input->post('post_title'),
				'post_content' => $this->input->post('post_content'),
				'post_date' => $post_date,
				'post_date_gmt' => $post_date_gmt,
				'post_status' => $this->input->post('post_status')
			];

			$postmeta_update = [
				'cf_campaign_link' => $this->input->post('cf_campaign_link'),
				'cf_cont_info' => $this->input->post('cf_cont_info'),
				'cf_keywords' => $this->input->post('cf_keywords'),
			];


			$response = $this->operations_model->edit_icn_pressrelease($post_update, $postmeta_update, $post_id);

			echo $response['message'];
		}

	} //function ends

	
	/**
	 * update_pending_pressrelease
	 *
	 * @return void
	 */
	public function update_pending_pressrelease()
	{
		$this->form_validation->set_rules('post_title', 'Expirey Date', 'required');
		$this->form_validation->set_rules('post_content', 'Discount Price', 'required');
		$this->form_validation->set_rules('post_date', 'Discount Price', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
			redirect(BASE_URL . 'operations');
		} else {

			$post_id = $this->input->post('post_id');
			$post_date = $this->input->post('post_date');
			$post_date_gmt = date("Y-m-d H:i:s", strtotime("+4 hours",strtotime($this->input->post('post_date'))));
			$current_date = date("Y-m-d H:i:s");

			if($post_date >= $current_date){
				$post_status = "future";
			}else{
				$post_status = "publish";
			}

			$post_update = [
				'post_title' => $this->input->post('post_title'),
				'post_content' => $this->input->post('post_content'),
				'post_name' => $this->input->post('post_name'),
				'post_date' => $post_date,
				'post_date_gmt' => $post_date_gmt,
				'post_status' => $post_status
			];

			$postmeta_update = [
				'cf_campaign_link' => $this->input->post('cf_campaign_link'),
				'cf_cont_info' => $this->input->post('cf_cont_info'),
				'cf_keywords' => $this->input->post('cf_keywords'),
			];


			$response = $this->operations_model->edit_icn_pressrelease($post_update, $postmeta_update, $post_id);

			echo $response['message'];
		}
	}//function ends

	
	/**
	 * add_categories
	 *
	 * @return void
	 */
	public function add_categories()
	{
		$categories = $this->input->post('categories');
		$post_id = $this->input->post('pr_id');
		$insert_data = array();

		foreach($categories as $cate){
			$add_data = [ 
				'object_id'=> $post_id,
				'term_taxonomy_id'=> $cate
			];
			array_push($insert_data, $add_data);	
		}
		$response = $this->operations_model->add_new_categories($insert_data);
		if($response){

			$return_array = array(
				'li_ids' => $categories,
				'message'  => $response['message'],
			);

		}else{

			$return_array = array(
				'message'  => $response['message'],
			);	
		}

		echo json_encode($return_array);
		
	}//function ends

		
	/**
	 * remove_categories
	 *
	 * @return void
	 */
	public function remove_categories()
	{
		$categories = $this->input->post('categories');
		$post_id = $this->input->post('pr_id');
		
		$response = $this->operations_model->delete_categories($categories,$post_id);
		if($response){

			$return_array = array(
				'li_ids' => $categories,
				'message'  => $response['message'],
			);

		}else{
			$return_array = array(
				'message'  => $response['message'],
			);

		}

		echo json_encode($return_array);

	}//function ends

		
	/**
	 * operations_filters
	 *
	 * @return void
	 */
	public function operations_filters()
	{

		$post_title = $this->input->post('post_title');
		$author_id = $this->input->post('author_id');
		$publish_date = $this->input->post('publish_date');
		$day_start = date('Y-m-d 00:00:00', strtotime($publish_date));
		$day_end = date('Y-m-d 23:59:59', strtotime($publish_date));
		
		if ($post_title){

			$serach_query = "post_title LIKE '%$post_title%'";

		} elseif($author_id){

			$serach_query = "post_author = '$author_id'";

		}else{

			$serach_query = "post_date  >= '$day_start' AND post_date <= '$day_end'";

		}


		// $config = [
		// 	'base_url' => BASE_URL . 'operations/operations-filters/',
		// 	'per_page' => 20,
		// 	'total_rows' => 50,
		// 	'first_link' => false,
		// 	'last_link'  => false,
		// 	'prev_link' => '<i class="fa fa-caret-left"></i>',
		// 	'next_link' => '<i class="fa fa-caret-right"></i>',
		// 	'num_links' => 2,
		// 	'uri_segment' => 3,
		// 	'use_page_numbers' => FALSE,
		// ];


		// $this->pagination->initialize($config);

		$data['posts'] = $this->operations_model->get_operations_filters(40, $serach_query);

		$this->load->view('operations/filters_dashboard', $data);

	}//function ends

		
	/**
	 * move_trash_pending
	 *
	 * @return void
	 */
	public function move_trash_pending()
	{
		$post_id = $this->input->post('post_id');
		$update_data = [
			'post_status' => 'pending'
		];
		$response = $this->operations_model->move_trash_pressrelease_pending($post_id, $update_data);

		echo $response['message'];
	}//function ends

	
	/**
	 * check_unique_slug
	 *
	 * @return void
	 */
	public function check_unique_slug()
	{
		$post_name = $this->input->post('post_name');
        $response = $this->operations_model->check_unique_slug_data($post_name);
        if ($response == 1) {
            echo 'false';
        } else {
            echo 'true';
        }

	}//function ends

	
	/**
	 * show_client_information
	 *
	 * @return void
	 */
	public function show_client_information()
	{
		//echo ;
		$post_id     = $this->input->post('post_id');
		$kiosk_id    = $this->input->post('kiosk_id');
		$post_author = $this->input->post('post_author');

		if($kiosk_id == 19 OR $kiosk_id == ''){

			$response = $this->operations_model->get_wordpress_user($post_author);
			$return_array = array(

				'full_name' => $response->user_nicename,
				'username' => $response->user_login,
				'email'  => $response->user_email,
			);
	
		}else{

			$response = $this->operations_model->get_kiosk_user($post_id);
			$return_array = array(

				'full_name' => $response->first_name.''.$response->last_name,
				'username' => $response->username,
				'email'  => $response->email,
			);
			
		}

		echo json_encode($return_array);


	}//fucntion ends


		



}//class ends