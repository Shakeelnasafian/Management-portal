<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKioskCouponHistory extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `kiosk_coupon_history` (
  `id`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `coupon_id`  INT(11) UNSIGNED NOT NULL DEFAULT 0,
  `event`      VARCHAR(100)     DEFAULT NULL,
  `created_at` DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_coupon_id` (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('kiosk_coupon_history', true);
    }
}
