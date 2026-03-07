<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKioskCouponsPackages extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `kiosk_coupons_packages` (
  `id`        INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `coupon_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,
  `pack_id`   INT(11) UNSIGNED NOT NULL DEFAULT 0,
  `status`    TINYINT(1)       NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_coupon_id` (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('kiosk_coupons_packages', true);
    }
}
