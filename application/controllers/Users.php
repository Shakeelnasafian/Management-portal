<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Users
 */
class Users extends CI_Controller
{

    /**
     * __construct
     *
     * @return void
     */
    function __construct()
    {
        parent::__construct();
        require_once APPPATH . "/third_party/class-phpass.php"; //library for encrpting password
       
    } //end function 


    /**
     * login
     *
     * @return void
     */
    public function login()
    {
        // if already logged in
        if ($this->session->userdata('logged_in')) {
            if ($this->session->userdata('role') == "editor") {
                redirect(BASE_URL . 'management');
            }
        }
        //end
        $data['title'] = "Login";

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {

            $this->load->view('users/login', $data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $response = $this->users_model->login($username);
           
            if ($response && check_wp_password($password, $response->user_pass)) {

                $this->session->set_userdata('user_session', $response);
                redirect(BASE_URL . "users/send-sms-code");
            } else {

                $this->session->set_flashdata('login_failed', 'Please login with Correct username & Password');
                redirect(BASE_URL . 'users/login');
            }
        }
    } //function end


    /**
     * send_sms_code
     *
     * @return void
     */
    public function send_sms_code()
    {
        $random = generate_random_string(4, true);

        $text = "Your Icrowd Management verification code is : $random";

        $mobile_number = $this->session->userdata('user_session')->cell_phone;

        if ($mobile_number) {

            send_message($mobile_number, $text);
            $data['mobile_number'] = $mobile_number;

            $this->session->set_flashdata('sms_sent', ' We have sent One Time PIN to your registered Mobile Number:' . $mobile_number . ' Please enter the received PIN to continue.');

            $this->session->set_userdata('sms_verification', $random);
        } else {
            $this->session->set_flashdata('sms_sent', 'Kindly Provide US a Cell Number so that we can Authenticate you by Sending Code Thanks');
        }

        $this->load->view('users/sms-verification');
    } //function end


    /**
     * verify_code
     *
     * @return void
     */
    public function verify_code()
    {
        $code = $this->input->post('verify_code');

        if ($this->session->userdata('sms_verification') == $code) {

            $this->session->userdata('user_session')->logged_in = true;
            unset($_SESSION['sms_verification']);
            redirect(BASE_URL);
        } else {

            $this->session->set_flashdata('sms_verfication_failed', 'You have entered an invalid code click the link to recive another code <a href="' . BASE_URL . 'users/send-sms-code/">Click</a>');

            $this->load->view('users/sms-verification');
        }
    } //function end


    /**
     * add_user
     *
     * @return void
     */
    public function add_user()
    {
        if (!($this->session->userdata('user_session')->logged_in &&  $this->session->userdata('user_session')->icn_role == 'Administrator')) {

            redirect(BASE_URL . 'users/login');
        }else{

            $this->load->view('users/add-user');
        }
    } //function end

    
    /**
     * edit_profile
     *
     * @param  mixed $ID
     * @return void
     */
    public function edit_profile($ID)
    {
        if (!$this->session->userdata('user_session')->logged_in) {

            redirect(BASE_URL . 'users/login');

        }else{

            $response['user'] = $this->users_model->get_profile($ID);
            $this->load->view('users/profile',$response);

        }

        
    } //function end

         
    /**
     * update_profile
     *
     * @param  mixed $ID
     * @return void
     */
    public function update_profile($ID)
    {

        if (!$this->session->userdata('user_session')->logged_in) {

            redirect(BASE_URL . 'users/login');
        }

        $this->form_validation->set_rules('new_pass', 'New Password', 'required');
        $this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'required');
        $this->form_validation->set_rules('cell_phone', 'Cell Phone', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
            redirect(BASE_URL . 'users/edit-profile/'.$ID);
        } else {

            $wp_hasher = new PasswordHash(10, true);
            $password = $wp_hasher->HashPassword($this->input->post('new_pass'));

            $image_url = empty($_FILES["profile_image"]['name']) ? '' : aws_upload_image($_FILES["profile_image"]);
            

            $update_data = [
                'user_pass' => $password,
                'cell_phone' => $this->input->post('cell_phone'),
                'profile_image' => $image_url
            ];

            $response = $this->users_model->update_user_profile($update_data, $ID);
            if ($response['status']) {
                $this->session->set_flashdata('success-message', $response['message']);
                redirect(BASE_URL . 'users/edit-profile/'.$ID);
            } else {
                $this->session->set_flashdata('error-message', $response['message']);
                redirect(BASE_URL . 'users/edit-profile/'.$ID);
            }
        }

    }//function ends


