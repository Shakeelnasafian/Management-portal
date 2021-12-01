<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Operations_model
 */
class Operations_model extends CI_Model
{


    public function create_pressrelease($insert_data,$insert_meta)
    {
        if ($this->db->insert('icn_posts', $insert_data)) {
            $post_id = $this->db->insert_id();

            $this->update_guid($post_id);

            if ($post_id) {
                $this->add_post_meta($post_id,$insert_meta);
            }
    
            $response = [
                'post_id' => $post_id,
                'status' => true,
                "data" => null,
                'message' => "pressrelease created successfully."
            ];
        } else {
            $response = [
                'status' => false,
                "data" => null,
                'message' => "Some error occurred during pressrelease creation. Please try again."
            ];
        }
        return $response;
    }

    public function add_post_meta($post_id,$insert_meta)
    {
        foreach ($insert_meta as $key => $value) {
            $insert_data = array(
                'post_id' => $post_id,
                'meta_key' => $key,
                'meta_value' => $value
            );
            $this->db->insert('icn_postmeta', $insert_data);
        }
        return;
    }
    
    public function update_guid($post_id)
    {
        $this->db->set('guid',PARENT_SITE_URL.'?p='.$post_id);
        $this->db->where('ID',$post_id);
        $this->db->update('icn_posts');
        return;
    }

    /**
     * pending_dashboard_pagination
     *
     * @return void
     */
    public function pending_dashboard_pagination()
    {
        $result = $this->db->query("SELECT COUNT(ID) AS post_id FROM icn_posts WHERE post_type = 'post' AND post_status = 'pending';");
        return $result->row();
    } //function ends
    
    /**
     * published_dashboard_pagination
     *
     * @return void
     */
    public function published_dashboard_pagination()
    {
        $result = $this->db->query("SELECT COUNT(ID) AS post_id FROM icn_posts WHERE post_type = 'post' AND post_status = 'publish';");
        return $result->row();
    } //function ends
    
    /**
     * scheduled_dashboard_pagination
     *
     * @return void
     */
    public function scheduled_dashboard_pagination()
    {
        $result = $this->db->query("SELECT COUNT(ID) AS post_id FROM icn_posts WHERE post_type = 'post' AND post_status = 'future';");
        return $result->row();
    } //function ends
    
    /**
     * trashed_dashboard_pagination
     *
     * @return void
     */
    public function trashed_dashboard_pagination()
    {
        $result = $this->db->query("SELECT COUNT(ID) AS post_id FROM icn_posts WHERE post_type = 'post' AND post_status = 'trash';");
        return $result->row();
    } //function ends

    
    /**
     * draft_dashboard_pagination
     *
     * @return void
     */
    public function draft_dashboard_pagination()
    {
        $result = $this->db->query("SELECT COUNT(ID) AS post_id FROM icn_posts WHERE post_type = 'post' AND post_status = 'draft';");
        return $result->row();
    }//function ends


