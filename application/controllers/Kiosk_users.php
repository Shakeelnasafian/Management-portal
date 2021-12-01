<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Kiosk_users
 */
class Kiosk_users extends CI_Controller
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        if (!($this->session->userdata('user_session')->logged_in && ( $this->session->userdata('user_session')->icn_role == 'Stake Holders' || $this->session->userdata('user_session')->icn_role == 'Administrator' || $this->session->userdata('user_session')->icn_role == 'Editor' ) ) ) {

            redirect(BASE_URL . 'users/login');
        }
       
    } //function ends 


    public function search_user()
    {
        $this->load->view('kiosk-users/search-user');

    }//function ends


    public function find_user()
    {
        $this->form_validation->set_rules('client_email', 'Email is Required', 'required');

        if ($this->form_validation->run() === FALSE) {

            $this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
            redirect(BASE_URL . 'kiosk-users/search-user');

        } else {

            $data['user'] = $this->kiosk_users_model->find_icn_user($this->input->post("client_email"));

            if($data['user']){
                $this->load->view('kiosk-users/update-user-credits', $data);

            }else{
                redirect(BASE_URL . 'kiosk-users/search-user');
            }
            
           
        }

    }//function ends

    public function update_user_credits()
    {
        $this->form_validation->set_rules('new_credits', 'Credits is Required', 'required');

        if ($this->form_validation->run() === FALSE) {

            $this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
            redirect(BASE_URL . 'kiosk-users/search-user');

        } else {

            $update_array = array(
                "total_credit" =>  $this->input->post("new_credits"),
                "status"   =>   1,
                "current_credit" =>  0,
                "subscription_date" =>  date("Y-m-d h:i:s")
            ); 
        
            $response = $this->kiosk_users_model->update_bulk_user_credits($this->input->post("user_id"),$update_array);

            redirect(BASE_URL . 'kiosk-users/search-user');

           
        }

    }


    /**
     * pressrelease_users
     *
     * @return void
     */
    public function pressrelease_users()
    {

        $config = [
            'base_url' => BASE_URL . 'kiosk-users/pressrelease-users/',
            'per_page' => 20,
            'total_rows' => $this->kiosk_users_model->pressrelease_pagination(),
            'first_link' => false,
            'last_link'  => false,
            'prev_link' => '<i class="fa fa-caret-left"></i>',
            'next_link' => '<i class="fa fa-caret-right"></i>',
            'num_links' => 2,
            'uri_segment' => 3,
            'use_page_numbers' => FALSE,
        ];


        $this->pagination->initialize($config);

        $data['pressrelease_users'] = $this->kiosk_users_model->get_pressrelease_users($config['per_page'], $this->uri->segment(3));

        $data['user_posts'] = filter_array_value($data['pressrelease_users']['posts']);
        $this->load->view('kiosk-users/icn-users', $data);
    } //function ends


    /**
     * get_pressrelease_user_details_ajax
     *
     * @return void
     */
    public function get_pressrelease_user_details_ajax()
    {
        $user_id  = $this->input->post("user_id");
        $response = $this->kiosk_users_model->get_pressrelease_user_details($user_id);

        $html = '';
        $html .= "<p><b class='heading'>ID </b> $response->ID </p>";
        $html .= "<p><b class='heading'>First Name </b> $response->first_name </p>";
        $html .= "<p><b class='heading'>Last Name </b> $response->last_name </p>";
        $html .= "<p><b class='heading'>Username </b> $response->user_login </p>";
        $html .= "<p><b class='heading'>Email </b> $response->user_email </p>";
        $html .= "<p><b class='heading'>Nickname </b> $response->user_nicename </p>";
        $html .= "<p><b class='heading'>Cell Phone </b> $response->cell_phone </p>";
        $html .= "<p><b class='heading'>Corporate Address </b> $response->corporate_address </p>";
        $html .= "<p><b class='heading'>City </b> $response->city </p>";
        $html .= "<p><b class='heading'>Country </b> $response->country </p>";

        echo $html;
        exit();
    } //function ends


    /**
     * legal_users
     *
     * @return void
     */
    public function legal_users()
    {

        $config = [
            'base_url' => BASE_URL . 'kiosk-users/legal-users/',
            'per_page' => 20,
            'total_rows' => $this->kiosk_users_model->legal_pagination(),
            'first_link' => false,
            'last_link'  => false,
            'prev_link' => '<i class="fa fa-caret-left"></i>',
            'next_link' => '<i class="fa fa-caret-right"></i>',
            'num_links' => 2,
            'uri_segment' => 3,
            'use_page_numbers' => FALSE,
        ];


        $this->pagination->initialize($config);

        $data['legal_users'] = $this->kiosk_users_model->get_legal_users($config['per_page'], $this->uri->segment(3));

        $data['user_posts'] = filter_array_value(@$data['legal_users']['posts']);
        $this->load->view('kiosk-users/legal-users', $data);
    } //function ends


    /**
     * content_users
     *
     * @return void
     */
    public function content_users()
    {

        $config = [
            'base_url' => BASE_URL . 'kiosk-users/content-users/',
            'per_page' => 20,
            'total_rows' => $this->kiosk_users_model->content_pagination(),
            'first_link' => false,
            'last_link'  => false,
            'prev_link' => '<i class="fa fa-caret-left"></i>',
            'next_link' => '<i class="fa fa-caret-right"></i>',
            'num_links' => 2,
            'uri_segment' => 3,
            'use_page_numbers' => FALSE,
        ];


        $this->pagination->initialize($config);

        $data['content_users'] = $this->kiosk_users_model->get_content_users($config['per_page'], $this->uri->segment(3));

        $data['user_posts'] = filter_array_value(@$data['content_users']['posts']);
        $this->load->view('kiosk-users/content-users', $data);
    } //function ends


    /**
     * realestate_users
     *
     * @return void
     */
    public function realestate_users()
    {

        $config = [
            'base_url' => BASE_URL . 'kiosk-users/realestate-users/',
            'per_page' => 20,
            'total_rows' => $this->kiosk_users_model->realestate_pagination(),
            'first_link' => false,
            'last_link'  => false,
            'prev_link' => '<i class="fa fa-caret-left"></i>',
            'next_link' => '<i class="fa fa-caret-right"></i>',
            'num_links' => 2,
            'uri_segment' => 3,
            'use_page_numbers' => FALSE,
        ];


        $this->pagination->initialize($config);

        $data['realestate_users'] = $this->kiosk_users_model->get_realestate_users($config['per_page'], $this->uri->segment(3));

        $data['user_posts'] = filter_array_value(@$data['realestate_users']['posts']);
        $this->load->view('kiosk-users/wire-users', $data);
    } //function ends


    /**
     * get_kiosk_user_details_ajax
     *
     * @return void
     */
    public function get_kiosk_user_details_ajax()
    {

        $user_id  = $this->input->post("user_id");
        $response = $this->kiosk_users_model->get_kiosk_user_details($user_id);

        $html = '';
        $html .= "<p><b class='heading'>ID </b> $response->user_id </p>";
        $html .= "<p><b class='heading'>First Name </b> $response->first_name </p>";
        $html .= "<p><b class='heading'>Last Name </b> $response->last_name </p>";
        $html .= "<p><b class='heading'>Username </b> $response->username </p>";
        $html .= "<p><b class='heading'>Email </b> $response->email </p>";
        $html .= "<p><b class='heading'>Nickname </b> $response->username </p>";
        $html .= "<p><b class='heading'>Cell Phone </b> $response->cellphone </p>";
        $html .= "<p><b class='heading'>Corporate Address </b> $response->corporateAddress </p>";
        $html .= "<p><b class='heading'>City </b> $response->city </p>";
        $html .= "<p><b class='heading'>Country </b> $response->country </p>";

        echo $html;
        exit();
    } //function ends
    
    
    /**
     * add_nexis_account
     *
     * @return void
     */
    public function add_nexis_account()
    {
        $verfication_code = generate_random_string(6, true);
        $random_pass = empty($this->input->post("user_pass")) ? 'AryMCVPZ' : $this->input->post("user_pass");
        $password = wp_hash_password($random_pass);

        $insert_data = array(
            'user_login' => $this->input->post('user_login'),
            'user_pass' => $password,
            'user_nicename' => $this->input->post('client_name'),
            'user_email' => $this->input->post('user_email'),
            'user_registered' => date("Y-m-d H:i:s"),
            'display_name' => $this->input->post('client_name')
        );

        $meta_data = array(
            'icn_user_level' => '0',
            'emailVerificationCode' => $verfication_code,
            'emailVerificationStatus' => '1',
            'skipsmsauth' => '1',
            'corporate_address' => '',
            'icn_capabilities' => 'a:1:{s:10:"subscriber";b:1;}',
            'country' => $this->input->post('client_country'),
            'company' => $this->input->post('client_company'),
            'nexis_sqa_email' => $this->input->post('nexis_sqa_email'),
            'nexis_am_email' => $this->input->post('nexis_am_email'),
            'nexis_seller_email' => $this->input->post('nexis_seller_email'),
            'created_by' => $this->session->userdata('user_session')->user_login
        );

        $user_id = $this->kiosk_users_model->register_new_user($insert_data, $meta_data);

        if($user_id){
            $bulk_array = array( 
                "total_credit"      =>  $this->input->post("credit_request"),
                "enable_post_limit" =>  'no',
                "current_credit"    =>  0,
                "status"            =>  1,
                "user_id"           =>  $user_id,
                "package_selected"  =>  3,
                "subscription_date" =>  date("Y-m-d H:i:s") 
            );
            $status = array( 
                "user_id" => $user_id 
            );

            $this->kiosk_users_model->add_user_credits($bulk_array);
            $this->kiosk_users_model->mark_create_account_nexis($status,$this->input->post('user_id'));
            $result = true;
            
        }else{
            $result = false;
        }
    
        redirect(BASE_URL.'kiosk-users/nexisnewsire-users');
    }

    
    /**
     * create_nexis_account
     *
     * @param  mixed $user_id
     * @return void
     */
    public function create_nexis_account($user_id)
    {
        $data['user'] = $this->kiosk_users_model->get_nexis_user($user_id);

        $this->load->view('kiosk-users/add-nexis-user', $data);

    }

        
    /**
     * nexisnewsire_users
     *
     * @return void
     */
    public function nexisnewsire_users()
    {

        $config = [
            'base_url' => BASE_URL . 'kiosk-users/nexisnewsire-users/',
            'per_page' => 20,
            'total_rows' => $this->kiosk_users_model->nexisnewsire_pagination(),
            'first_link' => false,
            'last_link'  => false,
            'prev_link' => '<i class="fa fa-caret-left"></i>',
            'next_link' => '<i class="fa fa-caret-right"></i>',
            'num_links' => 2,
            'uri_segment' => 3,
            'use_page_numbers' => FALSE,
        ];


        $this->pagination->initialize($config);

        $data['nexisnewsire_users'] = $this->kiosk_users_model->get_nexisnewsire_users($config['per_page'], $this->uri->segment(3));

        $this->load->view('kiosk-users/nexis-users', $data);

    }//function ends


    /**
     * check_user_email
     *
     * @return void
     */
    public function check_user_email()
    {
        $user_email = $this->input->post('user_email');
        $response = $this->kiosk_users_model->check_user_email($user_email);
        if ($response == 1) {
            echo 'false';
        } else {
            echo 'true';
        }
    } //function end


    /**
     * check_user_login
     *
     * @return void
     */
    public function check_user_login()
    {
        $user_login = $this->input->post('user_login');
        $response = $this->kiosk_users_model->check_user_login($user_login);
        if ($response == 1) {
            echo 'false';
        } else {
            echo 'true';
        }
    } //function end


}//class end