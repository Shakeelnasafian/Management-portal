<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesModel extends Model
{
    protected $table = 'icn_posts';
    protected $primaryKey = 'ID';
    protected $returnType = 'object';
    protected $allowedFields = [
        'post_author',
        'post_date',
        'post_content',
        'post_title',
        'post_name',
        'post_status',
        'post_type',
        'guid',
    ];

    public function pressrelease_dashboard_pagination()
    {
        $result = $this->db->query("SELECT COUNT(ID) AS post_id FROM icn_posts WHERE post_type = 'post';");
        return $result->getRow();
    }

    public function get_icn_published_posts($limit = 10, $offset = 0)
    {
        $query = $this->db->table('icn_posts')
            ->select('icn_posts.*, icn_users.user_login, icn_users.user_email')
            ->join('icn_users', 'icn_users.ID = icn_posts.post_author', 'left')
            ->where('post_type', 'post')
            ->where('post_status !=', 'trash')
            ->orderBy('post_date', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function sale_post_filter_pagination($search_query)
    {
        $result = $this->db->query(
            "SELECT COUNT(ID) AS post_id FROM icn_posts WHERE post_type = 'post' AND $search_query;"
        );
        return $result->getRow();
    }

    public function get_sales_filters($limit = 20, $offset = 0, $search_query)
    {
        $query = $this->db->table('icn_posts')
            ->select('icn_posts.*, icn_users.user_login, icn_users.user_email')
            ->join('icn_users', 'icn_users.ID = icn_posts.post_author', 'left')
            ->where($search_query)
            ->where('post_type', 'post')
            ->orderBy('ID', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function load_icn_coupons($today, $limit = 20, $offset = 0)
    {
        $query = $this->db->table('kiosk_coupons')
            ->where('date_expire >=', $today)
            ->orderBy('coupon_id', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function active_coupon_pagination($today)
    {
        $result = $this->db->query(
            "SELECT COUNT(coupon_id) AS coupons FROM kiosk_coupons WHERE date_expire >= ?",
            [$today]
        );
        return $result->getRow();
    }

    public function get_coupon_filter($coupon_code)
    {
        $query = $this->db->table('kiosk_coupons')
            ->like('coupon_code', $coupon_code, 'after')
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_coupon_usage_details($coupon_id)
    {
        $query = $this->db->query(
            "SELECT
                SUM(IF(status = 1, 1, 0)) AS coupon_used,
                SUM(IF(status = 0, 1, 0)) AS coupon_applied
            FROM kiosk_coupon_used WHERE coupon_id = ?",
            [$coupon_id]
        );

        return $query->getNumRows() > 0 ? $query->getRow() : null;
    }

    public function expired_coupon_pagination($today)
    {
        $result = $this->db->query(
            "SELECT COUNT(coupon_id) AS coupons FROM kiosk_coupons WHERE date_expire < ?",
            [$today]
        );
        return $result->getRow();
    }

    public function load_icn_expired_coupons($today, $limit = 20, $offset = 0)
    {
        $query = $this->db->table('kiosk_coupons')
            ->where('date_expire <', $today)
            ->orderBy('coupon_id', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_users_all_credits($limit = 100, $offset = 0)
    {
        $query = $this->db->table('bulk_package')
            ->select('bulk_package.*, icn_users.user_login, icn_users.user_email')
            ->join('icn_users', 'icn_users.ID = bulk_package.user_id', 'left')
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_users_all_credits_pagination()
    {
        $result = $this->db->query(
            "SELECT COUNT(id) AS credits FROM bulk_package WHERE status = 1;"
        );
        return $result->getRow();
    }

    public function get_user_credits_filter($user_email)
    {
        $query = $this->db->table('icn_users')
            ->select('icn_users.user_login, icn_users.user_email, bulk_package.*')
            ->join('bulk_package', 'bulk_package.user_id = icn_users.ID', 'left')
            ->where('icn_users.user_email', $user_email)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }
}