    /**
     * get_icn_published_posts
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_icn_pending_posts($limit = 10, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        $this->db->select("icn_posts.*, icn_users.user_login,icn_users.user_email");
        $this->db->from("icn_posts");
        $this->db->join('icn_users ', 'icn_users.ID = icn_posts.post_author', 'left');
        $this->db->where("post_status", "pending");
        $this->db->where("post_type", "post");
        $this->db->order_by('post_date', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;
    }

    /**
     * get_icn_schedule_posts
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_icn_schedule_posts($limit = 10, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        $this->db->select("icn_posts.*, icn_users.user_login,icn_users.user_email");
        $this->db->from("icn_posts");
        $this->db->join('icn_users ', 'icn_users.ID = icn_posts.post_author', 'left');
        $this->db->where("post_status", "future");
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
     * get_icn_trashed_posts
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_icn_trashed_posts($limit = 10, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        $this->db->select("icn_posts.*, icn_users.user_login,icn_users.user_email");
        $this->db->from("icn_posts");
        $this->db->join('icn_users ', 'icn_users.ID = icn_posts.post_author', 'left');
        $this->db->where("post_status", "trash");
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
     * get_icn_draft_posts
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function get_icn_draft_posts($limit, $offset)
    {
        $this->db->limit($limit, $offset);
        $this->db->select("icn_posts.*, icn_users.user_login,icn_users.user_email");
        $this->db->from("icn_posts");
        $this->db->join('icn_users ', 'icn_users.ID = icn_posts.post_author', 'left');
        $this->db->where("post_status", "draft");
        $this->db->where("post_type", "post");
        $this->db->order_by('post_date', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;

    }//function ends

    
    /**
     * get_pr_view_screen
     *
     * @param  mixed $post_id
     * @return void
     */
    public function get_pr_view_screen($post_id=123)
    {
        $this->db->select("icn_posts.*, icn_users.user_login,icn_users.user_email");
        $this->db->from("icn_posts");
        $this->db->join('icn_users ', 'icn_users.ID = icn_posts.post_author', 'left');
        $this->db->where("post_type", "post");
        $this->db->where("icn_posts.ID", $post_id);
        $this->db->order_by('post_date', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->row();
        } else {
            $data = null;
        }
        return $data;
    }//function ends

      
    /**
     * get_approve_pressrelease
     *
     * @param  mixed $post_id
     * @param  mixed $update_data
     * @return void
     */
    public function get_approve_pressrelease($post_id,$update_data)
    {
        $this->db->where('ID', $post_id);
        $this->db->update('icn_posts', $update_data);

        if ($this->db->affected_rows() > 0) {
            $response = [
                'status' => true,
                "data" => null,
                'message' => "PR Approved successfully"
            ];
        } else {

            $response = [
                'status' => false,
                "data" => null,
                'message' => "PR Approval Failed"
            ];
        }

        return $response;

    } //function ends
    

