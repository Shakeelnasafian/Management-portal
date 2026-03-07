<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIcManagementChannels extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `ic_management_channels` (
  `id`           INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pr_id`        BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `channel_name` VARCHAR(100)      NOT NULL DEFAULT '',
  `date`         DATETIME          DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pr_id` (`pr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('ic_management_channels', true);
    }
}
