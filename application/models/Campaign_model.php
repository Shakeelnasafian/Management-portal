<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Campaign_model
 */
class Campaign_model extends CI_Model
{

    
       
    /**
     * get_campaign_dashboard
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_campaign_dashboard($limit=15, $offset=0)
    {
        $this->db->limit($limit, $offset);
        $this->db->select("*");
        $this->db->from("icrowd_campaign_tracking");
        $this->db->order_by('campaign_id', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;

    }//function ends

      
    /**
     * get_pressrelease_details_db
     *
     * @param  mixed $post_id
     * @return void
     */
    public function get_pressrelease_details_db($post_id =123)
    {
        $query = $this->db->query(
                "SELECT
                    icn_posts.ID,
                    icn_posts.post_title,
                    icn_posts.post_name,
                    icn_posts.post_date,
                    max( CASE WHEN icn_postmeta.meta_key = 'cf_payGo' THEN icn_postmeta.meta_value END ) pr_package,
                    max( CASE WHEN icn_postmeta.meta_key = 'cf_kiosk_id' THEN icn_postmeta.meta_value END ) kiosk_id            
                    FROM
                        icn_posts,
                        icn_postmeta 
                    WHERE
                        icn_posts.ID = icn_postmeta.post_id 
                        AND '$post_id' = icn_posts.ID 
                    GROUP BY
                    icn_postmeta.post_id"
                );
       
        if ($query->num_rows() > 0) {
            $result = $query->row();
        } else {
            $result = null;
        }
        return $result;

    }//function ends

        
        
    /**
     * create_new_campaign
     *
     * @param  mixed $insert_data
     * @return void
     */
    public function create_new_campaign($insert_data=1231)
    {
        if ($this->db->insert('icrowd_campaign_tracking', $insert_data)) {
            $coupon_id = $this->db->insert_id();

            $response = [
                'coupon_id' => $coupon_id,
                'status' => true,
                "data" => null,
                'message' => "Campaign created successfully."
            ];
        } else {
            $response = [
                'status' => false,
                "data" => null,
                'message' => "Some error occurred during Campaign registration. Please try again."
            ];
        }
        return $response;
    }//function ends
    
    
       
    /**
     * get_socialmedia_dashboard
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_socialmedia_dashboard($limit=15, $offset=0)
    {

        $this->db->limit($limit, $offset);
        $this->db->select("*");
        $this->db->from("icrowd_campaign_tracking");
        $this->db->where("department","social-media");
        $this->db->order_by('campaign_id', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;

    }//function ends

     
    /**
     * get_graphics_dashboard
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_graphics_dashboard($limit=15, $offset=0)
    {

        $this->db->limit($limit, $offset);
        $this->db->select("*");
        $this->db->from("icrowd_campaign_tracking");
        $this->db->where("department","graphics-design");
        $this->db->order_by('campaign_id', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;

    }//function ends

    
      
    /**
     * get_operations_dashboard
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_operations_dashboard($limit=15, $offset=0)
    {

        $this->db->limit($limit, $offset);
        $this->db->select("*");
        $this->db->from("icrowd_campaign_tracking");
        $this->db->where("department","operations");
        $this->db->order_by('campaign_id', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;

    }//function ends

    
    /**
     * get_active_dashboard
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_active_dashboard($limit=15, $offset=0)
    {

        $this->db->limit($limit, $offset);
        $this->db->select("*");
        $this->db->from("icrowd_campaign_tracking");
        $this->db->where("campaign_status !=","completed");
        $this->db->order_by('campaign_id', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;

    }//function ends

        
    /**
     * get_completed_dashboard
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_completed_dashboard($limit=15, $offset=0)
    {

        $this->db->limit($limit, $offset);
        $this->db->select("*");
        $this->db->from("icrowd_campaign_tracking");
        $this->db->where("campaign_status","completed");
        $this->db->order_by('campaign_id', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;

    }//function ends
    
    /**
     * get_campaign_details
     *
     * @param  mixed $post_id
     * @return void
     */
    public function get_campaign_details($post_id=123)
    {
        $this->db->select("*");
        $this->db->from("icrowd_campaign_tracking");
        $this->db->where('post_id', $post_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->row();
        } else {
            $data = null;
        }
        return $data;


    }//function ends

    
    /**
     * save_pr_mockups
     *
     * @param  mixed $campaign_id
     * @param  mixed $update_data
     * @return void
     */
    public function save_pr_mockups($campaign_id,$update_data)
    {
        
        $this->db->where('campaign_id', $campaign_id);
        $this->db->update('icrowd_campaign_tracking', $update_data);

        if ($this->db->affected_rows() > 0) {
            $response = [
                'status' => true,
                "data" => null,
                'message' => "Mockups Added successfully"
            ];
        } else {

            $response = [
                'status' => false,
                "data" => null,
                'message' => "Mockups Additions Failed"
            ];
        }

        return $response;

    }//function ends

        
    /**
     * check_existing_campaign_ajax
     *
     * @param  mixed $post_id
     * @return void
     */
    public function check_existing_campaign_ajax($post_id =12312)
    {
        $this->db->select("*");
        $this->db->where("post_id", $post_id);
        $query = $this->db->get("icrowd_campaign_tracking");
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }//function ends

    
    /**
     * update_campaign_status_ajax
     *
     * @param  mixed $update_data
     * @param  mixed $campaign_id
     * @return void
     */
    public function update_campaign_status_ajax($update_data,$campaign_id=1231)
    {
        $this->db->where('campaign_id', $campaign_id);
        $this->db->update('icrowd_campaign_tracking', $update_data);

        if ($this->db->affected_rows() > 0) {
            $response = [
                'status' => true,
                "data" => null,
                'message' => "Status Updated successfully"
            ];
        } else {

            $response = [
                'status' => false,
                "data" => null,
                'message' => "Status Updated Failed"
            ];
        }

        return $response;

    }//function ends

}//class ends