<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Reporting_model
 */
class Reporting_model extends CI_Model
{

    /**
     * reporting_dashboard_pagination
     *
     * @return void
     */
    public function reporting_dashboard_pagination()
    {
        $result = $this->db->query("SELECT COUNT(ID) AS post_id FROM icn_posts WHERE post_type = 'post' AND post_status = 'publish';");
        return $result->row();
        // var_dump($number);
        // die();
    } //function ends

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
        $this->db->select("icn_posts.ID AS iCN_post_id, icn_posts.post_title, icn_posts.post_name, icn_posts.post_date, icn_mdr_report_data.post_id,icn_mdr_report_data.saved_by");
        $this->db->from("icn_posts");
        $this->db->join('icn_mdr_report_data ', 'icn_mdr_report_data.post_id = icn_posts.ID', 'left');
        $this->db->where("post_status", "publish");
        $this->db->where("post_type", "post");
        $this->db->order_by('post_date', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;
    } //function ends

    /**
     * save_final_report_data
     *
     * @param  mixed $create_array
     * @return void
     */
    public function save_final_report_data($create_array)
    {
        if ($this->db->insert('icn_mdr_report_data', $create_array)) {
            $response = [
                'status' => true,
                "data" => null,
                'message' => "Report created successfully"
            ];
        } else {
            $response = [
                'status' => true,
                "data" => null,
                'message' => "Some error occurred during consumer registration. Please try again."
            ];
        }
        return $response;
    } //function end

    /**
     * get_edit_report
     *
     * @param  mixed $post_id
     * @return void
     */
    public function get_edit_report($post_id)
    {
        $this->db->select("*");
        $this->db->where("post_id", $post_id);
        $query = $this->db->get("icn_mdr_report_data");

        if ($query->num_rows() > 0) {
            $data = $query->row();
        } else {
            $data = null;
        }
        return $data;
    } //fucntion ends

    /**
     * update_final_report_data
     *
     * @param  mixed $update_data
     * @param  mixed $post_id
     * @return void
     */
    public function update_final_report_data($update_data, $post_id)
    {
        $this->db->where('post_id', $post_id);

        $this->db->update('icn_mdr_report_data', $update_data);

        if ($this->db->affected_rows() > 0) {
            $response = [
                'status' => true,
                "data" => null,
                'message' => "Report Updated successfully"
            ];
        } else {

            $response = [
                'status' => true,
                "data" => null,
                'message' => "Report Updation Failed"
            ];
        }

        return $response;
    } //fucntion end

    /**
     * save_premium_website_data
     *
     * @param  mixed $insert_data
     * @return void
     */
    public function save_premium_website_data($insert_data)
    {

        $result = $this->db->insert_batch('icn_postmeta', $insert_data);
        return $result;
    } //function ends


    /**
     * check_premium_website_data
     *
     * @param  mixed $post_id
     * @return void
     */
    public function check_premium_website_data($post_id)
    {

        $this->db->select("meta_id,post_id,meta_key,meta_value");
        $this->db->from("icn_postmeta");
        $this->db->where_in('meta_key', array('_websites', '_impressions', '_clicks'));
        $this->db->where("post_id", $post_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $data = $query->result();
        } else {
            $data = 0;
        }
        return $data;
    } //function ends

    /**
     * update_premium_website_data
     *
     * @param  mixed $data_array
     * @param  mixed $post_id
     * @return void
     */
    public function update_premium_website_data($data_array, $post_id)
    {
        foreach ($data_array as $key => $value) {

            $update_data = array(
                'meta_value' => $value
            );
            $this->db->where("post_id", $post_id);
            $this->db->where("meta_key", $key);
            $this->db->update('icn_postmeta', $update_data);
        }
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    } //function ends

    /**
     * reporting_filters_by_id
     *
     * @param  mixed $post_id
     * @return void
     */
    public function reporting_filters_by_id($post_id)
    {
        $this->db->select("icn_posts.ID AS iCN_post_id, icn_posts.post_title, icn_posts.post_name, icn_posts.post_date, icn_mdr_report_data.post_id,icn_mdr_report_data.saved_by");
        $this->db->from("icn_posts");
        $this->db->join('icn_mdr_report_data ', 'icn_mdr_report_data.post_id = icn_posts.ID', 'left');
        $this->db->where("icn_posts.ID", $post_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $data = $query->result();
        } else {
            $data = 0;
        }
        return $data;
    } //function end

    /**
     * reporting_filters_by_date
     *
     * @param  mixed $day_start
     * @param  mixed $day_end
     * @return void
     */
    public function reporting_filters_by_date($day_start, $day_end)
    {
        $this->db->select("icn_posts.ID AS iCN_post_id, icn_posts.post_title, icn_posts.post_name, icn_posts.post_date, icn_mdr_report_data.post_id,icn_mdr_report_data.saved_by");
        $this->db->from("icn_posts");
        $this->db->join('icn_mdr_report_data ', 'icn_mdr_report_data.post_id = icn_posts.ID', 'left');
        $this->db->where('post_date >=', $day_start);
        $this->db->where('post_date <=', $day_end);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $data = $query->result();
        } else {
            $data = 0;
        }
        return $data;
    } //function end


    /**
     * get_report_data
     *
     * @param  mixed $post_id
     * @return void
     */
    public function get_report_data($post_id)
    {
        $this->db->select("kiosk_id,post_id,pack_id");
        $this->db->from("kiosk_subscriptions");
        $this->db->where("post_id", $post_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $data = $query->row();
        } else {
            $data = 0;
        }
        return $data;
    } //function ends


    /**
     * delete_report_data
     *
     * @param  mixed $post_id
     * @return void
     */
    public function delete_report_data($post_id)
    {
        $this->db->where("post_id", $post_id);

        $this->db->delete("icn_mdr_report_data");

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    } //function ends

    
    /**
     * save_report_pdf
     *
     * @return void
     */
    public function save_report_pdf($post_id, $insert_data)
    {
       
        $query = $this->db->get_where('icn_postmeta', array('post_id' => $post_id, 'meta_key' => 'Report_PDF_Link'));

        if ($query->num_rows() > 0) {

                $this->db->where("post_id", $post_id);
                $this->db->where("meta_key", 'Report_PDF_Link');
                $this->db->update('icn_postmeta', $insert_data);
           
        } else {

                $this->db->insert('icn_postmeta', $insert_data);
        }

        if ($this->db->affected_rows() > 0) {
            $response = [
                'status' => true,
                "data" => null,
                'message' => 1
            ];
        } else {

            $response = [
                'status' => false,
                "data" => null,
                'message' => 0
            ];
        }


        return $response;
   

    }//function end



}//class end