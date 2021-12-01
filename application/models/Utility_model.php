<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Utility_model extends CI_Model
{

    /**
     * search_frankly_data
     *
     * @param  mixed $post_id
     * @return void
     */
    public function search_frankly_data($post_id)
    {
        $this->db->select("*");
        $this->db->where("post_id", $post_id);
        $query = $this->db->get("frankly_postlink");

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;
    } // fucntion ends


    /**
     * search_languages_sites_link
     *
     * @param  mixed $post_id
     * @return void
     */
    public function search_languages_sites_link($post_id)
    {
        $this->db->select("*");
        $this->db->where("original_post_id", $post_id);
        $query = $this->db->get("post_translation_links");

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;
    } //function ends

    /**
     * create_new_marketplace
     *
     * @param  mixed $insert_data
     * @return void
     */
    public function create_new_marketplace($insert_data)
    {

        if ($this->db->insert('internal_channels_post_links', $insert_data)) {
            $rss_id = $this->db->insert_id();
            $response = [
                'rss_id' => $rss_id,
                'status' => true,
                "data" => null,
                'message' => "marketplace created successfully."
            ];
        } else {
            $response = [
                'status' => false,
                "data" => null,
                'message' => "Some error occurred during marketplace addition. Please try again."
            ];
        }
        return $response;
    } //function end

    /**
     * check_marketplace_post_id
     *
     * @param  int $post_id
     * @return void
     */
    public function check_marketplace_post_id($post_id, $rss_channel_id)
    {
        $this->db->select("*");
        $this->db->where("post_id", $post_id);
        $this->db->where("rss_channel_id", $rss_channel_id);
        $query = $this->db->get("internal_channels_post_links");
        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;
    } //function end   

    /**
     * marketplace_posts_data
     *
     * @param int $limit,$offset
     * @return void
     */
    public function marketplace_posts_data($rss_channel_id, $limit = 10, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        $this->db->where("rss_channel_id", $rss_channel_id);
        $this->db->order_by('rss_id', 'desc');
        $query = $this->db->get("internal_channels_post_links");

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;
    } //function end   

    /**
     * marketplace_pagination
     *
     * @return void
     */
    public function marketplace_pagination($channel_id)
    {
        $result = $this->db->query("SELECT COUNT(rss_id) AS post_id FROM internal_channels_post_links WHERE rss_channel_id=$channel_id;");
        return $result->row();
    } //function ends


    /**
     * load_icn_coupons
     *
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public function load_icn_coupons($limit = 200, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        $this->db->order_by('coupon_id', 'desc');
        $query = $this->db->get("kiosk_coupons");

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;
    } // fucntion end

    /**
     * get_post_title_for_reporting
     * 
     * this function is used for loading post title on reporting screen
     *
     * @param  mixed $post_id
     * @return void
     */
    public function get_post_title_for_reporting($post_id)
    {
        $this->db->select("post_title");
        $this->db->where("ID", $post_id);
        $query = $this->db->get("icn_posts");

        if ($query->num_rows() > 0) {
            $data = $query->row();
        } else {
            $data = null;
        }
        return $data;
    } // fucntion ends

    /**
     * get_kiosk_names_coupon
     *
     * this function load kiosk names to the coupon view screen
     * 
     * @return void
     */
    public function get_kiosk_names_coupon()
    {
        $this->db->select("kiosk_id,title");
        $this->db->order_by('name', 'desc');
        $this->db->where("status", 1);
        $query = $this->db->get("kiosks_list");

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;
    } //function ends


    /**
     * get_categories_pressrelease
     *
     * @return void
     */
    public function get_pressrelease_categories()
    {
        $this->db->select("icn_term_taxonomy.*, icn_terms.name,icn_terms.slug");
        $this->db->from("icn_term_taxonomy");
        $this->db->join('icn_terms ', 'icn_terms.term_id = icn_term_taxonomy.term_id', 'left');
        $this->db->where("icn_term_taxonomy.taxonomy", "category");
        $this->db->order_by('icn_term_taxonomy.term_taxonomy_id', 'desc');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;
    } //function ends

    public function get_subcription_package()
    {
        $this->db->select("ID,post_title");
        $this->db->where("post_type", "wpuf_subscription");
        $this->db->where("post_status", "publish");
        $query = $this->db->get("icn_posts");
        if ($query->num_rows() > 0) {
            $data = $query->result();
        } else {
            $data = null;
        }
        return $data;
    } //function ends

    public function get_subcription_package_by_id($id)
    {
        $this->db->select("ID,post_title");
        $this->db->where("ID", $id);
        $this->db->where("post_status", "publish");
        $query = $this->db->get("icn_posts");

        if ($query->num_rows() > 0) {
            $data = $query->row();
        } else {
            $data = null;
        }
        return $data;
    } //function ends




}//fucntion end