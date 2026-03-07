<?php

namespace App\Models;

use CodeIgniter\Model;

class ManagementModel extends Model
{
    protected $table = 'ic_management';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'pr_id',
        'pr_name',
        'pr_title',
        'post_status',
        'post_author',
        'pr_publish_time',
        'frankly_links',
        'bignews_links',
        'financial_links',
        'payment_type',
        'transaction_id',
    ];

    public function get_icn_management_dashboard_data($day_start, $day_end)
    {
        $query = $this->db->query(
            "SELECT COUNT(id) AS total_posts_today,
                Sum( CASE WHEN frankly_links = 1 THEN 1 ELSE 0 END ) AS total_frankly_posts,
                Sum( CASE WHEN bignews_links = 1 THEN 1 ELSE 0 END ) AS total_bignews_links,
                Sum( CASE WHEN financial_links = 1 THEN 1 ELSE 0 END ) AS total_financial_links,
                Sum( CASE WHEN post_status = 1 THEN 1 ELSE 0 END ) AS today_verified_posts,
                Sum( CASE WHEN post_status = 0 THEN 1 ELSE 0 END ) AS today_unveified_posts
            FROM ic_management;"
        );

        $response = $query->getRow();

        $query2 = $this->db->query(
            "SELECT
                Sum( CASE WHEN channel_name = 'frankly_links' THEN 1 ELSE 0 END ) AS total_frankly_posts,
                Sum( CASE WHEN channel_name = 'bignews_links' THEN 1 ELSE 0 END ) AS total_bignews_links,
                Sum( CASE WHEN channel_name = 'financial_links' THEN 1 ELSE 0 END ) AS total_financial_links,
                Sum( CASE WHEN channel_name = 'ips_links' THEN 1 ELSE 0 END ) AS total_ips_links
            FROM ic_management_channels;"
        );
        $channels = $query2->getRow();

        $result = $this->db->query(
            "SELECT DISTINCT kiosk_coupons.coupon_id, kiosk_coupons.coupon_code,
                (SELECT COUNT(*) FROM kiosk_coupon_used WHERE coupon_id = kiosk_coupons.coupon_id) AS couponUsed
            FROM kiosk_coupons
            WHERE kiosk_coupons.date_expire >= ?
            HAVING couponUsed > 15
            ORDER BY kiosk_coupons.coupon_id DESC",
            [$day_start]
        );
        $mostly_used_coupons = $result->getResult();

        return [
            'status' => true,
            'response_data' => $response,
            'channels_data' => $channels,
            'mostly_used_coupons' => $mostly_used_coupons,
            'message' => 'Dashboard stats.',
        ];
    }

    public function get_total_day_count($day_start, $day_end)
    {
        $query = $this->db->table($this->table)
            ->where('pr_publish_time >=', $day_start)
            ->where('pr_publish_time <=', $day_end)
            ->get();

        return $query->getNumRows() > 0 ? $query->getNumRows() : 0;
    }

    public function get_day_unverified_count($day_start, $day_end)
    {
        $query = $this->db->table($this->table)
            ->where('pr_publish_time >=', $day_start)
            ->where('pr_publish_time <=', $day_end)
            ->where('post_status', 0)
            ->get();

        return $query->getNumRows() > 0 ? $query->getNumRows() : 0;
    }

    public function get_day_verified_count($day_start, $day_end)
    {
        $query = $this->db->table($this->table)
            ->where('pr_publish_time >=', $day_start)
            ->where('pr_publish_time <=', $day_end)
            ->where('post_status', 1)
            ->get();

        return $query->getNumRows() > 0 ? $query->getNumRows() : 0;
    }

    public function get_day_frankly_count($day_start, $day_end)
    {
        $query = $this->db->table($this->table)
            ->where('pr_publish_time >=', $day_start)
            ->where('pr_publish_time <=', $day_end)
            ->where('frankly_links', 1)
            ->get();

        return $query->getNumRows() > 0 ? $query->getNumRows() : 0;
    }

    public function get_day_bignews_count($day_start, $day_end)
    {
        $query = $this->db->table($this->table)
            ->where('pr_publish_time >=', $day_start)
            ->where('pr_publish_time <=', $day_end)
            ->where('bignews_links', 1)
            ->get();

        return $query->getNumRows() > 0 ? $query->getNumRows() : 0;
    }

    public function mostly_used_coupons()
    {
        $result = $this->db->query(
            "SELECT transaction_id, COUNT(transaction_id) AS mostUsed
            FROM ic_management
            WHERE payment_type = 'Coupon'
            GROUP BY transaction_id
            ORDER BY mostUsed DESC
            LIMIT 5;"
        );

        return $result->getNumRows() > 0 ? $result->getResult() : false;
    }

    public function get_day_financial_count($day_start, $day_end)
    {
        $query = $this->db->table($this->table)
            ->where('pr_publish_time >=', $day_start)
            ->where('pr_publish_time <=', $day_end)
            ->where('financial_links', 1)
            ->get();

        return $query->getNumRows() > 0 ? $query->getNumRows() : 0;
    }
}
