<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKioskCoupons extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `kiosk_coupons` (
  `coupon_id`   INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `coupon_code` VARCHAR(100)     NOT NULL DEFAULT '',
  `date_expire` DATE             NOT NULL,
  `pack_id`     INT(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`coupon_id`),
  UNIQUE KEY `uq_coupon_code` (`coupon_code`),
  KEY `idx_date_expire` (`date_expire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('kiosk_coupons', true);
    }
}
