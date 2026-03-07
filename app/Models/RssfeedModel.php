<?php

namespace App\Models;

use CodeIgniter\Model;

class RssfeedModel extends Model
{
    protected $table = 'ic_manage_rss_link';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'rss_link',
        'rss_name',
        'status',
        'created_at',
    ];

    public function get_rss_feed_links()
    {
        $query = $this->db->table($this->table)->get();
        return $query->getNumRows() > 0 ? $query->getResult() : [];
    }

    public function insert_rss_feed_link($insert_data, $feed_data)
    {
        if ($this->db->table('ic_management')->insert($insert_data)) {
            $this->db->table('ic_management_channels')->insert($feed_data);

            return [
                'status' => true,
                'data' => null,
                'message' => 'Contact created successfully.',
            ];
        }

        return [
            'status' => true,
            'data' => null,
            'message' => 'Some error occurred during consumer registration. Please try again.',
        ];
    }

    public function isnew_pr_check($data)
    {
        $query = $this->db->table('ic_management')
            ->where('pr_id', $data['pr_id'])
            ->get();

        if ($query->getNumRows() > 0) {
            $query = $this->db->table('ic_management_channels')
                ->where('pr_id', $data['pr_id'])
                ->where('channel_name', $data['channel_name'])
                ->get();

            if ($query->getNumRows() === 0) {
                $this->db->table('ic_management_channels')->insert($data);
                return true;
            }

            return true;
        }

        return false;
    }
}
