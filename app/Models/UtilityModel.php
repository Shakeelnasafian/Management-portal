<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilityModel extends Model
{
    protected $table = 'kiosks_list';
    protected $primaryKey = 'kiosk_id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'title',
        'name',
        'status',
    ];

    public function search_frankly_data($post_id)
    {
        $query = $this->db->table('frankly_postlink')
            ->where('post_id', $post_id)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function search_languages_sites_link($post_id)
    {
        $query = $this->db->table('post_translation_links')
            ->where('original_post_id', $post_id)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function create_new_marketplace($insert_data)
    {
        if ($this->db->table('internal_channels_post_links')->insert($insert_data)) {
            $rss_id = $this->db->insertID();
            return [
                'rss_id' => $rss_id,
                'status' => true,
                'data' => null,
                'message' => 'marketplace created successfully.',
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'message' => 'Some error occurred during marketplace addition. Please try again.',
        ];
    }

    public function check_marketplace_post_id($post_id, $rss_channel_id)
    {
        $query = $this->db->table('internal_channels_post_links')
            ->where('post_id', $post_id)
            ->where('rss_channel_id', $rss_channel_id)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function marketplace_posts_data($rss_channel_id, $limit = 10, $offset = 0)
    {
        $query = $this->db->table('internal_channels_post_links')
            ->where('rss_channel_id', $rss_channel_id)
            ->orderBy('rss_id', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function marketplace_pagination($channel_id)
    {
        $result = $this->db->query(
            "SELECT COUNT(rss_id) AS post_id FROM internal_channels_post_links WHERE rss_channel_id = ?;",
            [$channel_id]
        );
        return $result->getRow();
    }

    public function load_icn_coupons($limit = 200, $offset = 0)
    {
        $query = $this->db->table('kiosk_coupons')
            ->orderBy('coupon_id', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_post_title_for_reporting($post_id)
    {
        $query = $this->db->table('icn_posts')
            ->select('post_title')
            ->where('ID', $post_id)
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow() : null;
    }

    public function get_kiosk_names_coupon()
    {
        $query = $this->db->table('kiosks_list')
            ->select('kiosk_id, title')
            ->where('status', 1)
            ->orderBy('name', 'desc')
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_pressrelease_categories()
    {
        $query = $this->db->table('icn_term_taxonomy')
            ->select('icn_term_taxonomy.*, icn_terms.name, icn_terms.slug')
            ->join('icn_terms', 'icn_terms.term_id = icn_term_taxonomy.term_id', 'left')
            ->where('icn_term_taxonomy.taxonomy', 'category')
            ->orderBy('icn_term_taxonomy.term_taxonomy_id', 'desc')
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_subcription_package()
    {
        $query = $this->db->table('icn_posts')
            ->select('ID, post_title')
            ->where('post_type', 'wpuf_subscription')
            ->where('post_status', 'publish')
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_subcription_package_by_id($id)
    {
        $query = $this->db->table('icn_posts')
            ->select('ID, post_title')
            ->where('ID', $id)
            ->where('post_status', 'publish')
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow() : null;
    }
}
