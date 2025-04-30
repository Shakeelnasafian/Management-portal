<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Management_model
 */
class Management_model extends CI_Model
{
    

    /**
     * get_icn_management_dashboard_data
     *
     * @param  mixed $day_start
     * @param  mixed $day_end
     * @return void
     */
    public function get_icn_management_dashboard_data($day_start, $day_end)
    {
        $query = $this->db->query("SELECT COUNT(id) AS total_posts_today,
                    Sum( CASE WHEN frankly_links = 1 THEN 1 ELSE 0 END ) AS total_frankly_posts,
                    Sum( CASE WHEN bignews_links = 1 THEN 1 ELSE 0 END ) AS total_bignews_links,
                    Sum( CASE WHEN financial_links = 1 THEN 1 ELSE 0 END ) AS total_financial_links,
                    Sum( CASE WHEN post_status = 1 THEN 1 ELSE 0 END ) AS today_verified_posts,
                    Sum( CASE WHEN post_status = 0 THEN 1 ELSE 0 END ) AS today_unveified_posts
                        FROM ic_management;");

        $response =  $query->row();

        $query2 = $this->db->query("SELECT 
                        Sum( CASE WHEN channel_name = 'frankly_links' THEN 1 ELSE 0 END ) AS total_frankly_posts,
                        Sum( CASE WHEN channel_name = 'bignews_links' THEN 1 ELSE 0 END ) AS total_bignews_links,
                        Sum( CASE WHEN channel_name = 'financial_links' THEN 1 ELSE 0 END ) AS total_financial_links,
                        Sum( CASE WHEN channel_name = 'ips_links' THEN 1 ELSE 0 END ) AS total_ips_links
                                FROM ic_management_channels;");
        $channels =  $query2->row();



        $result = $this->db->query("SELECT DISTINCT kiosk_coupons.coupon_id,kiosk_coupons.coupon_code, (SELECT COUNT(*) FROM kiosk_coupon_used
                    WHERE coupon_id = kiosk_coupons.coupon_id) AS couponUsed FROM kiosk_coupons WHERE kiosk_coupons.date_expire >= '$day_start' HAVING couponUsed > 15  ORDER BY kiosk_coupons.coupon_id DESC");
        $mostly_used_coupons =  $result->result();

        $response = [
            'status' => true,
            'response_data' => $response,
            'channels_data' => $channels,
            "mostly_used_coupons" => $mostly_used_coupons,
            'message' => "Dashboard stats."
        ];
        return $response;
    }
    

    /**
     * get_total_day_count
     *
     * @param  mixed $day_start
     * @param  mixed $day_end
     * @return void
     */
    public function get_total_day_count($day_start, $day_end)
    {
        $this->db->where('pr_publish_time >=', $day_start);
        $this->db->where('pr_publish_time <=', $day_end);

        $query = $this->db->get("ic_management");

        if ($query->num_rows() > 0) {

            $data = $query->num_rows();
        } else {
            $data = 0;
        }
        return $data;
    } //function end
    

    /**
     * get_day_unverified_count
     *
     * @param  mixed $day_start
     * @param  mixed $day_end
     * @return void
     */
    public function get_day_unverified_count($day_start, $day_end)
    {
        $this->db->where('pr_publish_time >=', $day_start);
        $this->db->where('pr_publish_time <=', $day_end);
        $this->db->where('post_status', 0);

        $query = $this->db->get("ic_management");

        if ($query->num_rows() > 0) {

            $data = $query->num_rows();
        } else {
            $data = 0;
        }
        return $data;
    } //function end
    

    /**
     * get_day_verified_count
     *
     * @param  mixed $day_start
     * @param  mixed $day_end
     * @return void
     */
    public function get_day_verified_count($day_start, $day_end)
    {
        $this->db->where('pr_publish_time >=', $day_start);
        $this->db->where('pr_publish_time <=', $day_end);
        $this->db->where('post_status', 1);

        $query = $this->db->get("ic_management");

        if ($query->num_rows() > 0) {

            $data = $query->num_rows();
        } else {
            $data = 0;
        }
        return $data;
    } //function end
    

    /**
     * get_day_frankly_count
     *
     * @param  mixed $day_start
     * @param  mixed $day_end
     * @return void
     */
    public function get_day_frankly_count($day_start, $day_end)
    {
        $this->db->where('pr_publish_time >=', $day_start);
        $this->db->where('pr_publish_time <=', $day_end);
        $this->db->where('frankly_links', 1);

        $query = $this->db->get("ic_management");

        if ($query->num_rows() > 0) {

            $data = $query->num_rows();
        } else {
            $data = 0;
        }
        return $data;
    } //function end
    

    /**
     * get_day_bignews_count
     *
     * @param  mixed $day_start
     * @param  mixed $day_end
     * @return void
     */
    public function get_day_bignews_count($day_start, $day_end)
    {
        $this->db->where('pr_publish_time >=', $day_start);
        $this->db->where('pr_publish_time <=', $day_end);
        $this->db->where('bignews_links', 1);

        $query = $this->db->get("ic_management");

        if ($query->num_rows() > 0) {

            $data = $query->num_rows();
        } else {
            $data = 0;
        }
        return $data;
    } //function end
    

    /**
     * mostly_used_coupons
     *
     * @return void
     */
    public function mostly_used_coupons()
    {
        $result = $this->db->query("SELECT transaction_id, COUNT(transaction_id) AS mostUsed FROM ic_management WHERE payment_type = 'Coupon' GROUP BY transaction_id ORDER BY mostUsed  DESC LIMIT 5;");

        if ($result->num_rows() > 0) {
            $data =  $result->result();
        } else {
            $data =  false;
        }

        return $data;
    } //function end
    

    /**
     * get_day_financial_count
     *
     * @param  mixed $day_start
     * @param  mixed $day_end
     * @return void
     */
    public function get_day_financial_count($day_start, $day_end)
    {
        $this->db->where('pr_publish_time >=', $day_start);
        $this->db->where('pr_publish_time <=', $day_end);
        $this->db->where('financial_links', 1);

        $query = $this->db->get("ic_management");

        if ($query->num_rows() > 0) {

            $data = $query->num_rows();
        } else {
            $data = 0;
        }
        return $data;
    } //function ends



}//class end