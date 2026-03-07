<?php

namespace App\Models;

use CodeIgniter\Model;

class PressreleaseModel extends Model
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

    public function none_verified_pagination()
    {
        $query = $this->db->table($this->table)
            ->where('post_status', 0)
            ->get();

        return $query->getNumRows();
    }

    public function verified_pagination()
    {
        $query = $this->db->table($this->table)
            ->where('post_status', 1)
            ->get();

        return $query->getNumRows();
    }

    public function get_all_verified_prs(int $limit = 20, int $offset = 0)
    {
        $sql = "SELECT m.*, (SELECT GROUP_CONCAT(channel_name SEPARATOR ', ') FROM ic_management_channels AS c WHERE c.pr_id = m.pr_id) AS channel
        FROM ic_management AS m WHERE m.post_status = 1 GROUP BY m.pr_id
        ORDER BY m.id DESC LIMIT ? OFFSET ?;";

        $query = $this->db->query($sql, [$limit, $offset]);

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_all_none_verified_prs(int $limit = 20, int $offset = 0)
    {
        $sql = "SELECT m.*, icn_posts.ID, (SELECT GROUP_CONCAT(channel_name SEPARATOR ', ') FROM ic_management_channels AS c WHERE c.pr_id = m.pr_id) AS channel
        FROM ic_management AS m LEFT JOIN icn_posts ON m.pr_id = icn_posts.ID
        WHERE m.post_status = 0 GROUP BY m.pr_id ORDER BY m.id DESC LIMIT ? OFFSET ?;";

        $query = $this->db->query($sql, [$limit, $offset]);

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function verify_pressrelease($update_data, $pr_id)
    {
        $this->db->table($this->table)
            ->where('pr_id', $pr_id)
            ->update($update_data);

        if ($this->db->affectedRows() > 0) {
            return [
                'status' => true,
                'data' => null,
                'message' => 'Pressrelease Verified successfully',
            ];
        }

        return [
            'status' => true,
            'data' => null,
            'message' => 'Pressrelease Verified Failed',
        ];
    }

    public function filter_pr_pagination($post_author)
    {
        $query = $this->db->table($this->table)
            ->where('post_author', $post_author)
            ->get();

        return $query->getNumRows();
    }

    public function get_filter_none_verified_prs($post_author, $pr_title)
    {
        $sql = "SELECT m.*, icn_posts.ID, (SELECT GROUP_CONCAT(channel_name SEPARATOR ', ') FROM ic_management_channels AS c WHERE c.pr_id = m.pr_id) AS channel
        FROM ic_management AS m LEFT JOIN icn_posts ON m.pr_id = icn_posts.ID
        WHERE m.post_status = 0 AND m.post_author = ? AND m.pr_title LIKE ? GROUP BY m.pr_id ORDER BY m.id DESC LIMIT 50;";

        $query = $this->db->query($sql, [$post_author, $pr_title]);

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_post_subsription_id($post_id = 121)
    {
        $kioskQuery = $this->db->table('kiosk_subscriptions')
            ->select('subscription_id, coupons_used')
            ->where('post_id', $post_id)
            ->get();

        if ($kioskQuery->getNumRows() > 0) {
            $kiosk_data = $kioskQuery->getRow();

            $couponUsedQuery = $this->db->table('kiosk_coupon_used')
                ->select('coupon_id')
                ->where('ID', $kiosk_data->coupons_used)
                ->get();

            if ($couponUsedQuery->getNumRows() > 0) {
                $coupon_used = $couponUsedQuery->getRow();

                $couponQuery = $this->db->table('kiosk_coupons')
                    ->select('coupon_code')
                    ->where('coupon_id', $coupon_used->coupon_id)
                    ->get();

                $coupon = $couponQuery->getNumRows() > 0 ? $couponQuery->getRow() : null;
            } else {
                $coupon_used = null;
                $coupon = null;
            }
        } else {
            $kiosk_data = null;
            $coupon_used = null;
            $coupon = null;
        }

        return [
            'status' => true,
            'kiosk_data' => $kiosk_data,
            'coupon_used' => $coupon_used,
            'coupon' => $coupon,
        ];
    }
}
