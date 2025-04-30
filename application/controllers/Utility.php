<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Utility
 */
class Utility extends CI_Controller
{
    
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        if ( ! $this->session->userdata('user_session')->logged_in ) {

            redirect(BASE_URL);
        }
       
    } //end function 
    
    
    /**
     * pr_media_sites_links
     *
     * @return void
     */
    public function pr_media_sites_links()
    {
        $this->load->view("utility/media_sites_links");
    } //function end
    
     /**
     * add_market_place
     *
     * @return void
     */
    public function add_marketplace_sites_links()
    {   
        check_user_role(8);
        $this->load->view("utility/add_marketplace");
    } //function end

      /**
     * search_market_place
     *
     * @return void
     */
    public function search_marketplace_sites_links()
    {   
        check_user_role(6);
        $rss_channal_id = 35;  // can change id for getting respective channal posts e.g. market place posts

        $config = [
			'base_url' => BASE_URL . 'utility/search-marketplace-sites-links/',
			'per_page' => 10,
			'total_rows' => $this->utility_model->marketplace_pagination($rss_channal_id)->post_id,
			'first_link' => false,
			'last_link'  => false,
			'prev_link' => '<i class="fa fa-caret-left"></i>',
			'next_link' => '<i class="fa fa-caret-right"></i>',
			'num_links' => 2,
			'uri_segment' => 3,
			'use_page_numbers' => FALSE,
		];
        

        $this->pagination->initialize($config);

		$response['marketplace_data']  = $this->utility_model->marketplace_posts_data($rss_channal_id,$config['per_page'], $this->uri->segment(3));
        
        // $response['marketplace_data'] = $this->utility_model->marketplace_posts_data();
        
        $this->load->view("utility/marketplace_search", $response);
    } //function end
    

       /**
     * create_marketplace
     *
     * @return void
     */
    public function create_marketplace()
    {
        check_user_role(8);
        $rss_channal_id = 35;
        $this->form_validation->set_rules('post_id', 'Post ID', 'required');
        $this->form_validation->set_rules('market_place_url', 'Marketplace URL', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
            redirect(BASE_URL . 'utility/add-marketplace-sites-links');
        } else {
            
            $insert_data = [
                'rss_name' => 'MarketPlace',
                'post_id' => preg_replace('#[^0-9]#', '', $this->input->post('post_id')),
                'post_link' => $this->input->post('market_place_url'),
                'fetch_date' => date('Y-m-d h:i:s'),
                'rss_channel_id' => $rss_channal_id,
            ];

            $response = $this->utility_model->create_new_marketplace($insert_data);

            if ($response['status']) {
                $this->session->set_flashdata('success-message', $response['message']);
                redirect(BASE_URL . 'utility/add-marketplace-sites-links/' . $response['market_id']);
            } else {
                $this->session->set_flashdata('error-message', $response['message']);
                redirect(BASE_URL . 'utility/add-marketplace-sites-links/');
            }
        }
        
    } //function ends

    /**
     * icn_coupons
     *
     * @return void
     */
    public function marketplace_posts_filters()
    {   
          check_user_role(6);
          $rss_channel_id = 35;
        $this->form_validation->set_rules('post_id', 'Post ID', 'required');
        if ($this->form_validation->run() === FALSE) {

            $this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
            redirect(BASE_URL . 'utility/search_marketplace_sites_links');
        
        } else{
            
        $post_id = preg_replace('#[^0-9]#', '', $this->input->post('post_id'));
        $response['marketplace_data'] = $this->utility_model->check_marketplace_post_id($post_id,$rss_channel_id);
        $this->load->view("utility/marketplace_search", $response );
        
    }
        
    } //function ends

    /**
     * search_frankly_links
     *
     * @return void
     */
    public function search_frankly_links()
    {
        $response = $this->utility_model->search_frankly_data($this->input->post('post_id'));
        if ($response) {
            $item = 1;
            foreach ($response as $link) {
                echo "<tr><td> $item </td><td> $link->post_link </td></tr>";
                $item++;
            }
        } else {
            echo "<tr><td> </td><td> No Frankly Link Found </td></tr>";
        }
    } // function end
    
    
    /**
     * search_bignews_links
     *
     * @return void
     */
    public function search_bignews_links()
    {
        $id = $this->input->post('post_id');
        $bigpond = "http://example-reporting.mwrn.net/reporting?post_id=$id";

        $big_pond_data = @file_get_contents($bigpond);
        $raw_data = json_decode($big_pond_data, true);
        if ($raw_data) {
            $item = 1;
            foreach ($raw_data['items'] as $links) {
                echo '<tr><td>' . $item . ' </td><td>' . $links['link'] . '</td></tr>';
                $item++;
            }
        } else {

            echo "<tr><td> </td><td> No Bignews Link Found </td></tr>";
        }
    } // function end
    
    
    /**
     * languages_sites
     *
     * @return void
     */
    public function languages_sites()
    {
        $this->load->view("utility/languages_lins");
    } //function end
    
    
    /**
     * search_languages_links
     *
     * @return void
     */
    public function search_languages_links()
    {

        $response = $this->utility_model->search_languages_sites_link($this->input->post('post_id'));
        if ($response) {
            $item = 1;
            foreach ($response as $link) {
                echo "<tr><td> $item </td><td> $link->post_link </td><td> $link->post_language </td></tr>";
                $item++;
            }
        } else {
            echo "<tr><td> </td><td> No Languages Link Found </td><td> </td></tr>";
        }
    } //function ends

    
    /**
     * renew_session
     *
     * @return void
     */
    public function renew_session()
    {

        $this->session->set_userdata('last_activity', time()); //THIS LINE DOES THE TRICK
        echo 'Ping successful';
   
    }//function end


     /**
     * verify_transaction_id_paypal
     *
     * @return void
     */
    public function verify_transaction_id_paypal()
    {

        $transaction_id = $this->input->post('transaction_id');

        $result = get_payment_verification($transaction_id);

        if ($result->status) {
            $return_array = array(
                'payment_status' => $result->status,
                'amount' => $result->amount->value
            );

            echo json_encode($return_array);
        } else {
            $return_array = array(
                'payment_status' => 'Null'
            );

            echo json_encode($return_array);
        }

    } //function ends
    



}//class end
