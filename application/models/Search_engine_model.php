<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search_engine_model extends CI_Model
{

    /**
     * search_pressrelease_archive_post
     *
     * @param  mixed $post_name
     * @return void
     */
    public function search_archive_post($post_name)
    {
        $this->db->select("ID,post_title,post_name");
        $this->db->where("post_name", $post_name);
        $query = $this->db->get("icn_posts_archive");

        if ($query->num_rows() > 0) {
            $data = $query->row();
        } else {
            $data = null;
        }

        return $data;
    } //function end

    /**
     * edit_archive_post
     *
     * @param  mixed $ID
     * @return void
     */
    public function edit_archive_post($ID = 123)
    {
        $query = $this->db->query(
            "SELECT
            icn_posts_archive.*,         
            max( CASE WHEN icn_postmeta_archive.meta_key = 'seo_meta_title' THEN icn_postmeta_archive.meta_value END ) meta_title,
            max( CASE WHEN icn_postmeta_archive.meta_key = 'seo_meta_description' THEN icn_postmeta_archive.meta_value END ) meta_description          
             FROM
             icn_posts_archive,
             icn_postmeta_archive 
             WHERE
             icn_posts_archive.ID = icn_postmeta_archive.post_id 
                 AND '$ID' = icn_posts_archive.ID");

        if ($query->num_rows() > 0) {
            $data = $query->row();
        } else {
            $data = null;
        }

        return $data;
    } //function ends


    /**
     * update_pressrelease_archive_data
     *
     * @param  mixed $update_data
     * @param  mixed $ID
     * @return void
     */
    public function update_pressrelease_archive_data($update_data, $ID, $meta_data)
    {
        $this->db->where('ID', $ID);
        $this->db->update('icn_posts_archive', $update_data);

        $query = $this->db->get_where('icn_postmeta_archive', array('post_id' => $ID, 'meta_key' => 'seo_meta_title'));

        if ($query->num_rows() > 0) {

            foreach ($meta_data as $key => $value) {

                $update_data = array(
                    'meta_value' => $value
                );
                $this->db->where("post_id", $ID);
                $this->db->where("meta_key", $key);
                $this->db->update('icn_postmeta_archive', $update_data);
            }
        } else {

            foreach ($meta_data as $key => $value) {

                $insert_data = array(
                    'post_id' => $ID,
                    'meta_key' => $key,
                    'meta_value' => $value
                );

                $this->db->insert('icn_postmeta_archive', $insert_data);
            }
        }

        if ($this->db->affected_rows() > 0) {
            $response = [
                'status' => true,
                "data" => null,
                'message' => "Pressrelease Updated successfully"
            ];
        } else {

            $response = [
                'status' => false,
                "data" => null,
                'message' => "Pressrelease Updation Failed"
            ];
        }



        return $response;
    } //fucntion end

    public function delete_archive_post($ID)
    {

        $this->db->where('ID',$ID);
        $this->db->delete('icn_posts_archive');

        if ($this->db->affected_rows() > 0) {
            $response = [
                'status' => true,
                "data" => null,
                'message' => "Pressrelease Deleted successfully"
            ];
        } else {

            $response = [
                'status' => false,
                "data" => null,
                'message' => "Pressrelease Deletion Failed"
            ];
        }

        return $response;


    }//function ends



}//class ends