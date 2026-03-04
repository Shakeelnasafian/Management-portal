<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIcnMdrReportData extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `icn_mdr_report_data` (
  `id`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id`    BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `saved_by`   BIGINT(20) UNSIGNED DEFAULT NULL,
  `created_at` DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME            DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('icn_mdr_report_data', true);
    }
}
