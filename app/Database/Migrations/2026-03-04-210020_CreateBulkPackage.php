<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBulkPackage extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `bulk_package` (
  `id`               INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`          BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `total_credit`     INT(11)          DEFAULT 0,
  `current_credit`   INT(11)          DEFAULT 0,
  `package_selected` VARCHAR(100)     DEFAULT NULL,
  `enable_post_limit` VARCHAR(10)     DEFAULT NULL,
  `subscription_date` DATETIME        DEFAULT NULL,
  `status`           TINYINT(1)       NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_status`  (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('bulk_package', true);
    }
}
