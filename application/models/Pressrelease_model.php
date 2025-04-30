<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pressrelease_model
 */
class Pressrelease_model extends CI_Model
{

    /**
     * none_verified_pagination
     *
     * @return void
     */
    public function none_verified_pagination()
    {
        $this->db->select("*");
        $this->db->where("post_status", 0);
        $query = $this->db->get("ic_management");
        return $query->num_rows();
    } // fucntion end

    /**
     * verified_pagination
     *
     * @return void
     */
    public function verified_pagination()
    {
        $this->db->select("*");
        $this->db->where("post_status", 1);
        $query = $this->db->get("ic_management");
        return $query->num_rows();
    } // fucntion end

    /**
     * get_all_verified_prs
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_all_verified_prs(int $limit = 20, int $offset = 0)
    {
        $sql = "SELECT m.*, (SELECT GROUP_CONCAT(channel_name SEPARATOR ', ') FROM ic_management_channels AS c WHERE c.pr_id = m.pr_id) AS channel 
        FROM ic_management AS m WHERE m.post_status = 1 GROUP BY m.pr_id 
        ORDER BY m.id DESC LIMIT ? OFFSET ?;";
        
        $query = $this->db->query($sql, array($limit, $offset) );

        if ($query->num_rows() > 0) {

            $data = $query->result();
        
        } else {

            $data = null;
        }
        return $data;
    } //function end


    /**
     * get_all_none_verified_prs
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_all_none_verified_prs(int $limit = 20, int $offset = 0)
    {
        $sql = "SELECT m.*, icn_posts.ID, (SELECT GROUP_CONCAT(channel_name SEPARATOR ', ') FROM ic_management_channels AS c WHERE c.pr_id = m.pr_id) AS channel 
        FROM ic_management AS m LEFT JOIN icn_posts ON m.pr_id = icn_posts.ID
        WHERE m.post_status = 0 GROUP BY m.pr_id ORDER BY m.id DESC LIMIT ? OFFSET ?;";

        $query = $this->db->query($sql, array($limit, $offset));

        if ($query->num_rows() > 0) {

            $data = $query->result();
        
        } else {

            $data = null;
        }
        return $data;
    } //function end


    /**
     * verify_pressrelease
     *
     * @param  mixed $update_data
     * @param  mixed $pr_id
     * @return void
     */
    public function verify_pressrelease($update_data, $pr_id)
    {
        $this->db->where('pr_id', $pr_id);
        $this->db->update('ic_management', $update_data);

        if ($this->db->affected_rows() > 0) {
            $response = [
                'status' => true,
                "data" => null,
                'message' => "Pressrelease Verified successfully"
            ];
        } else {

            $response = [
                'status' => true,
                "data" => null,
                'message' => "Pressrelease Verified Failed"
            ];
        }


        return $response;
    } //fucntion end


    /**
     * filter_pr_pagination
     *
     * @param  mixed $post_author
     * @return void
     */
    public function filter_pr_pagination($post_author)
    {
        $this->db->select("*");
        $this->db->where("post_author", $post_author);
        $query = $this->db->get("ic_management");
        return $query->num_rows();
    }

    /**
     * get_filter_none_verified_prs
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @param  mixed $search_query
     * @return void
     */
    public function get_filter_none_verified_prs($post_author, $pr_title)
    {

        $sql = "SELECT m.*, icn_posts.ID, (SELECT GROUP_CONCAT(channel_name SEPARATOR ', ') FROM ic_management_channels AS c WHERE c.pr_id = m.pr_id) AS channel 
        FROM ic_management AS m LEFT JOIN icn_posts ON m.pr_id = icn_posts.ID
        WHERE m.post_status = 0 AND m.post_author = ? AND m.pr_title LIKE ? GROUP BY m.pr_id ORDER BY m.id DESC LIMIT 50;";

        $query = $this->db->query($sql, array($post_author, $pr_title));

        if ($query->num_rows() > 0) {

            $data = $query->result();
        
        } else {

            $data = null;
        }
        //dd($this->db->last_query());
        return $data;
    } //function end


    /**
     * get_post_subsription_id
     *
     * @param  mixed $post_id
     * @return void
     */
    public function get_post_subsription_id($post_id = 121)
    {
        $this->db->select("subscription_id,coupons_used");
        $this->db->where("post_id", $post_id);
        $query = $this->db->get("kiosk_subscriptions");

        if ($query->num_rows() > 0) {
            $kiosk_data = $query->row();

            // get coupon id
            $this->db->select("coupon_id");
            $this->db->where("ID", $kiosk_data->coupons_used);
            $query1 = $this->db->get("kiosk_coupon_used");

            if ($query1->num_rows() > 0) {
                $coupon_used = $query1->row();
                // get coupon code
                $this->db->select("coupon_code");
                $this->db->where("coupon_id", $coupon_used->coupon_id);
                $query2 = $this->db->get("kiosk_coupons");

                if ($query2->num_rows() > 0) {
                    $coupon = $query2->row();
                } else {
                    $coupon = null;
                }
                // get coupon code end here

            } else {
                $coupon_used = null;
            }
            // get coupon_used end here 

        } else {
            $kiosk_data = null;
        }
        // get kiosk data end here

        $response = [
            'status' => true,
            "kiosk_data" => $kiosk_data,
            "coupon_used" => $coupon_used,
            "coupon" => $coupon,
        ];
        return $response;
    } //fucntion ends

}//class end