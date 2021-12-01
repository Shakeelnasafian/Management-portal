<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Zohosync_model
 */
class Zohosync_model extends CI_Model
{

    public function load_icrowd_users($today)
    {
        $this->db->select("icn_users.user_login,icn_users.user_email,icn_users.user_registered,icn_users.display_name");
        $this->db->from("icn_users");
        $this->db->join('icn_usermeta ', 'icn_usermeta.user_id = icn_users.ID', 'INNER');
        $this->db->where('icn_usermeta.meta_key', 'icn_capabilities');
        $this->db->where('icn_users.user_registered >=', $today);
        $this->db->like('icn_usermeta.meta_value', 'subscriber');
        $this->db->order_by('icn_users.ID', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $result = $query->result();
        } else {
            $result = null;
        }
        return $result;
    }//function ends

    public function load_kiosk_users($today)
    {
        $this->db->select("first_name,last_name,username,email,registration_date");
        $this->db->where('registration_date >=', $today);
        $query = $this->db->get('kiosk_users');

        if ($query->num_rows() > 0) {
            $result = $query->result();
        } else {
            $result = null;
        }
        return $result;
    }//function ends

}