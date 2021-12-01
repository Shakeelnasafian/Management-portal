<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Sales
 */
class Sales extends CI_Controller
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
     * pressreleases
     *
     * @return void
     */
    public function pressreleases()
    {
        $config = [
			'base_url' => BASE_URL . 'sales/pressreleases/',
			'per_page' => 20,
			'total_rows' => $this->sales_model->pressrelease_dashboard_pagination()->post_id,
			'first_link' => false,
			'last_link'  => false,
			'prev_link' => '<i class="fa fa-caret-left"></i>',
			'next_link' => '<i class="fa fa-caret-right"></i>',
			'num_links' => 2,
			'uri_segment' => 3,
			'use_page_numbers' => FALSE,
		];

		$this->pagination->initialize($config);

		$data['posts'] = $this->sales_model->get_icn_published_posts($config['per_page'], $this->uri->segment(3));
        $data['total_rows'] = $config['total_rows'];
        
		$this->load->view('sales/pressreleases', $data);

    }//function ends


    public function sales_filters()
    {
        $post_title = $this->input->post('post_title');
		$author_id = $this->input->post('author_id');
		$publish_date = $this->input->post('publish_date');
		$day_start = date('Y-m-d 00:00:00', strtotime($publish_date));
        $day_end = date('Y-m-d 23:59:59', strtotime($publish_date));
        
        
		
		if ($post_title){

            $search_query = "post_title LIKE '%$post_title%'";
            $this->session->set_userdata(array("sales_search" => $search_query));
            
		} elseif($author_id){

            $search_query = "post_author = '$author_id'";
            $this->session->set_userdata(array("sales_search" => $search_query));
            
		}elseif($publish_date){

            $search_query = "post_date  >= '$day_start' AND post_date <= '$day_end'";
            $this->session->set_userdata(array("sales_search" => $search_query));
            
        }else{
            $search_query = $this->session->userdata('sales_search');
        }  

        $config = [
			'base_url' => BASE_URL . 'sales/sales-filters/',
			'per_page' => 20,
			'total_rows' => $this->sales_model->sale_post_filter_pagination($search_query)->post_id,
			'first_link' => false,
			'last_link'  => false,
			'prev_link' => '<i class="fa fa-caret-left"></i>',
			'next_link' => '<i class="fa fa-caret-right"></i>',
			'num_links' => 2,
			'uri_segment' => 3,
			'use_page_numbers' => false,
		];

		$this->pagination->initialize($config);

		$data['posts'] = $this->sales_model->get_sales_filters($config['per_page'], $this->uri->segment(3), $search_query);
        $data['total_rows'] = $config['total_rows'];
       
        $this->load->view('sales/pressreleases', $data);
        
    }//function ends



    public function active_coupons()
    {
        $today = date('Y-m-d');
        $config = [
			'base_url' => BASE_URL . 'sales/active-coupons/',
			'per_page' => 20,
			'total_rows' => $this->sales_model->active_coupon_pagination($today)->coupons,
			'first_link' => false,
			'last_link'  => false,
			'prev_link' => '<i class="fa fa-caret-left"></i>',
			'next_link' => '<i class="fa fa-caret-right"></i>',
			'num_links' => 2,
			'uri_segment' => 3,
			'use_page_numbers' => FALSE,
		];

		$this->pagination->initialize($config);


        $response['coupons'] = $this->sales_model->load_icn_coupons($today,$config['per_page'], $this->uri->segment(3));

        $this->load->view('sales/coupons', $response);

    }//function ends


    public function sales_coupon_filters()
    {

        $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'required');

        if ($this->form_validation->run() === FALSE) {

            $this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
            redirect(BASE_URL . 'sales/active-coupons');
        
        } else {

            $coupon_code = $this->input->post('coupon_code');
           
            $response['coupons'] = $this->sales_model->get_coupon_filter($coupon_code);
            $this->load->view("sales/coupons", $response);

           
        }

    }//function ends

        
    /**
     * coupon_usage_details
     *
     * @return void
     */
    public function coupon_usage_details()
    {
        $coupon_id = $this->input->post('coupon_id');
        $response = $this->sales_model->get_coupon_usage_details($coupon_id);
       
		if ($response) {
			$return_array = array(
				'coupon_used' => $response->coupon_used != "" ? $response->coupon_used : 0 ,
				'coupon_applied' => $response->coupon_applied != "" ? $response->coupon_applied : 0
			);
			echo json_encode($return_array);
		}
	
    }//function ends


    public function expired_coupons()
    {
        $today = date('Y-m-d');
        $config = [
			'base_url' => BASE_URL . 'sales/expired-coupons/',
			'per_page' => 20,
			'total_rows' => $this->sales_model->expired_coupon_pagination($today)->coupons,
			'first_link' => false,
			'last_link'  => false,
			'prev_link' => '<i class="fa fa-caret-left"></i>',
			'next_link' => '<i class="fa fa-caret-right"></i>',
			'num_links' => 2,
			'uri_segment' => 3,
			'use_page_numbers' => FALSE,
		];

		$this->pagination->initialize($config);


        $response['coupons'] = $this->sales_model->load_icn_expired_coupons($today,$config['per_page'], $this->uri->segment(3));

        $this->load->view('sales/coupons', $response);

    }//function ends

    public function users_credits()
    {
        $config = [
			'base_url' => BASE_URL . 'sales/users-credits/',
			'per_page' => 20,
			'total_rows' => $this->sales_model->get_users_all_credits_pagination()->credits,
			'first_link' => false,
			'last_link'  => false,
			'prev_link' => '<i class="fa fa-caret-left"></i>',
			'next_link' => '<i class="fa fa-caret-right"></i>',
			'num_links' => 2,
			'uri_segment' => 3,
			'use_page_numbers' => FALSE,
		];

		$this->pagination->initialize($config);

		$data['credits'] = $this->sales_model->get_users_all_credits($config['per_page'], $this->uri->segment(3));
        $data['total_rows'] = $config['total_rows'];
        
		$this->load->view('sales/user-credits', $data);

    }//fucntion ends

        
    /**
     * credits_filters
     *
     * @return void
     */
    public function credits_filters()
    {
        $this->form_validation->set_rules('user_email', 'User Email', 'required');

        if ($this->form_validation->run() === FALSE) {

            $this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
            redirect(BASE_URL . 'sales/users-credits');
        
        } else {

            $user_email = $this->input->post('user_email');
           
            $response['credits'] = $this->sales_model->get_user_credits_filter($user_email);
            $response['total_rows'] = count((array)$response['credits']);
            $this->load->view("sales/user-credits", $response);
        }

    }//function ends


}//class ends