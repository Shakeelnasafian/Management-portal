<?php

namespace App\Models;

use CodeIgniter\Model;

class CouponModel extends Model
{
    protected $table = 'kiosk_coupons';
    protected $primaryKey = 'coupon_id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'coupon_code',
        'date_expire',
        'pack_id',
    ];

    public function load_icn_coupons($today, $limit = 200, $offset = 0)
    {
        $query = $this->db->table($this->table)
            ->where('date_expire >=', $today)
            ->orderBy('coupon_id', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function load_icn_expired_coupons($today, $limit = 200, $offset = 0)
    {
        $query = $this->db->table($this->table)
            ->where('date_expire <', $today)
            ->orderBy('coupon_id', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function view_coupon_data($coupon_id = 123)
    {
        $query1 = $this->db->query(
            "SELECT
                SUM(IF(status = 1, 1, 0)) AS coupon_used,
                SUM(IF(status = 0, 1, 0)) AS coupon_applied
            FROM kiosk_coupon_used WHERE coupon_id = ?",
            [$coupon_id]
        );

        $times_used = $query1->getNumRows() > 0 ? $query1->getRow() : null;

        $couponQuery = $this->db->table('kiosk_coupons c')
            ->select('c.*, cp.*')
            ->join('kiosk_coupons_packages cp', 'c.coupon_id = cp.coupon_id')
            ->where('c.coupon_id', $coupon_id)
            ->get();

        $coupon = $couponQuery->getRow();

        $historyQuery = $this->db->table('kiosk_coupon_history')
            ->where('coupon_id', $coupon_id)
            ->orderBy('coupon_id', 'asc')
            ->get();

        $coupon_history = $historyQuery->getNumRows() > 0 ? $historyQuery->getResult() : null;

        return [
            'coupon_usage' => $times_used,
            'coupon' => $coupon,
            'coupon_history' => $coupon_history,
        ];
    }

    public function edit_coupon_data($coupon_id = 123)
    {
        return $this->db->table($this->table)
            ->where('coupon_id', $coupon_id)
            ->get()
            ->getRow();
    }

    public function update_coupon_data($update_data, $coupon_id)
    {
        $this->db->table($this->table)
            ->where('coupon_id', $coupon_id)
            ->update($update_data);

        $response = $this->db->affectedRows();

        if ($response) {
            $pack_id = $update_data['pack_id'] ?? null;
            if ($pack_id !== null) {
                $second_data = ['pack_id' => $pack_id];
                $this->db->table('kiosk_coupons_packages')
                    ->where('coupon_id', $coupon_id)
                    ->update($second_data);
            }
        }

        if ($response > 0) {
            return [
                'status' => true,
                'data' => null,
                'message' => 'Coupon Updated successfully',
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'message' => 'Coupon Updation Failed',
        ];
    }

    public function create_new_coupon($insert_data, $pack_id)
    {
        if ($this->db->table($this->table)->insert($insert_data)) {
            $coupon_id = $this->db->insertID();

            $second_data = [
                'coupon_id' => $coupon_id,
                'pack_id' => $pack_id,
                'status' => 1,
            ];
            $this->db->table('kiosk_coupons_packages')->insert($second_data);

            return [
                'coupon_id' => $coupon_id,
                'status' => true,
                'data' => null,
                'message' => 'Coupon created successfully.',
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'message' => 'Some error occurred during Coupon registration. Please try again.',
        ];
    }

    public function check_coupon_code_data($coupon_code)
    {
        $query = $this->db->table($this->table)
            ->where('coupon_code', $coupon_code)
            ->get();

        return $query->getNumRows() > 0 ? 1 : 0;
    }

    public function expire_coupon_data($update_data, $coupon_id = 123)
    {
        $this->db->table($this->table)
            ->where('coupon_id', $coupon_id)
            ->update($update_data);

        if ($this->db->affectedRows() > 0) {
            return [
                'status' => true,
                'data' => null,
                'message' => 'Coupon Expired successfully',
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'message' => 'Coupon Expiring Failed',
        ];
    }

    public function get_coupon_filter($coupon_code)
    {
        $query = $this->db->table($this->table)
            ->like('coupon_code', $coupon_code, 'after')
            ->limit(100)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function update_coupon_history_data($update_data)
    {
        if ($this->db->table('kiosk_coupon_history')->insert($update_data)) {
            return [
                'status' => true,
                'data' => null,
                'message' => 'Coupon History updated successfully.',
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'message' => 'Some error occurred during Coupon History. Please try again.',
        ];
    }

    public function get_tans_details($post_id)
    {
        $query = $this->db->query(
            "SELECT k.subscription_id, k.cf_payGo, t.*
            FROM kiosk_subscriptions k
            INNER JOIN icn_wpuf_transaction t ON k.subscription_id = t.post_id
            WHERE k.post_id = ?",
            [$post_id]
        );

        return $query->getNumRows() > 0 ? $query->getRow() : null;
    }
}
