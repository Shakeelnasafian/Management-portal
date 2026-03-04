<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIcnPostmeta extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `icn_postmeta` (
  `meta_id`    BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id`    BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key`   VARCHAR(255) DEFAULT NULL,
  `meta_value` LONGTEXT,
  PRIMARY KEY (`meta_id`),
  KEY `idx_post_id`  (`post_id`),
  KEY `idx_meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('icn_postmeta', true);
    }
}
