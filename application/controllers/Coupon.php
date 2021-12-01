<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Coupon
 */
class Coupon extends CI_Controller
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

            redirect(BASE_URL);
        }
    } //function ends 


    /**
     * icn_coupons
     *
     * @return void
     */
    public function icn_coupons()
    {
        check_user_role(6);

        $today = date('Y-m-d');
        $response['coupons'] = $this->coupon_model->load_icn_coupons($today);
        $this->load->view("coupon/active-coupons", $response);
    } //function ends


    /**
     * view_coupon
     *
     * @param  mixed $coupon_id
     * @return void
     */
    public function view_coupon($coupon_id)
    {
        check_user_role(6);
        $response = $this->coupon_model->view_coupon_data($coupon_id);
        $this->load->view("coupon/view-coupon", $response);
    } //function ends 


    /**
     * edit_coupon
     *
     * @param  mixed $coupon_id
     * @return void
     */
    public function edit_coupon($coupon_id)
    {
        check_user_role(8);
        $response['coupon'] = $this->coupon_model->edit_coupon_data($coupon_id);
        $this->load->view("coupon/edit-coupon", $response);
    } //function ends 


    /**
     * update_coupon
     *
     * @param  mixed $coupon_id
     * @return void
     */
    public function update_coupon($coupon_id)
    {

        check_user_role(8);
        $this->form_validation->set_rules('date_expire', 'Expirey Date', 'required');
        $this->form_validation->set_rules('discount_price', 'Discount Price', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
            redirect(BASE_URL . 'coupon/edit_coupon/' . $coupon_id);
        } else {

            $coupon_limit = ($this->input->post('coupon_counter') == 0 ? 'no' : 'yes');
            $update_data = [
                'discount_price' => $this->input->post('discount_price'),
                'discount_type' => $this->input->post('discount_type'),
                'date_expire' => $this->input->post('date_expire'),
                'kiosk_instance' => $this->input->post('kiosk_instance'),
                'pack_id'   =>  $this->input->post('pack_id'),
                'one_time_per_user' => $this->input->post('one_time_per_user'),
                'coupon_counter' => $this->input->post('coupon_counter'),
                'coupon_emails' => $this->input->post('coupon_emails'),
                'limit_coupon' => $coupon_limit,
                'edited_by' => $this->session->userdata('user_session')->user_login,
                'ip_address' => $this->input->ip_address(),
                'transaction_id' => $this->input->post('transaction_id'),
                'payment_status' => $this->input->post('payment_status'),
                'amount' => $this->input->post('amount'),
            ];

            $response = $this->coupon_model->update_coupon_data($update_data, $coupon_id);
            if ($response['status']) {
                $update_coupon_history_data = [
                    'counter' => $this->input->post('coupon_counter'),
                    'coupon_price' => $this->input->post('discount_price'),
                    'coupon_type' => $this->input->post('discount_type'),
                    'coupon_id' => $coupon_id,
                    'ip_address' => $this->input->ip_address(),
                    'updated_by' => $this->session->userdata('user_session')->user_login,
                    'action' => 'updated',
                    // 'updated_at' => now(),
                ];
                $this->create_coupon_history($update_coupon_history_data);

                $this->session->set_flashdata('success-message', $response['message']);
                redirect(BASE_URL . 'coupon/view_coupon/' . $coupon_id);
            } else {
                $this->session->set_flashdata('error-message', $response['message']);
                redirect(BASE_URL . 'coupon/view_coupon/' . $coupon_id);
            }
        }
    } //function ends


    /**
     * add_coupon
     *
     * @return void
     */
    public function add_coupon()
    {
        check_user_role(8);
        $this->load->view("coupon/add-coupon");
    } //function ends 


    /**
     * create_coupon
     *
     * @return void
     */
    public function create_coupon()
    {
        check_user_role(8);

        $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'required');
        $this->form_validation->set_rules('discount_price', 'Discount Price', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
            redirect(BASE_URL . 'coupon/icn-coupons');
        } else {

            $coupon_limit = ($this->input->post('coupon_counter') == 0 ? 'no' : 'yes');
            $insert_data = [
                'coupon_code' => $this->input->post('coupon_code'),
                'discount_price' => $this->input->post('discount_price'),
                'discount_type' => $this->input->post('discount_type'),
                'date_expire' => $this->input->post('date_expire'),
                'kiosk_instance' => $this->input->post('kiosk_instance'),
                'pack_id'        => $this->input->post('pack_id'),
                'one_time_per_user' => $this->input->post('one_time_per_user'),
                'coupon_counter' => $this->input->post('coupon_counter'),
                'coupon_emails' => $this->input->post('coupon_emails'),
                'limit_coupon' => $coupon_limit,
                'date_added' => date('Y-m-d h:i:s'),
                'wp_post_id' => 0,
                'created_by' => $this->session->userdata('user_session')->user_login,
                'ip_address' => $this->input->ip_address(),
                'transaction_id' => $this->input->post('transaction_id'),
                'payment_status' => $this->input->post('payment_status'),
                'amount' => $this->input->post('amount'),
            ];

            $response = $this->coupon_model->create_new_coupon($insert_data, $this->input->post('pack_id'));
            if ($response['status']) {
                $update_coupon_history_data = [
                    'counter' => $this->input->post('coupon_counter'),
                    'coupon_price' => $this->input->post('discount_price'),
                    'coupon_type' => $this->input->post('discount_type'),
                    'coupon_id' => $response['coupon_id'],
                    'ip_address' => $this->input->ip_address(),
                    'updated_by' => $this->session->userdata('user_session')->user_login,
                    'action' => 'created',
                    // 'updated_at' => now(),
                ];
                $this->create_coupon_history($update_coupon_history_data);
                $this->session->set_flashdata('success-message', $response['message']);
                redirect(BASE_URL . 'coupon/view-coupon/' . $response['coupon_id']);
            } else {
                $this->session->set_flashdata('error-message', $response['message']);
                redirect(BASE_URL . 'coupon/icn-coupons/');
            }
        }
    } //function ends


    /**
     * expired_coupons
     *
     * @return void
     */
    public function expired_coupons()
    {
        check_user_role(6);

        $today = date('Y-m-d');
        $response['coupons'] = $this->coupon_model->load_icn_expired_coupons($today);
        $this->load->view("coupon/expired-coupons", $response);
    } //function ends


    /**
     * check_coupon_code
     *
     * @return void
     */
    public function check_coupon_code()
    {
        check_user_role(6);
        $coupon_code = $this->input->post('coupon_code');
        $response = $this->coupon_model->check_coupon_code_data($coupon_code);
        if ($response == 1) {
            echo 'false';
        } else {
            echo 'true';
        }
    } //function end


    /**
     * expire_coupon
     *
     * @param  mixed $coupon_id
     * @return void
     */
    public function expire_coupon($coupon_id)
    {
        check_user_role(8);

        $date = date('Y-m-d', strtotime('yesterday'));
        $update_data = [
            'date_expire' => $date,
        ];
        $response = $this->coupon_model->expire_coupon_data($update_data, $coupon_id);

        if ($response['status']) {
            $this->session->set_flashdata('success-message', $response['message']);
            redirect(BASE_URL . 'coupon/view_coupon/' . $coupon_id);
        } else {
            $this->session->set_flashdata('error-message', $response['message']);
            redirect(BASE_URL . 'coupon/view_coupon/' . $coupon_id);
        }
    } //function end


    /**
     * coupon_filters
     *
     * @return void
     */
    public function coupon_filters()
    {
        check_user_role(6);
        $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'required');

        if ($this->form_validation->run() === FALSE) {

            $this->session->set_flashdata('validation_failed', strip_tags(validation_errors()));
            redirect(BASE_URL . 'coupon/icn-coupons');
        } else {

            $coupon_code = $this->input->post('coupon_code');

            $response['coupons'] = $this->coupon_model->get_coupon_filter($coupon_code);
            $this->load->view("coupon/active-coupons", $response);
        }
    } //function ends

    
    /**
     * create_coupon_history
     *
     * @param  mixed $data
     * @return void
     */
    public function create_coupon_history($data)
    {
        $response = $this->coupon_model->update_coupon_history_data($data);
    }
    
    
    /**
     * transaction_details
     *
     * @return void
     */
    public function transaction_details()
    {
        check_user_role(6);
        $this->load->view("coupon/trans-details");
    }//function ends
    
    
    /**
     * get_transaction_details
     *
     * @return void
     */
    public function get_transaction_details()
    {
        $post_id = (int) $this->input->post('post_id');
        $response = $this->coupon_model->get_tans_details($post_id);

        if($response){

            $return_str = <<<EOD
                        <table class="table m-0">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Cost</th>
                                <th>Transaction ID</th>
                                <th>Payer Email</th>
                                <th>Payer Name</th>
                                <th>Date</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>$response->user_id</td>
                                <td>$response->payment_type</td>
                                <td>$response->status</td>
                                <td>$response->cost</td>
                                <td>$response->transaction_id</td>
                                <td>$response->payer_email</td>
                                <td>$response->payer_first_name $response->payer_last_name</td>
                                <td>$response->created</td>
                            </tr>
                        </tbody>
                    </table>
                    EOD;
        }else{
            $return_str ='<div><span class="trans-not-found">No Record Found</span></div>';
        }
        echo $return_str;
    }//function ends

}//class end
