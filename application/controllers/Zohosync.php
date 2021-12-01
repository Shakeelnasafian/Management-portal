<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Zohosync
 */
class Zohosync extends CI_Controller
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("zohosync_model");
    } //end function 


    /**
     * sync_icrowd_users_zoho
     *
     * @return void
     */
    public function sync_icrowd_users_zoho($zoho_string)
    {
        if(ZOHO_NUM == decryptor($zoho_string))
        {
            $json_array = array();
            $icrowd_array = array();
            $kiosk_array = array();
            $today = date("Y-m-d 00:00:00");
            $response = $this->zohosync_model->load_icrowd_users($today);
            $response1 = $this->zohosync_model->load_kiosk_users($today);
    
            if ($response) {
    
                foreach ($response as $user) {
                    $user_array = array(
                        'username' => $user->user_login,
                        'email' => $user->user_email,
                        'name' => $user->display_name,
                        'registerd_on' => $user->user_registered,
                    );
                    array_push($icrowd_array, $user_array);
                }
            }
            if ($response1) {
    
                foreach ($response1 as $user) {
                    $user_array = array(
                        'username' => $user->username,
                        'email' => $user->email,
                        'name' => $user->first_name . ' ' . $user->last_name,
                        'registerd_on' => $user->registration_date,
                    );
                    array_push($kiosk_array, $user_array);
                }
            }
            $json_array =  array_merge($icrowd_array, $kiosk_array);
    

        }else{
            $json_array = array(
                'data' => null,
                'response'=>503,
                'request'=>'Bad Gateway'
                
            );
        }

        echo json_encode($json_array);
    } //function ends


}
