<?php

namespace App\Models;

use CodeIgniter\Model;

class ZohosyncModel extends Model
{
    protected $table = 'icn_users';
    protected $primaryKey = 'ID';
    protected $returnType = 'object';
    protected $allowedFields = [
        'user_login',
        'user_nicename',
        'user_email',
        'display_name',
        'user_registered',
    ];

    public function load_ic_users($today)
    {
        $query = $this->db->table('icn_users')
            ->select('icn_users.user_login, icn_users.user_email, icn_users.user_registered, icn_users.display_name')
            ->join('icn_usermeta', 'icn_usermeta.user_id = icn_users.ID', 'inner')
            ->where('icn_usermeta.meta_key', 'icn_capabilities')
            ->where('icn_users.user_registered >=', $today)
            ->like('icn_usermeta.meta_value', 'subscriber')
            ->orderBy('icn_users.ID', 'DESC')
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function load_icrowd_users($today)
    {
        return $this->load_ic_users($today);
    }

    public function load_kiosk_users($today)
    {
        $query = $this->db->table('kiosk_users')
            ->select('first_name, last_name, username, email, registration_date')
            ->where('registration_date >=', $today)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }
}
