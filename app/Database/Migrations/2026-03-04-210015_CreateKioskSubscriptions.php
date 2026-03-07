<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKioskSubscriptions extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `kiosk_subscriptions` (
  `subscription_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id`         BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `user_id`         BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `kiosk_id`        INT(11) UNSIGNED    DEFAULT NULL,
  `pack_id`         INT(11) UNSIGNED    DEFAULT NULL,
  `coupons_used`    VARCHAR(255)        DEFAULT NULL,
  `cf_payGo`        VARCHAR(50)         DEFAULT NULL,
  PRIMARY KEY (`subscription_id`),
  KEY `idx_post_id`  (`post_id`),
  KEY `idx_user_id`  (`user_id`),
  KEY `idx_kiosk_id` (`kiosk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('kiosk_subscriptions', true);
    }
}
