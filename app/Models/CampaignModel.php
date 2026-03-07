<?php

namespace App\Models;

use CodeIgniter\Model;

class CampaignModel extends Model
{
    protected $table = 'ic_campaign_tracking';
    protected $primaryKey = 'campaign_id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'post_id',
        'post_title',
        'post_name',
        'pr_package',
        'start_date',
        'end_date',
        'department',
        'campaign_status',
        'client_name',
        'product_name',
        'pr_mockup_link',
    ];

    public function get_campaign_dashboard($limit = 15, $offset = 0)
    {
        $query = $this->db->table($this->table)
            ->select('*')
            ->orderBy('campaign_id', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_pressrelease_details_db($post_id = 123)
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
                AND ? = icn_posts.ID
            GROUP BY
                icn_postmeta.post_id",
            [$post_id]
        );

        return $query->getNumRows() > 0 ? $query->getRow() : null;
    }

    public function create_new_campaign($insert_data = [])
    {
        if ($this->db->table($this->table)->insert($insert_data)) {
            $coupon_id = $this->db->insertID();

            return [
                'coupon_id' => $coupon_id,
                'status' => true,
                'data' => null,
                'message' => 'Campaign created successfully.',
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'message' => 'Some error occurred during Campaign registration. Please try again.',
        ];
    }

    public function get_socialmedia_dashboard($limit = 15, $offset = 0)
    {
        $query = $this->db->table($this->table)
            ->select('*')
            ->where('department', 'social-media')
            ->orderBy('campaign_id', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_graphics_dashboard($limit = 15, $offset = 0)
    {
        $query = $this->db->table($this->table)
            ->select('*')
            ->where('department', 'graphics-design')
            ->orderBy('campaign_id', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_operations_dashboard($limit = 15, $offset = 0)
    {
        $query = $this->db->table($this->table)
            ->select('*')
            ->where('department', 'operations')
            ->orderBy('campaign_id', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_active_dashboard($limit = 15, $offset = 0)
    {
        $query = $this->db->table($this->table)
            ->select('*')
            ->where('campaign_status !=', 'completed')
            ->orderBy('campaign_id', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_completed_dashboard($limit = 15, $offset = 0)
    {
        $query = $this->db->table($this->table)
            ->select('*')
            ->where('campaign_status', 'completed')
            ->orderBy('campaign_id', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_campaign_details($post_id = 123)
    {
        $query = $this->db->table($this->table)
            ->select('*')
            ->where('post_id', $post_id)
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow() : null;
    }

    public function save_pr_mockups($campaign_id, $update_data)
    {
        $this->db->table($this->table)
            ->where('campaign_id', $campaign_id)
            ->update($update_data);

        if ($this->db->affectedRows() > 0) {
            return [
                'status' => true,
                'data' => null,
                'message' => 'Mockups Added successfully',
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'message' => 'Mockups Additions Failed',
        ];
    }

    public function check_existing_campaign_ajax($post_id = 12312)
    {
        $query = $this->db->table($this->table)
            ->select('*')
            ->where('post_id', $post_id)
            ->get();

        return $query->getNumRows() > 0 ? 1 : 0;
    }

    public function update_campaign_status_ajax($update_data, $campaign_id = 1231)
    {
        $this->db->table($this->table)
            ->where('campaign_id', $campaign_id)
            ->update($update_data);

        if ($this->db->affectedRows() > 0) {
            return [
                'status' => true,
                'data' => null,
                'message' => 'Status Updated successfully',
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'message' => 'Status Updated Failed',
        ];
    }
}
