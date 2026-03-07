<?php

namespace App\Models;

use CodeIgniter\Model;

class KioskUsersModel extends Model
{
    protected $table = 'kiosk_users';
    protected $primaryKey = 'user_id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'user_owner',
        'first_name',
        'last_name',
        'username',
        'email',
        'registration_date',
        'cellphone',
        'corporateAddress',
        'city',
        'country',
    ];

    public function pressrelease_pagination()
    {
        $query = $this->db->query("SELECT icn_users.* FROM icn_users INNER JOIN icn_usermeta  ON icn_users.ID = icn_usermeta.user_id WHERE icn_usermeta.meta_key = 'icn_capabilities' AND icn_usermeta.meta_value LIKE '%subscriber%'
        ORDER BY icn_users.ID");

        return $query->getNumRows();
    }

    public function get_pressrelease_users($limit = 20, $offset = 0)
    {
        $query = $this->db->table('icn_users')
            ->select('icn_users.*')
            ->join('icn_usermeta', 'icn_usermeta.user_id = icn_users.ID', 'inner')
            ->where('icn_usermeta.meta_key', 'icn_capabilities')
            ->like('icn_usermeta.meta_value', 'subscriber')
            ->orderBy('icn_users.ID', 'DESC')
            ->limit($limit, $offset)
            ->get();

        if ($query->getNumRows() > 0) {
            $result['users'] = $query->getResult();
            $posts_id = array_map(static fn($user) => $user->ID, $result['users']);

            $query1 = $this->db->table('kiosk_subscriptions')
                ->select('subscription_id, user_id')
                ->whereIn('user_id', $posts_id)
                ->whereIn('kiosk_id', [19])
                ->get();

            $result['posts'] = $query1->getNumRows() > 0 ? $query1->getResult() : null;
        } else {
            $result = null;
        }

        return $result;
    }

    public function get_pressrelease_user_details($ID = 123)
    {
        $query = $this->db->query(
            "SELECT
                icn_users.ID,
                icn_users.display_name,
                icn_users.user_email,
                icn_users.user_login,
                icn_users.user_nicename,
                max( CASE WHEN icn_usermeta.meta_key = 'first_name' THEN icn_usermeta.meta_value END ) first_name,
                max( CASE WHEN icn_usermeta.meta_key = 'last_name' THEN icn_usermeta.meta_value END ) last_name,
                max( CASE WHEN icn_usermeta.meta_key = 'cell_phone' THEN icn_usermeta.meta_value  END ) cell_phone,
                max( CASE WHEN icn_usermeta.meta_key = 'state_region' THEN icn_usermeta.meta_value END ) state_region,
                max( CASE WHEN icn_usermeta.meta_key = 'corporate_address' THEN icn_usermeta.meta_value END ) corporate_address,
                max( CASE WHEN icn_usermeta.meta_key = 'city' THEN icn_usermeta.meta_value END ) city,
                max( CASE WHEN icn_usermeta.meta_key = 'country' THEN icn_usermeta.meta_value END ) country
            FROM icn_users, icn_usermeta
            WHERE icn_users.ID = icn_usermeta.user_id AND ? = icn_users.ID
            GROUP BY icn_usermeta.user_id",
            [$ID]
        );

        return $query->getNumRows() > 0 ? $query->getRow() : null;
    }

    public function legal_pagination()
    {
        $query = $this->db->table('kiosk_users')
            ->where('user_owner', 'Legal Newswire')
            ->get();

        return $query->getNumRows();
    }

    public function get_legal_users($limit = 20, $offset = 0)
    {
        $query = $this->db->table('kiosk_users')
            ->where('user_owner', 'Legal Newswire')
            ->orderBy('user_id', 'DESC')
            ->limit($limit, $offset)
            ->get();

        if ($query->getNumRows() > 0) {
            $result['users'] = $query->getResult();
            $posts_id = array_map(static fn($user) => $user->user_id, $result['users']);

            $query1 = $this->db->table('kiosk_subscriptions')
                ->select('subscription_id, user_id')
                ->whereIn('user_id', $posts_id)
                ->whereIn('kiosk_id', [47])
                ->get();

            $result['posts'] = $query1->getNumRows() > 0 ? $query1->getResult() : null;
        } else {
            $result['users'] = null;
        }

        return $result;
    }

    public function content_pagination()
    {
        $query = $this->db->table('kiosk_users')
            ->where('user_owner', 'Content Marketing')
            ->get();

        return $query->getNumRows();
    }

    public function get_content_users($limit, $offset)
    {
        $query = $this->db->table('kiosk_users')
            ->where('user_owner', 'Content Marketing')
            ->orderBy('user_id', 'DESC')
            ->limit($limit, $offset)
            ->get();

        if ($query->getNumRows() > 0) {
            $result['users'] = $query->getResult();
            $posts_id = array_map(static fn($user) => $user->user_id, $result['users']);

            $query1 = $this->db->table('kiosk_subscriptions')
                ->select('subscription_id, user_id')
                ->whereIn('user_id', $posts_id)
                ->whereIn('kiosk_id', [55])
                ->get();

            $result['posts'] = $query1->getNumRows() > 0 ? $query1->getResult() : null;
        } else {
            $result = null;
        }

        return $result;
    }

    public function realestate_pagination()
    {
        $query = $this->db->table('kiosk_users')
            ->where('user_owner', 'Wire.RealEstate')
            ->get();

        return $query->getNumRows();
    }

    public function get_realestate_users($limit, $offset)
    {
        $query = $this->db->table('kiosk_users')
            ->where('user_owner', 'Wire.RealEstate')
            ->orderBy('user_id', 'DESC')
            ->limit($limit, $offset)
            ->get();

        if ($query->getNumRows() > 0) {
            $result['users'] = $query->getResult();
            $posts_id = array_map(static fn($user) => $user->user_id, $result['users']);

            $query1 = $this->db->table('kiosk_subscriptions')
                ->select('subscription_id, user_id')
                ->whereIn('user_id', $posts_id)
                ->whereIn('kiosk_id', [56])
                ->get();

            $result['posts'] = $query1->getNumRows() > 0 ? $query1->getResult() : null;
        } else {
            $result = null;
        }

        return $result;
    }

    public function get_kiosk_user_details($user_id)
    {
        $query = $this->db->table('kiosk_users')
            ->where('user_id', $user_id)
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow() : null;
    }

    public function get_nexis_user($ID)
    {
        $query = $this->db->table('nexis_sales_form')
            ->where('ID', $ID)
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow() : null;
    }

    public function nexisnewsire_pagination()
    {
        $query = $this->db->table('nexis_sales_form')->get();
        return $query->getNumRows();
    }

    public function get_nexisnewsire_users($limit = 20, $offset = 0)
    {
        $query = $this->db->table('nexis_sales_form')
            ->orderBy('ID', 'DESC')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function add_user_credits($inser_data)
    {
        $this->db->table('bulk_package')->insert($inser_data);
    }

    public function register_new_user($inser_data, $meta_data)
    {
        $this->db->table('icn_users')->insert($inser_data);
        $responce_id = $this->db->insertID();
        if ($responce_id) {
            foreach ($meta_data as $key => $value) {
                $insert_data = [
                    'user_id' => $responce_id,
                    'meta_key' => $key,
                    'meta_value' => $value,
                ];
                $this->db->table('icn_usermeta')->insert($insert_data);
            }
        }

        return $responce_id;
    }

    public function mark_create_account_nexis($data, $user_id)
    {
        $this->db->table('nexis_sales_form')
            ->where('ID', $user_id)
            ->update($data);

        return $this->db->affectedRows() > 0;
    }

    public function check_user_email($user_email)
    {
        $query = $this->db->table('icn_users')
            ->where('user_email', $user_email)
            ->get();

        return $query->getNumRows() > 0 ? 1 : 0;
    }

    public function check_user_login($user_login)
    {
        $query = $this->db->table('icn_users')
            ->where('user_login', $user_login)
            ->get();

        return $query->getNumRows() > 0 ? 1 : 0;
    }

    public function find_icn_user($email)
    {
        $query = $this->db->table('icn_users')
            ->select('icn_users.ID, icn_users.user_login, icn_users.user_nicename, icn_users.user_email, bulk_package.total_credit, bulk_package.package_selected, bulk_package.current_credit')
            ->join('bulk_package', 'icn_users.ID = bulk_package.user_id', 'left')
            ->groupStart()
            ->where('icn_users.user_email', $email)
            ->orWhere('icn_users.user_login', $email)
            ->groupEnd()
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow() : null;
    }

    public function update_bulk_user_credits($user_id, $update_array)
    {
        $this->db->table('bulk_package')
            ->where('user_id', $user_id)
            ->update($update_array);

        return $this->db->affectedRows() > 0;
    }
}
