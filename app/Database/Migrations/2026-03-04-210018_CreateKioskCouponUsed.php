<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKioskCouponUsed extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `kiosk_coupon_used` (
  `id`        INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `coupon_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,
  `post_id`   BIGINT(20) UNSIGNED DEFAULT NULL,
  `status`    TINYINT(1)       NOT NULL DEFAULT 0
              COMMENT '0=applied/pending, 1=used/completed',
  PRIMARY KEY (`id`),
  KEY `idx_coupon_id` (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('kiosk_coupon_used', true);
    }
}