    /**
     * get_reject_pressrelease
     *
     * @param  mixed $post_id
     * @param  mixed $update_data
     * @return void
     */
    public function get_reject_pressrelease($post_id,$update_data)
    {
        $this->db->where('ID', $post_id);
        $this->db->update('icn_posts', $update_data);

        if ($this->db->affected_rows() > 0) {
            $response = [
                'status' => true,
                "data" => null,
                'message' => "PR Rejected successfully"
            ];
        } else {

            $response = [
                'status' => false,
                "data" => null,
                'message' => "PR Rejection Failed"
            ];
        }

        return $response;

    }//function ends

        
    /**
     * get_edit_pressrelease
     *
     * @param  mixed $post_id
     * @return void
     */
    public function get_edit_pressrelease($post_id)
    {
        $query = $this->db->query(
            "SELECT
            icn_posts.*,         
            max( CASE WHEN icn_postmeta.meta_key = 'cf_kiosk_id' THEN icn_postmeta.meta_value END ) cf_kiosk_id,
            max( CASE WHEN icn_postmeta.meta_key = 'cf_cont_info' THEN icn_postmeta.meta_value END ) cf_cont_info,
            max( CASE WHEN icn_postmeta.meta_key = 'cf_campaign_link' THEN icn_postmeta.meta_value  END ) cf_campaign_link,
            max( CASE WHEN icn_postmeta.meta_key = 'cf_payGo' THEN icn_postmeta.meta_value  END ) cf_payGo,
            max( CASE WHEN icn_postmeta.meta_key = 'cf_keywords' THEN icn_postmeta.meta_value  END ) cf_keywords              
             FROM
             icn_posts,
             icn_postmeta 
             WHERE
             icn_posts.ID = icn_postmeta.post_id 
                 AND '$post_id' = icn_posts.ID");
        
        if ($query->num_rows() > 0) {
            $result['post'] = $query->row();

                $query2 = $this->db->query("SELECT  GROUP_CONCAT(icn_term_relationships.term_taxonomy_id  separator ', ') icn_terms
                FROM icn_term_relationships WHERE object_id = '".$result['post']->ID."'");
                $result['categories'] = $query2->row();

        } else {
            $result = null;
        }
        return $result;


    }//function ends

    
    /**
     * edit_icn_pressrelease
     *
     * @param  mixed $post_update
     * @param  mixed $postmeta_update
     * @param  mixed $post_id
     * @return void
     */
    public function edit_icn_pressrelease($post_update, $postmeta_update,$post_id=123)
    {
        $this->db->where('ID', $post_id);
        $this->db->update('icn_posts', $post_update);
       
        
        foreach($postmeta_update as $key => $value){

            $update_data = array(
                'meta_value'=>$value
            );

            $this->db->where("post_id",$post_id);
            $this->db->where("meta_key",$key);
            $this->db->update('icn_postmeta', $update_data);
        }
            $response = [
                'status' => true,
                "data" => null,
                'message' => 1
            ];
 

        return $response;
    }//function ends

    
    /**
     * add_new_categories
     *
     * @param  mixed $insert_data
     * @return void
     */
    public function add_new_categories($insert_data)
    {
        $this->db->insert_batch('icn_term_relationships', $insert_data);

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

    }//function ends

    
    /**
     * delete_categories
     *
     * @param  mixed $categories
     * @param  mixed $post_id
     * @return void
     */
    public function delete_categories($categories,$post_id=123)
    {
        if($categories){

            foreach($categories as $cate){

                $this->db->where('object_id', $post_id);
                $this->db->where('term_taxonomy_id', $cate);
                $this->db->delete('icn_term_relationships'); 
           
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

        }
        
    }//function ends

    
    /**
     * get_operations_filters
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @param  mixed $search_query
     * @return void
     */
    public function get_operations_filters($limit = 20, $search_query)
    {
        $this->db->limit($limit);
        $this->db->where($search_query);
        $this->db->where("post_type", "post");
        $this->db->order_by('ID', 'desc');
        $query = $this->db->get("icn_posts");

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        //print_r($this->db->last_query());
        //die();
        return $data;

    }//function ends


    public function move_trash_pressrelease_pending($post_id, $update_data)
    {

        $this->db->where('ID', $post_id);
        $this->db->update('icn_posts', $update_data);

        if ($this->db->affected_rows() > 0) {
            $response = [
                'status' => true,
                "data" => null,
                'message' =>1
            ];
        } else {

            $response = [
                'status' => false,
                "data" => null,
                'message' => 0
            ];
        }

        return $response;

    }//function ends


    public function check_unique_slug_data($post_name)
    {
        $this->db->select("*");
        $this->db->where("post_name", $post_name);
        $query = $this->db->get("icn_posts");
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }

    }//function ends

    
    /**
     * get_wordpress_user
     *
     * @param  mixed $post_author
     * @return void
     */
    public function get_wordpress_user($post_author)
    {
        $this->db->select("user_login,user_nicename,user_email");
        $this->db->from("icn_users");
        $this->db->where("ID", $post_author);
       
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->row();
        } else {
            $data = null;
        }
        return $data;

    }//function ends

    
    /**
     * get_kiosk_user
     *
     * @param  mixed $post_id
     * @return void
     */
    public function get_kiosk_user($post_id)
    {
        $this->db->select("kiosk_subscriptions.user_id, kiosk_users.first_name,kiosk_users.last_name,kiosk_users.username,kiosk_users.email");
        $this->db->from("kiosk_subscriptions");
        $this->db->join('kiosk_users ', 'kiosk_subscriptions.user_id = kiosk_users.user_id', 'left');
        $this->db->where("kiosk_subscriptions.post_id", $post_id);
       
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->row();
        } else {
            $data = null;
        }
        return $data;

    }//function ends


}//class end