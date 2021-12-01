<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Coupon_model
 */
class Coupon_model extends CI_Model
{

    /**
     * load_icn_coupons
     *
     * @param  mixed $today
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function load_icn_coupons($today, $limit = 200, $offset = 0)
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
     * load_icn_expired_coupons
     *
     * @param  mixed $today
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function load_icn_expired_coupons($today, $limit = 200, $offset = 0)
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
    } //function ends


    /**
     * view_coupon_data
     *
     * @param  mixed $coupon_id
     * @return void
     */
    public function view_coupon_data($coupon_id = 123)
    {
        $query1 = $this->db->query("SELECT
            SUM(IF(status = 1, 1, 0)) AS coupon_used,
            SUM(IF(status = 0, 1, 0)) AS coupon_applied
            FROM kiosk_coupon_used WHERE coupon_id = '" . $coupon_id . "'");

        if ($query1->num_rows() > 0) {
            $times_used = $query1->row();
        } else {
            $times_used = null;
        }

        $this->db->select("c.*, cp.*");
        $this->db->from("kiosk_coupons c");
        $this->db->join('kiosk_coupons_packages cp', 'c.coupon_id = cp.coupon_id');
        $this->db->where("c.coupon_id", $coupon_id);
        $query = $this->db->get();

        $coupon = $query->row();

        $this->db->where('coupon_id', $coupon_id);
        $this->db->order_by('coupon_id', 'asc');
        $query = $this->db->get("kiosk_coupon_history");

        if ($query->num_rows() > 0) {
            $coupon_history = $query->result();
        } else {
            $coupon_history = null;
        }

        $response = [
            "coupon_usage" => $times_used,
            "coupon" => $coupon,
            "coupon_history" => $coupon_history,
        ];
        return $response;
    } // function end


    /**
     * view_coupon_data
     *
     * @param  mixed $coupon_id
     * @return void
     */
    public function edit_coupon_data($coupon_id = 123)
    {
        $this->db->select("*");
        $this->db->where("coupon_id", $coupon_id);
        $query = $this->db->get("kiosk_coupons");

        $response = $query->row();

        return $response;
    } // function end

    /**
     * update_coupon_data
     *
     * @param  mixed $update_data
     * @param  mixed $coupon_id
     * @return void
     */
    public function update_coupon_data($update_data, $coupon_id)
    {
        $this->db->where('coupon_id', $coupon_id);
        $this->db->update('kiosk_coupons', $update_data);

        $response = $this->db->affected_rows();
       
        if ($response){

            $pack_id = $update_data['pack_id'];
            $second_data = [
                'pack_id' => $pack_id,
            ];
            $this->db->where('coupon_id', $coupon_id);
            $this->db->update('kiosk_coupons_packages', $second_data);
        }

        if ($response > 0) {
            $response = [
                'status' => true,
                "data" => null,
                'message' => "Coupon Updated successfully"
            ];
        } else {

            $response = [
                'status' => false,
                "data" => null,
                'message' => "Coupon Updation Failed"
            ];
        }

        return $response;
    } //function end


    /**
     * create_new_coupon
     *
     * @param  mixed $insert_data
     * @return void
     */
    public function create_new_coupon($insert_data, $pack_id)
    {
        if ($this->db->insert('kiosk_coupons', $insert_data)) {
            $coupon_id = $this->db->insert_id();

            $second_data = [
                'coupon_id' => $coupon_id,
                'pack_id' => $pack_id,
                'status' => 1,
            ];
            $this->db->insert('kiosk_coupons_packages', $second_data);

            $response = [
                'coupon_id' => $coupon_id,
                'status' => true,
                "data" => null,
                'message' => "Coupon created successfully."
            ];
        } else {
            $response = [
                'status' => false,
                "data" => null,
                'message' => "Some error occurred during Coupon registration. Please try again."
            ];
        }
        return $response;
    } //function end


    /**
     * check_coupon_code_data
     *
     * @param  mixed $coupon_code
     * @return void
     */
    public function check_coupon_code_data($coupon_code)
    {
        $this->db->select("*");
        $this->db->where("coupon_code", $coupon_code);
        $query = $this->db->get("kiosk_coupons");
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    } //function end


    /**
     * expire_coupon_data
     *
     * @param  mixed $update_data
     * @param  mixed $coupon_id
     * @return void
     */
    public function expire_coupon_data($update_data, $coupon_id = 123)
    {
        $this->db->where('coupon_id', $coupon_id);
        $this->db->update('kiosk_coupons', $update_data);

        if ($this->db->affected_rows() > 0) {
            $response = [
                'status' => true,
                "data" => null,
                'message' => "Coupon Expired successfully"
            ];
        } else {

            $response = [
                'status' => false,
                "data" => null,
                'message' => "Coupon Expiring Failed"
            ];
        }

        return $response;
    } //function ends


    /**
     * get_coupon_filter
     *
     * @param  mixed $coupon_code
     * @return void
     */
    public function get_coupon_filter($coupon_code)
    {
        $this->db->limit(100);
        $this->db->like('coupon_code', $coupon_code, 'after');
        $query = $this->db->get("kiosk_coupons");

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;
    } //function ends


    public function update_coupon_history_data($update_data)
    {
        if ($this->db->insert('kiosk_coupon_history', $update_data)) {

            $response = [
                'status' => true,
                "data" => null,
                'message' => "Coupon History updated successfully."
            ];
        } else {
            $response = [
                'status' => false,
                "data" => null,
                'message' => "Some error occurred during Coupon History. Please try again."
            ];
        }
        return $response;
    }

    public function get_tans_details($post_id)
    {
        $query = $this->db->query("SELECT k.subscription_id, k.cf_payGo, t.*
                            FROM kiosk_subscriptions k
                            INNER JOIN icn_wpuf_transaction t ON k.subscription_id = t.post_id
                            WHERE k.post_id = $post_id;");

        if ($query->num_rows() > 0) {
            $data = $query->row();;
        } else {
            $data = null;
        }
        return $data;
    }//function ends


}//class end