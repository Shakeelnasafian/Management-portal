<?php

/**
 * Users_model
 */
class Users_model extends CI_Model
{

    /**
     * login
     *
     * @param  mixed $username
     * @return void
     */
    public function login($username)
    {

        $this->db->select("*");
        $this->db->where("(user_login = '$username' OR user_email = '$username')");
        $query = $this->db->get('ic_users');

        if ($query->num_rows() > 0) {

            $results = $query->row();
        } else {
            $results =  false;
        }

        return $results;
    } // login function ends

    /**
     * check_user_login_ajax_data
     *
     * @param  mixed $user_login
     * @return void
     */
    public function check_user_login_ajax_data($user_login)
    {
        $this->db->select("*");
        $this->db->where("user_login", $user_login);
        $query = $this->db->get("ic_users");
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    } //function end

    /**
     * check_user_email_ajax_data
     *
     * @param  mixed $user_email
     * @return void
     */
    public function check_user_email_ajax_data($user_email)
    {
        $this->db->select("*");
        $this->db->where("user_email", $user_email);
        $query = $this->db->get("ic_users");
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    } //function end

    /**
     * create_new_user_data
     *
     * @param  mixed $insert_data
     * @return void
     */
    public function create_new_user_data($insert_data)
    {
        if ($this->db->insert('ic_users', $insert_data)) {

            $response = [
                'status' => true,
                "data" => null,
                'message' => "User created successfully."
            ];
        } else {
            $response = [
                'status' => false,
                "data" => null,
                'message' => "Some error occurred during User registration. Please try again."
            ];
        }
        return $response;
    } //function end
    
    /**
     * get_profile
     *
     * @param  mixed $ID
     * @return void
     */
    public function get_profile($ID)
    {
        $this->db->select("*");
        $this->db->where("ID", $ID);
        $query = $this->db->get('ic_users');

        if ($query->num_rows() > 0) {

            $results = $query->row();
            
        } else {
            $results =  false;
        }

        return $results;
    }//function ends

    
    /**
     * update_user_profile
     *
     * @param  mixed $update_data
     * @param  mixed $ID
     * @return void
     */
    public function update_user_profile($update_data, $ID)
    {
        $this->db->where('ID', $ID);
        $this->db->update('ic_users', $update_data);

        if ($this->db->affected_rows() > 0) {
            $response = [
                'status' => true,
                "data" => null,
                'message' => "Profile Updated successfully"
            ];
        } else {

            $response = [
                'status' => true,
                "data" => null,
                'message' => "Profile Updation Failed"
            ];
        }
        return $response;
    }//function ends
    

    /**
     * check_user_forgot_password
     *
     * @param  mixed $email
     * @return void
     */
    public function check_user_forgot_password($email)
    {
        $this->db->select("ID,user_login,user_email");
        $this->db->where("user_email", $email);
        $query = $this->db->get('ic_users');

        if ($query->num_rows() > 0) {

            $results = $query->row();
            
        } else {
            $results =  false;
        }

        return $results;
    }//function ends
    

    /**
     * save_user_verify_code
     *
     * @param  mixed $user_id
     * @param  mixed $verify_code
     * @return void
     */
    public function save_user_verify_code($user_id,$verify_code)
    {
        $this->db->where('ID',$user_id);
        $this->db->set('verify_code', $verify_code);
        $this->db->update('ic_users');
        return;

    }//function ends

    public function user_verification($ID)
    {
        $this->db->select("ID,user_login,user_email,verify_code");
        $this->db->where("ID", $ID);
        $query = $this->db->get('ic_users');

        if ($query->num_rows() > 0) {

            $results = $query->row();
            
        } else {
            $results =  false;
        }

        return $results;
    }

    public function update_user_password($ID, $update_data)
    {

        $this->db->where('ID', $ID);
        $this->db->update('ic_users', $update_data);

        if ($this->db->affected_rows() > 0) {
            $response = [
                'status' => true,
                "data" => null,
                'message' => "Password Updated successfully"
            ];
        } else {

            $response = [
                'status' => true,
                "data" => null,
                'message' => "Password Updation Failed"
            ];
        }
        return $response;

    }//function ends

}//class end here