    /**
     * create_new_user
     *
     * @return void
     */
    public function create_new_user()
    {
        if (!($this->session->userdata('user_session')->logged_in &&  $this->session->userdata('user_session')->icn_role == 'Administrator')) {

            redirect(BASE_URL . 'users/login');
        }

        $this->form_validation->set_rules('user_login', 'User Login', 'required');
        $this->form_validation->set_rules('user_email', 'User Email', 'required');
        $this->form_validation->set_rules('user_pass', 'User Pass', 'required');
        $this->form_validation->set_rules('cell_phone', 'Cell Phone', 'required');
        $this->form_validation->set_rules('icn_role', 'Icn Role', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
            redirect(BASE_URL . 'users/add-user');
        } else {

            $wp_hasher = new PasswordHash(10, true);
            $password = $wp_hasher->HashPassword($this->input->post('user_pass'));

            $insert_data = [
                'user_login' => $this->input->post('user_login'),
                'user_pass' => $password,
                'user_email' => $this->input->post('user_email'),
                'user_registered' => date('Y-m-d h:i:s'),
                'cell_phone' => $this->input->post('cell_phone'),
                'icn_role' => $this->input->post('icn_role')
            ];

            $response = $this->users_model->create_new_user_data($insert_data);
            if ($response['status']) {
                $this->session->set_flashdata('success-message', $response['message']);
                redirect(BASE_URL . 'users/add-user');
            } else {
                $this->session->set_flashdata('error-message', $response['message']);
                redirect(BASE_URL . 'users/add-user/');
            }
        }
    } //fucntion end


    /**
     * check_user_login_ajax
     *
     * @return void
     */
    public function check_user_login_ajax()
    {
        $user_login = $this->input->post('user_login');
        $response = $this->users_model->check_user_login_ajax_data($user_login);
        if ($response == 1) {
            echo 'false';
        } else {
            echo 'true';
        }
    } //function end


    /**
     * check_user_email_ajax
     *
     * @return void
     */
    public function check_user_email_ajax()
    {
        $user_email = $this->input->post('user_email');
        $response = $this->users_model->check_user_email_ajax_data($user_email);
        if ($response == 1) {
            echo 'false';
        } else {
            echo 'true';
        }
    } //function ends
    
    
    /**
     * forgot_password
     *
     * @return void
     */
    public function forgot_password()
    {
        $this->load->view('users/forgot-password');
    }//function ends

    
    /**
     * check_user
     *
     * @return void
     */
    public function check_user()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));

            $this->session->set_flashdata('email_failed', 'Please enter the email');
            redirect(BASE_URL . 'users/forgot-password');

        } else {

            $user_email = $this->input->post('email');

            $response = $this->users_model->check_user_forgot_password($user_email);
            if($response){

                $verfication_code = generate_random_string(6, true);
                $verify_code = $response->ID . $verfication_code;
    
                $data['verification_link'] = BASE_URL . 'users/reset-password/' . encryptor($verify_code);
                $data['full_name'] = $response->user_login;
                $template = 'email_templates/verification_link';
                $subject = 'Password rest link';
                $recipient = $response->user_email;
                send_email($template, $recipient, $subject, $data);

                $this->users_model->save_user_verify_code($response->ID,$verfication_code);
    
                $this->session->set_flashdata('email_sent', 'Verification Email has been sent to you registerd account please click on the link to verify account.');
                redirect(BASE_URL . 'users/forgot-password');

            }else{
                $this->session->set_flashdata('email_failed', 'We are sorry! we did not find any account associated with your email, Please try with valide email.');
                redirect(BASE_URL . 'users/forgot-password');
            }

        }

    }//function ends

     /**
     * reset_password
     *
     * @param  mixed $string_data
     * @return void
     */
    public function reset_password($string_data)
    {
        $string = decryptor($string_data);
        $user_id = substr($string, 0, -6);
        $verify_code = substr($string, -6);

        $response = $this->users_model->user_verification($user_id);

        if (!empty($response)  &&  $response->verify_code == $verify_code) {
            
            $data['user'] = $response;
            $data['secret_string'] = $string_data;

            $this->load->view('users/change-password', $data);
        } else {

            $this->session->set_flashdata('email_failed', 'Unfortunately, there appears to be a problem in your request.');
            redirect(BASE_URL . 'users/forgot-password');
        }
    } //function ends


    /**
     * update_password
     *
     * @return void
     */
    public function update_password()
    {
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {

            $this->session->set_flashdata('password_error', 'Unfortunately, there appears to be a problem in your request.');
            redirect(BASE_URL . 'users/reset-password/'.$this->input->post('user_pass'));
        } else {

            $string = decryptor($this->input->post('user_token'));

            $user_id = substr($string, 0, -6);
            $verify_code = substr($string, -6);

            $response = $this->users_model->user_verification($user_id);

            if (!empty($response)  &&  $response->verify_code == $verify_code) {

                $wp_hasher = new PasswordHash(10, true);
                $password = $wp_hasher->HashPassword($this->input->post('password'));

                $data = array(
                    'user_pass' => $password
                );

                $this->users_model->update_user_password($response->ID, $data);
                
                $this->session->set_flashdata('password_changed', 'Your password has been updated.<br>Please login with your new password. ');
                redirect(BASE_URL . 'users/reset-password/'.$this->input->post('user_token'));

               
            } else {

                $this->session->set_flashdata('password_error', 'Unfortunately, there appears to be a problem in your request. ');
                redirect(BASE_URL . 'users/reset-password/'.$this->input->post('user_token'));
            }
        }
    } //function ends





    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        $this->session->sess_destroy();
        // Set message
        $this->session->set_flashdata('user_loggedout', 'You are now logged out');

        redirect(BASE_URL . 'users/login');
    } //function end

}//class end
