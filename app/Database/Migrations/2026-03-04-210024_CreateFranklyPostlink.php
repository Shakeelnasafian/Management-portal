<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFranklyPostlink extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `frankly_postlink` (
  `id`       INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id`  BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_link` TEXT,
  PRIMARY KEY (`id`),
  KEY `idx_post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('frankly_postlink', true);
    }
}
