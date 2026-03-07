<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIcnUsermeta extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `icn_usermeta` (
  `umeta_id`   BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`    BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key`   VARCHAR(255) DEFAULT NULL,
  `meta_value` LONGTEXT,
  PRIMARY KEY (`umeta_id`),
  KEY `idx_user_id`  (`user_id`),
  KEY `idx_meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('icn_usermeta', true);
    }
}
