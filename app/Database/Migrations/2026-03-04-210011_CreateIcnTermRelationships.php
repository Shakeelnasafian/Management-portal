<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIcnTermRelationships extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `icn_term_relationships` (
  `object_id`        BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_taxonomy_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`object_id`, `term_taxonomy_id`),
  KEY `idx_term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('icn_term_relationships', true);
    }
}
