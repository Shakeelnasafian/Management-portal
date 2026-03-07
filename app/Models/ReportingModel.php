<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportingModel extends Model
{
    protected $table = 'icn_mdr_report_data';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'post_id',
        'saved_by',
        'created_at',
        'updated_at',
    ];

    public function reporting_dashboard_pagination()
    {
        $result = $this->db->query(
            "SELECT COUNT(ID) AS post_id FROM icn_posts WHERE post_type = 'post' AND post_status = 'publish';"
        );
        return $result->getRow();
    }

    public function get_icn_published_posts($limit = 10, $offset = 0)
    {
        $query = $this->db->table('icn_posts')
            ->select('icn_posts.ID AS iCN_post_id, icn_posts.post_title, icn_posts.post_name, icn_posts.post_date, icn_mdr_report_data.post_id, icn_mdr_report_data.saved_by')
            ->join('icn_mdr_report_data', 'icn_mdr_report_data.post_id = icn_posts.ID', 'left')
            ->where('post_status', 'publish')
            ->where('post_type', 'post')
            ->orderBy('post_date', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function save_final_report_data($create_array)
    {
        if ($this->db->table($this->table)->insert($create_array)) {
            return [
                'status' => true,
                'data' => null,
                'message' => 'Report created successfully',
            ];
        }

        return [
            'status' => true,
            'data' => null,
            'message' => 'Some error occurred during consumer registration. Please try again.',
        ];
    }

    public function get_edit_report($post_id)
    {
        $query = $this->db->table($this->table)
            ->where('post_id', $post_id)
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow() : null;
    }

    public function update_final_report_data($update_data, $post_id)
    {
        $this->db->table($this->table)
            ->where('post_id', $post_id)
            ->update($update_data);

        if ($this->db->affectedRows() > 0) {
            return [
                'status' => true,
                'data' => null,
                'message' => 'Report Updated successfully',
            ];
        }

        return [
            'status' => true,
            'data' => null,
            'message' => 'Report Updation Failed',
        ];
    }

    public function save_premium_website_data($insert_data)
    {
        return $this->db->table('icn_postmeta')->insertBatch($insert_data);
    }

    public function check_premium_website_data($post_id)
    {
        $query = $this->db->table('icn_postmeta')
            ->select('meta_id, post_id, meta_key, meta_value')
            ->whereIn('meta_key', ['_websites', '_impressions', '_clicks'])
            ->where('post_id', $post_id)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : 0;
    }

    public function update_premium_website_data($data_array, $post_id)
    {
        foreach ($data_array as $key => $value) {
            $update_data = ['meta_value' => $value];
            $this->db->table('icn_postmeta')
                ->where('post_id', $post_id)
                ->where('meta_key', $key)
                ->update($update_data);
        }

        return $this->db->affectedRows() > 0;
    }

    public function reporting_filters_by_id($post_id)
    {
        $query = $this->db->table('icn_posts')
            ->select('icn_posts.ID AS iCN_post_id, icn_posts.post_title, icn_posts.post_name, icn_posts.post_date, icn_mdr_report_data.post_id, icn_mdr_report_data.saved_by')
            ->join('icn_mdr_report_data', 'icn_mdr_report_data.post_id = icn_posts.ID', 'left')
            ->where('icn_posts.ID', $post_id)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : 0;
    }

    public function reporting_filters_by_date($day_start, $day_end)
    {
        $query = $this->db->table('icn_posts')
            ->select('icn_posts.ID AS iCN_post_id, icn_posts.post_title, icn_posts.post_name, icn_posts.post_date, icn_mdr_report_data.post_id, icn_mdr_report_data.saved_by')
            ->join('icn_mdr_report_data', 'icn_mdr_report_data.post_id = icn_posts.ID', 'left')
            ->where('post_date >=', $day_start)
            ->where('post_date <=', $day_end)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : 0;
    }

    public function get_report_data($post_id)
    {
        $query = $this->db->table('kiosk_subscriptions')
            ->select('kiosk_id, post_id, pack_id')
            ->where('post_id', $post_id)
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow() : 0;
    }

    public function delete_report_data($post_id)
    {
        $this->db->table($this->table)
            ->where('post_id', $post_id)
            ->delete();

        return $this->db->affectedRows() > 0;
    }

    public function save_report_pdf($post_id, $insert_data)
    {
        $query = $this->db->table('icn_postmeta')
            ->where('post_id', $post_id)
            ->where('meta_key', 'Report_PDF_Link')
            ->get();

        if ($query->getNumRows() > 0) {
            $this->db->table('icn_postmeta')
                ->where('post_id', $post_id)
                ->where('meta_key', 'Report_PDF_Link')
                ->update($insert_data);
        } else {
            $this->db->table('icn_postmeta')->insert($insert_data);
        }

        if ($this->db->affectedRows() > 0) {
            return [
                'status' => true,
                'data' => null,
                'message' => 1,
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'message' => 0,
        ];
    }
}
