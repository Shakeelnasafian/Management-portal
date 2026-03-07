<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIcUsers extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `ic_users` (
  `ID`              BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_login`      VARCHAR(60)  NOT NULL DEFAULT '',
  `user_email`      VARCHAR(100) NOT NULL DEFAULT '',
  `user_pass`       VARCHAR(255) NOT NULL DEFAULT '',
  `user_registered` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `icn_role`        VARCHAR(60)  NOT NULL DEFAULT 'editor',
  `user_role`       TINYINT(3) UNSIGNED DEFAULT NULL,
  `cell_phone`      VARCHAR(20)  DEFAULT NULL,
  `profile_image`   TEXT,
  `verify_code`     VARCHAR(10)  DEFAULT NULL,
  `created_at`      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `uq_user_login` (`user_login`),
  UNIQUE KEY `uq_user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('ic_users', true);
    }
}
