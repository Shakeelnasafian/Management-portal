<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIcnUsers extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `icn_users` (
  `ID`               BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_login`       VARCHAR(60)  NOT NULL DEFAULT '',
  `user_nicename`    VARCHAR(50)  NOT NULL DEFAULT '',
  `user_pass`        VARCHAR(255) NOT NULL DEFAULT '',
  `user_email`       VARCHAR(100) NOT NULL DEFAULT '',
  `display_name`     VARCHAR(250) NOT NULL DEFAULT '',
  `user_registered`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `uq_icn_user_login` (`user_login`),
  UNIQUE KEY `uq_icn_user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('icn_users', true);
    }
}
