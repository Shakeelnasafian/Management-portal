<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKioskUsers extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `kiosk_users` (
  `user_id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_owner`       VARCHAR(100) NOT NULL DEFAULT '',
  `first_name`       VARCHAR(100) DEFAULT NULL,
  `last_name`        VARCHAR(100) DEFAULT NULL,
  `username`         VARCHAR(100) DEFAULT NULL,
  `email`            VARCHAR(100) DEFAULT NULL,
  `registration_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `cellphone`        VARCHAR(50)  DEFAULT NULL,
  `corporateAddress` VARCHAR(255) DEFAULT NULL,
  `city`             VARCHAR(100) DEFAULT NULL,
  `country`          VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `idx_user_owner` (`user_owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('kiosk_users', true);
    }
}
