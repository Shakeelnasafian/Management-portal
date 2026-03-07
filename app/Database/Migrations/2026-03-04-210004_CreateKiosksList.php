<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKiosksList extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `kiosks_list` (
  `kiosk_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`    VARCHAR(255) NOT NULL DEFAULT '',
  `name`     VARCHAR(100) NOT NULL DEFAULT '',
  `status`   TINYINT(1)   NOT NULL DEFAULT 1,
  PRIMARY KEY (`kiosk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('kiosks_list', true);
    }
}
