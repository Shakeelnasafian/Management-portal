<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Kiosk_users_model
 */
class Kiosk_users_model extends CI_Model
{

    /**
     * pressrelease_pagination
     *
     * @return void
     */
    public function pressrelease_pagination()
    {
        $query = $this->db->query("SELECT icn_users.* FROM icn_users INNER JOIN icn_usermeta  ON icn_users.ID = icn_usermeta.user_id WHERE icn_usermeta.meta_key = 'icn_capabilities' AND icn_usermeta.meta_value LIKE '%subscriber%' 
        ORDER BY icn_users.ID");

        return $query->num_rows();
    } //function end

    /**
     * get_pressrelease_users
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_pressrelease_users($limit = 20, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        $this->db->select("icn_users.*");
        $this->db->from("icn_users");
        $this->db->join('icn_usermeta ', 'icn_usermeta.user_id = icn_users.ID', 'INNER');
        $this->db->where('icn_usermeta.meta_key', 'icn_capabilities');
        $this->db->like('icn_usermeta.meta_value', 'subscriber');


        $this->db->order_by('icn_users.ID', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $result['users'] = $query->result();
            $posts_id = array_column($result['users'], 'ID');

            $this->db->select("subscription_id,user_id");
            $this->db->from("kiosk_subscriptions");
            $this->db->where_in("user_id", $posts_id);
            $this->db->where_in("kiosk_id", 19);

            $query1 = $this->db->get();

            if ($query1->num_rows() > 0) {

                $result['posts'] = $query1->result();
            } else {
                $result['posts'] = null;
            }
        } else {
            $result = null;
        }
        return $result;
    } //fucntion ends


    /**
     * get_pressrelease_user_details
     *
     * @param  mixed $ID
     * @return void
     */
    public function get_pressrelease_user_details($ID = 123)
    {
        $query = $this->db->query(
            "SELECT
            icn_users.ID,
            icn_users.display_name,
            icn_users.user_email,
            icn_users.user_login,
            icn_users.user_nicename,
            max( CASE WHEN icn_usermeta.meta_key = 'first_name' THEN icn_usermeta.meta_value END ) first_name,
            max( CASE WHEN icn_usermeta.meta_key = 'last_name' THEN icn_usermeta.meta_value END ) last_name,
            max( CASE WHEN icn_usermeta.meta_key = 'cell_phone' THEN icn_usermeta.meta_value  END ) cell_phone,
            max( CASE WHEN icn_usermeta.meta_key = 'state_region' THEN icn_usermeta.meta_value END ) state_region,
            max( CASE WHEN icn_usermeta.meta_key = 'corporate_address' THEN icn_usermeta.meta_value END ) corporate_address,
            max( CASE WHEN icn_usermeta.meta_key = 'city' THEN icn_usermeta.meta_value END ) city,   
            max( CASE WHEN icn_usermeta.meta_key = 'country' THEN icn_usermeta.meta_value END ) country
             FROM
                 icn_users,
                 icn_usermeta 
             WHERE
                 icn_users.ID = icn_usermeta.user_id 
                 AND '$ID' = icn_users.ID 
             GROUP BY
                 icn_usermeta.user_id"
        );
        // print_r($this->db->last_query());

        if ($query->num_rows() > 0) {
            $result = $query->row();
        } else {
            $result = null;
        }
        return $result;
    } //function ends


    /**
     * legal_pagination
     *
     * @return void
     */
    public function legal_pagination()
    {
        $this->db->select("*");
        $this->db->where("user_owner", "Legal Newswire");
        $query = $this->db->get("kiosk_users");
        return $query->num_rows();
    } //function ends


    /**
     * get_legal_users
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_legal_users($limit = 20, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        $this->db->select("*");
        $this->db->from("kiosk_users");
        $this->db->where('user_owner', 'Legal Newswire');
        $this->db->order_by('user_id', 'DESC');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $result['users'] = $query->result();
            $posts_id = array_column($result['users'], 'user_id');

            $this->db->select("subscription_id,user_id");
            $this->db->from("kiosk_subscriptions");
            $this->db->where_in("user_id", $posts_id);
            $this->db->where_in("kiosk_id", 47);

            $query1 = $this->db->get();

            if ($query1->num_rows() > 0) {

                $result['posts'] = $query1->result();
            } else {
                $result['posts'] = null;
            }
        } else {

            $result['users'] = null;
        }

        return $result;
    } //function ends


    /**
     * content_pagination
     *
     * @return void
     */
    public function content_pagination()
    {
        $this->db->select("*");
        $this->db->where("user_owner", "Content Marketing");
        $query = $this->db->get("kiosk_users");
        return $query->num_rows();
    } //function ends



    /**
     * get_content_users
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_content_users($limit, $offset)
    {
        $this->db->limit($limit, $offset);
        $this->db->select("*");
        $this->db->from("kiosk_users");
        $this->db->where('user_owner', 'Content Marketing');
        $this->db->order_by('user_id', 'DESC');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $result['users'] = $query->result();
            $posts_id = array_column($result['users'], 'user_id');

            $this->db->select("subscription_id,user_id");
            $this->db->from("kiosk_subscriptions");
            $this->db->where_in("user_id", $posts_id);
            $this->db->where_in("kiosk_id", 55);

            $query1 = $this->db->get();

            if ($query1->num_rows() > 0) {

                $result['posts'] = $query1->result();
            } else {
                $result['posts'] = null;
            }
        } else {
            $result = null;
        }
        return $result;
    } //function ends



    /**
     * realestate_pagination
     *
     * @return void
     */
    public function realestate_pagination()
    {
        $this->db->select("*");
        $this->db->where("user_owner", "Wire.RealEstate");
        $query = $this->db->get("kiosk_users");
        return $query->num_rows();
    } //function ends



    /**
     * get_realestate_users
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_realestate_users($limit, $offset)
    {
        $this->db->limit($limit, $offset);
        $this->db->select("*");
        $this->db->from("kiosk_users");
        $this->db->where('user_owner', 'Wire.RealEstate');
        $this->db->order_by('user_id', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $result['users'] = $query->result();
            $posts_id = array_column($result['users'], 'user_id');

            $this->db->select("subscription_id,user_id");
            $this->db->from("kiosk_subscriptions");
            $this->db->where_in("user_id", $posts_id);
            $this->db->where_in("kiosk_id", 56);

            $query1 = $this->db->get();

            if ($query1->num_rows() > 0) {

                $result['posts'] = $query1->result();
            } else {
                $result['posts'] = null;
            }
        } else {
            $result = null;
        }

        return $result;
    } //function ends


    /**
     * get_kiosk_user_details
     *
     * @param  mixed $user_id
     * @return void
     */
    public function get_kiosk_user_details($user_id)
    {
        $this->db->select("*");
        $this->db->where("user_id", $user_id);
        $query = $this->db->get("kiosk_users");

        if ($query->num_rows() > 0) {
            $result = $query->row();
        } else {
            $result = null;
        }
        return $result;
    } //function ends
    

    /**
     * get_nexis_user
     *
     * @param  mixed $ID
     * @return void
     */
    public function get_nexis_user($ID)
    {
        $this->db->select("*");
        $this->db->where('ID', $ID);

        $query = $this->db->get("nexis_sales_form");

        if ($query->num_rows() > 0) {

            $result = $query->row();
        } else {
            $result = null;
        }
        return $result;

    }//function ends
    
    
    /**
     * nexisnewsire_pagination
     *
     * @return void
     */
    public function nexisnewsire_pagination()
    {
        $this->db->select("*");
        $query = $this->db->get("nexis_sales_form");
        return $query->num_rows();
    } //function end

    
    /**
     * get_nexisnewsire_users
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_nexisnewsire_users($limit = 20, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        $this->db->select("*");
        $this->db->order_by('ID', 'DESC');

        $query = $this->db->get("nexis_sales_form");

        if ($query->num_rows() > 0) {

            $result = $query->result();
        } else {
            $result = null;
        }
        return $result;

    }//function ends

  
    /**
     * add_user_credits
     *
     * @param  mixed $inser_data
     * @return void
     */
    public function add_user_credits($inser_data)
    {
        $this->db->insert('bulk_package', $inser_data);
        return;

    }//function ends

    
     /**
     * register_new_user
     *
     * @param  mixed $inser_data
     * @param  mixed $meta_data
     * @return void
     */
    public function register_new_user($inser_data, $meta_data)
    {
        $this->db->insert('icn_users', $inser_data);
        $responce_id = $this->db->insert_id();
        if ($responce_id) {

            foreach ($meta_data as $key => $value) {
                $insert_data = array(
                    'user_id' => $responce_id,
                    'meta_key' => $key,
                    'meta_value' => $value
                );
                $this->db->insert('icn_usermeta', $insert_data);
            }
        }

        return $responce_id;
    } //function ends
    

    /**
     * mark_create_account_nexis
     *
     * @param  mixed $data
     * @param  mixed $user_id
     * @return void
     */
    public function mark_create_account_nexis($data,$user_id)
    {
        $this->db->where("ID", $user_id);
        $this->db->update("nexis_sales_form", $data);

        if ($this->db->affected_rows() > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }//function ends


      /**
     * check_user_email
     *
     * @param  mixed $user_email
     * @return void
     */
    public function check_user_email($user_email)
    {
        $this->db->select("*");
        $this->db->where("user_email", $user_email);
        $query = $this->db->get("icn_users");
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    } // function end


    /**
     * check_user_login
     *
     * @param  mixed $user_login
     * @return void
     */
    public function check_user_login($user_login)
    {
        $this->db->select("*");
        $this->db->where("user_login", $user_login);
        $query = $this->db->get("icn_users");
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    } // function end

    public function find_icn_user($email)
    {
        $this->db->select("icn_users.ID,icn_users.user_login,icn_users.user_nicename,icn_users.user_email,bulk_package.total_credit,bulk_package.package_selected,bulk_package.current_credit");
        $this->db->from('icn_users');
        $this->db->join('bulk_package', 'icn_users.ID = bulk_package.user_id', 'left');
        $this->db->where("icn_users.user_email ='$email' OR icn_users.user_login = '$email'");

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $result = $query->row();
        } else {
            $result = null;
        }
        return $result;

    }//function ends

    public function update_bulk_user_credits($user_id, $update_array)
    {
        $this->db->where("user_id", $user_id);
        $this->db->update("bulk_package", $update_array);

        if ($this->db->affected_rows() > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;

    }//function ends
        


}//class ends