<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Sales_model
 */
class Sales_model extends CI_Model
{

    public function pressrelease_dashboard_pagination()
    {
        $result = $this->db->query("SELECT COUNT(ID) AS post_id FROM icn_posts WHERE post_type = 'post';");
        return $result->row();

    }//function ends
    
    
    /**
     * get_icn_published_posts
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_icn_published_posts($limit = 10, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        $this->db->select("icn_posts.*, icn_users.user_login,icn_users.user_email");
        $this->db->from("icn_posts");
        $this->db->join('icn_users ', 'icn_users.ID = icn_posts.post_author', 'left');
        $this->db->where("post_type", "post");
        $this->db->where("post_status !=", "trash");
        $this->db->order_by('post_date', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;
    }//function ends


    public function sale_post_filter_pagination($search_query)
    {
        $result = $this->db->query("SELECT COUNT(ID) AS post_id FROM icn_posts WHERE post_type = 'post' AND $search_query;");
        return $result->row();

    }//function ends


    public function get_sales_filters($limit = 20,$offset = 0, $search_query)
    {
        $this->db->limit($limit, $offset);
        $this->db->select("icn_posts.*, icn_users.user_login,icn_users.user_email");
        $this->db->from("icn_posts");
        $this->db->join('icn_users ', 'icn_users.ID = icn_posts.post_author', 'left');
        $this->db->where($search_query);
        $this->db->where("post_type", "post");
        $this->db->order_by('ID', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        
        return $data;

    }//function ends


        
    /**
     * load_icn_coupons
     *
     * @param  mixed $today
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function load_icn_coupons($today, $limit = 20, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        $this->db->where('date_expire >=', $today);
        $this->db->order_by('coupon_id', 'desc');
        $query = $this->db->get("kiosk_coupons");

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;
    } //function end

    
    /**
     * active_coupon_pagination
     *
     * @param  mixed $today
     * @return void
     */
    public function active_coupon_pagination($today)
    {
        $result = $this->db->query("SELECT COUNT(coupon_id) AS coupons FROM kiosk_coupons WHERE date_expire >= '".$today."'");
        return $result->row();

    }//function ends

      
    /**
     * get_coupon_filter
     *
     * @param  mixed $coupon_code
     * @return void
     */
    public function get_coupon_filter($coupon_code)
    {
        $this->db->like('coupon_code', $coupon_code, 'after');
        $query = $this->db->get("kiosk_coupons");

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;
    }//function ends


    public function get_coupon_usage_details($coupon_id)
    {

        $query = $this->db->query("SELECT
                SUM(IF(status = 1, 1, 0)) AS coupon_used,
                SUM(IF(status = 0, 1, 0)) AS coupon_applied
        FROM kiosk_coupon_used WHERE coupon_id = '".$coupon_id."'");

        if ($query->num_rows() > 0) {
            $data = $query->row();
        } else {
            $data = null;
        }
      
        return $data;
    
    }//function ends

    public function expired_coupon_pagination($today)
    {
        $result = $this->db->query("SELECT COUNT(coupon_id) AS coupons FROM kiosk_coupons WHERE date_expire < '".$today."'");
        return $result->row();
    }//function ends

    public function load_icn_expired_coupons($today, $limit = 20, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        $this->db->where('date_expire <', $today);
        $this->db->order_by('coupon_id', 'desc');
        $query = $this->db->get("kiosk_coupons");

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;
    }

    public function get_users_all_credits($limit=100, $offset=0)
    {
        $this->db->limit($limit, $offset);
        $this->db->select("bulk_package.*, icn_users.user_login,icn_users.user_email");
        $this->db->from("bulk_package");
        $this->db->join('icn_users ', 'icn_users.ID = bulk_package.user_id', 'left');
        $this->db->where('status', 1);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;
    }//function ends

    public function get_users_all_credits_pagination()
    {
        $result = $this->db->query("SELECT COUNT(id) AS credits FROM bulk_package WHERE status = 1;");
        return $result->row();

    }//function ends

    public function get_user_credits_filter($user_email)
    {
        $this->db->select("icn_users.user_login,icn_users.user_email, bulk_package.*");
        $this->db->from("icn_users");
        $this->db->join('bulk_package', 'bulk_package.user_id = icn_users.ID', 'left');
        $this->db->where('icn_users.user_email', $user_email);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;

    }//function ends

}//class ends