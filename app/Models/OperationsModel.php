<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationsModel extends Model
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

    public function create_pressrelease($insert_data, $insert_meta)
    {
        if ($this->db->table($this->table)->insert($insert_data)) {
            $post_id = $this->db->insertID();

            $this->update_guid($post_id);

            if ($post_id) {
                $this->add_post_meta($post_id, $insert_meta);
            }

            return [
                'post_id' => $post_id,
                'status' => true,
                'data' => null,
                'message' => 'pressrelease created successfully.',
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'message' => 'Some error occurred during pressrelease creation. Please try again.',
        ];
    }

    public function add_post_meta($post_id, $insert_meta)
    {
        foreach ($insert_meta as $key => $value) {
            $insert_data = [
                'post_id' => $post_id,
                'meta_key' => $key,
                'meta_value' => $value,
            ];
            $this->db->table('icn_postmeta')->insert($insert_data);
        }
    }

    public function update_guid($post_id)
    {
        $this->db->table($this->table)
            ->set('guid', PARENT_SITE_URL . '?p=' . $post_id)
            ->where('ID', $post_id)
            ->update();
    }

    public function pending_dashboard_pagination()
    {
        $result = $this->db->query(
            "SELECT COUNT(ID) AS post_id FROM icn_posts WHERE post_type = 'post' AND post_status = 'pending';"
        );
        return $result->getRow();
    }

    public function published_dashboard_pagination()
    {
        $result = $this->db->query(
            "SELECT COUNT(ID) AS post_id FROM icn_posts WHERE post_type = 'post' AND post_status = 'publish';"
        );
        return $result->getRow();
    }

    public function scheduled_dashboard_pagination()
    {
        $result = $this->db->query(
            "SELECT COUNT(ID) AS post_id FROM icn_posts WHERE post_type = 'post' AND post_status = 'future';"
        );
        return $result->getRow();
    }

    public function trashed_dashboard_pagination()
    {
        $result = $this->db->query(
            "SELECT COUNT(ID) AS post_id FROM icn_posts WHERE post_type = 'post' AND post_status = 'trash';"
        );
        return $result->getRow();
    }

    public function draft_dashboard_pagination()
    {
        $result = $this->db->query(
            "SELECT COUNT(ID) AS post_id FROM icn_posts WHERE post_type = 'post' AND post_status = 'draft';"
        );
        return $result->getRow();
    }

    public function get_icn_pending_posts($limit = 10, $offset = 0)
    {
        $query = $this->db->table('icn_posts')
            ->select('icn_posts.*, icn_users.user_login, icn_users.user_email')
            ->join('icn_users', 'icn_users.ID = icn_posts.post_author', 'left')
            ->where('post_status', 'pending')
            ->where('post_type', 'post')
            ->orderBy('post_date', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_icn_schedule_posts($limit = 10, $offset = 0)
    {
        $query = $this->db->table('icn_posts')
            ->select('icn_posts.*, icn_users.user_login, icn_users.user_email')
            ->join('icn_users', 'icn_users.ID = icn_posts.post_author', 'left')
            ->where('post_status', 'future')
            ->where('post_type', 'post')
            ->orderBy('post_date', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_icn_published_posts($limit = 10, $offset = 0)
    {
        $query = $this->db->table('icn_posts')
            ->select('icn_posts.*, icn_users.user_login, icn_users.user_email')
            ->join('icn_users', 'icn_users.ID = icn_posts.post_author', 'left')
            ->where('post_status', 'publish')
            ->where('post_type', 'post')
            ->orderBy('post_date', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_icn_trashed_posts($limit = 10, $offset = 0)
    {
        $query = $this->db->table('icn_posts')
            ->select('icn_posts.*, icn_users.user_login, icn_users.user_email')
            ->join('icn_users', 'icn_users.ID = icn_posts.post_author', 'left')
            ->where('post_status', 'trash')
            ->where('post_type', 'post')
            ->orderBy('post_date', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_icn_draft_posts($limit, $offset)
    {
        $query = $this->db->table('icn_posts')
            ->select('icn_posts.*, icn_users.user_login, icn_users.user_email')
            ->join('icn_users', 'icn_users.ID = icn_posts.post_author', 'left')
            ->where('post_status', 'draft')
            ->where('post_type', 'post')
            ->orderBy('post_date', 'desc')
            ->limit($limit, $offset)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_pr_view_screen($post_id = 123)
    {
        $query = $this->db->table('icn_posts')
            ->select('icn_posts.*, icn_users.user_login, icn_users.user_email')
            ->join('icn_users', 'icn_users.ID = icn_posts.post_author', 'left')
            ->where('post_type', 'post')
            ->where('icn_posts.ID', $post_id)
            ->orderBy('post_date', 'desc')
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow() : null;
    }

    public function get_approve_pressrelease($post_id, $update_data)
    {
        $this->db->table($this->table)
            ->where('ID', $post_id)
            ->update($update_data);

        if ($this->db->affectedRows() > 0) {
            return [
                'status' => true,
                'data' => null,
                'message' => 'PR Approved successfully',
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'message' => 'PR Approval Failed',
        ];
    }

    public function get_reject_pressrelease($post_id, $update_data)
    {
        $this->db->table($this->table)
            ->where('ID', $post_id)
            ->update($update_data);

        if ($this->db->affectedRows() > 0) {
            return [
                'status' => true,
                'data' => null,
                'message' => 'PR Rejected successfully',
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'message' => 'PR Rejection Failed',
        ];
    }

    public function get_edit_pressrelease($post_id)
    {
        $query = $this->db->query(
            "SELECT
                icn_posts.*,
                max( CASE WHEN icn_postmeta.meta_key = 'cf_kiosk_id' THEN icn_postmeta.meta_value END ) cf_kiosk_id,
                max( CASE WHEN icn_postmeta.meta_key = 'cf_cont_info' THEN icn_postmeta.meta_value END ) cf_cont_info,
                max( CASE WHEN icn_postmeta.meta_key = 'cf_campaign_link' THEN icn_postmeta.meta_value  END ) cf_campaign_link,
                max( CASE WHEN icn_postmeta.meta_key = 'cf_payGo' THEN icn_postmeta.meta_value  END ) cf_payGo,
                max( CASE WHEN icn_postmeta.meta_key = 'cf_keywords' THEN icn_postmeta.meta_value  END ) cf_keywords
            FROM icn_posts, icn_postmeta
            WHERE icn_posts.ID = icn_postmeta.post_id
                AND ? = icn_posts.ID",
            [$post_id]
        );

        if ($query->getNumRows() > 0) {
            $result['post'] = $query->getRow();

            $query2 = $this->db->query(
                "SELECT GROUP_CONCAT(icn_term_relationships.term_taxonomy_id  separator ', ') icn_terms
                FROM icn_term_relationships WHERE object_id = ?",
                [$result['post']->ID]
            );
            $result['categories'] = $query2->getRow();
        } else {
            $result = null;
        }

        return $result;
    }

    public function edit_icn_pressrelease($post_update, $postmeta_update, $post_id = 123)
    {
        $this->db->table($this->table)
            ->where('ID', $post_id)
            ->update($post_update);

        foreach ($postmeta_update as $key => $value) {
            $update_data = ['meta_value' => $value];

            $this->db->table('icn_postmeta')
                ->where('post_id', $post_id)
                ->where('meta_key', $key)
                ->update($update_data);
        }

        return [
            'status' => true,
            'data' => null,
            'message' => 1,
        ];
    }

    public function add_new_categories($insert_data)
    {
        $this->db->table('icn_term_relationships')->insertBatch($insert_data);

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

    public function delete_categories($categories, $post_id = 123)
    {
        if ($categories) {
            foreach ($categories as $cate) {
                $this->db->table('icn_term_relationships')
                    ->where('object_id', $post_id)
                    ->where('term_taxonomy_id', $cate)
                    ->delete();
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

    public function get_operations_filters($limit = 20, $search_query)
    {
        $query = $this->db->table('icn_posts')
            ->where($search_query)
            ->where('post_type', 'post')
            ->orderBy('ID', 'desc')
            ->limit($limit)
            ->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function move_trash_pressrelease_pending($post_id, $update_data)
    {
        $this->db->table($this->table)
            ->where('ID', $post_id)
            ->update($update_data);

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

    public function check_unique_slug_data($post_name)
    {
        $query = $this->db->table($this->table)
            ->where('post_name', $post_name)
            ->get();

        return $query->getNumRows() > 0 ? 1 : 0;
    }

    public function get_wordpress_user($post_author)
    {
        $query = $this->db->table('icn_users')
            ->select('user_login, user_nicename, user_email')
            ->where('ID', $post_author)
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow() : null;
    }

    public function get_kiosk_user($post_id)
    {
        $query = $this->db->table('kiosk_subscriptions')
            ->select('kiosk_subscriptions.user_id, kiosk_users.first_name, kiosk_users.last_name, kiosk_users.username, kiosk_users.email')
            ->join('kiosk_users', 'kiosk_subscriptions.user_id = kiosk_users.user_id', 'left')
            ->where('kiosk_subscriptions.post_id', $post_id)
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow() : null;
    }
}
