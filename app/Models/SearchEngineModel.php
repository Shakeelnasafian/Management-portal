<?php

namespace App\Models;

use CodeIgniter\Model;

class SearchEngineModel extends Model
{
    protected $table = 'icn_posts_archive';
    protected $primaryKey = 'ID';
    protected $returnType = 'object';
    protected $allowedFields = [
        'post_title',
        'post_name',
    ];

    public function search_archive_post($post_name)
    {
        $query = $this->db->table($this->table)
            ->select('ID, post_title, post_name')
            ->where('post_name', $post_name)
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow() : null;
    }

    public function edit_archive_post($ID = 123)
    {
        $query = $this->db->query(
            "SELECT
                icn_posts_archive.*,
                max( CASE WHEN icn_postmeta_archive.meta_key = 'seo_meta_title' THEN icn_postmeta_archive.meta_value END ) meta_title,
                max( CASE WHEN icn_postmeta_archive.meta_key = 'seo_meta_description' THEN icn_postmeta_archive.meta_value END ) meta_description
            FROM icn_posts_archive, icn_postmeta_archive
            WHERE icn_posts_archive.ID = icn_postmeta_archive.post_id
                AND ? = icn_posts_archive.ID",
            [$ID]
        );

        return $query->getNumRows() > 0 ? $query->getRow() : null;
    }

    public function update_pressrelease_archive_data($update_data, $ID, $meta_data)
    {
        $this->db->table($this->table)
            ->where('ID', $ID)
            ->update($update_data);

        $query = $this->db->table('icn_postmeta_archive')
            ->where('post_id', $ID)
            ->where('meta_key', 'seo_meta_title')
            ->get();

        if ($query->getNumRows() > 0) {
            foreach ($meta_data as $key => $value) {
                $update_data = ['meta_value' => $value];
                $this->db->table('icn_postmeta_archive')
                    ->where('post_id', $ID)
                    ->where('meta_key', $key)
                    ->update($update_data);
            }
        } else {
            foreach ($meta_data as $key => $value) {
                $insert_data = [
                    'post_id' => $ID,
                    'meta_key' => $key,
                    'meta_value' => $value,
                ];

                $this->db->table('icn_postmeta_archive')->insert($insert_data);
            }
        }

        if ($this->db->affectedRows() > 0) {
            return [
                'status' => true,
                'data' => null,
                'message' => 'Pressrelease Updated successfully',
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'message' => 'Pressrelease Updation Failed',
        ];
    }

    public function delete_archive_post($ID)
    {
        $this->db->table($this->table)
            ->where('ID', $ID)
            ->delete();

        if ($this->db->affectedRows() > 0) {
            return [
                'status' => true,
                'data' => null,
                'message' => 'Pressrelease Deleted successfully',
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'message' => 'Pressrelease Deletion Failed',
        ];
    }
}
