<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Rssfeed_model
 */
class Rssfeed_model extends CI_Model
{
    
    
    /**
     * get_rss_feed_links
     *
     * @return void
     */
    public function get_rss_feed_links()
    {
        $this->db->select("*");
        $query = $this->db->get("ic_manage_rss_link");

        if ($query->num_rows() > 0) {

            $data = $query->result();
        } else {
            $data = 0;
        }
        return $data;

    }//function ends
    
    
    /**
     * insert_rss_feed_link
     *
     * @param  mixed $insert_data
     * @return void
     */
    public function insert_rss_feed_link($insert_data,$feed_data)
    {
        if ($this->db->insert('ic_management', $insert_data)) {

            $this->db->insert('ic_management_channels', $feed_data);
            
            $response = [
                'status' => true,
                "data" => null,
                'message' => "Contact created successfully."
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
     * check_if_pr_exists
     *
     * @param  mixed $pr_id
     * @param  mixed $feed_name
     * @return void
     */
    public function isnew_pr_check($data)
    {
        $this->db->select("*");
        $this->db->where("pr_id", $data['pr_id']);
        $query = $this->db->get("ic_management");

        if ($query->num_rows() > 0) {
            
            $this->db->select("*");
            $this->db->where("pr_id", $data['pr_id']);
            $this->db->where("channel_name", $data['channel_name']);
            $query = $this->db->get("ic_management_channels");

            if ($query->num_rows() == 0) {

                $this->db->insert('ic_management_channels', $data);
                
                return true;

            }else{
                return true;
            }

        } else {
            return false;
        }

    } // function end
    
    

}//class end