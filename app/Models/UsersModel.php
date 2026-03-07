<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'ic_users';
    protected $primaryKey = 'ID';
    protected $returnType = 'object';
    protected $allowedFields = [
        'user_login',
        'user_email',
        'user_pass',
        'icn_role',
        'user_role',
        'cell_phone',
        'verify_code',
        'profile_image',
        'user_registered',
        'created_at',
    ];

    public function login($username)
    {
        $query = $this->db->table($this->table)
            ->groupStart()
            ->where('user_login', $username)
            ->orWhere('user_email', $username)
            ->groupEnd()
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow() : false;
    }

    public function check_user_login_ajax_data($user_login)
    {
        $query = $this->db->table($this->table)
            ->where('user_login', $user_login)
            ->get();

        return $query->getNumRows() > 0 ? 1 : 0;
    }

    public function check_user_email_ajax_data($user_email)
    {
        $query = $this->db->table($this->table)
            ->where('user_email', $user_email)
            ->get();

        return $query->getNumRows() > 0 ? 1 : 0;
    }

    public function create_new_user_data($insert_data)
    {
        if ($this->db->table($this->table)->insert($insert_data)) {
            return [
                'status' => true,
                'data' => null,
                'message' => 'User created successfully.',
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'message' => 'Some error occurred during User registration. Please try again.',
        ];
    }

    public function get_profile($ID)
    {
        $query = $this->db->table($this->table)
            ->where('ID', $ID)
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow() : false;
    }

    public function update_user_profile($update_data, $ID)
    {
        $this->db->table($this->table)
            ->where('ID', $ID)
            ->update($update_data);

        if ($this->db->affectedRows() > 0) {
            return [
                'status' => true,
                'data' => null,
                'message' => 'Profile Updated successfully',
            ];
        }

        return [
            'status' => true,
            'data' => null,
            'message' => 'Profile Updation Failed',
        ];
    }

    public function check_user_forgot_password($email)
    {
        $query = $this->db->table($this->table)
            ->select('ID, user_login, user_email')
            ->where('user_email', $email)
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow() : false;
    }

    public function save_user_verify_code($user_id, $verify_code)
    {
        $this->db->table($this->table)
            ->where('ID', $user_id)
            ->set('verify_code', $verify_code)
            ->update();
    }

    public function user_verification($ID)
    {
        $query = $this->db->table($this->table)
            ->select('ID, user_login, user_email, verify_code')
            ->where('ID', $ID)
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow() : false;
    }

    public function update_user_password($ID, $update_data)
    {
        $this->db->table($this->table)
            ->where('ID', $ID)
            ->update($update_data);

        if ($this->db->affectedRows() > 0) {
            return [
                'status' => true,
                'data' => null,
                'message' => 'Password Updated successfully',
            ];
        }

        return [
            'status' => true,
            'data' => null,
            'message' => 'Password Updation Failed',
        ];
    }
}
