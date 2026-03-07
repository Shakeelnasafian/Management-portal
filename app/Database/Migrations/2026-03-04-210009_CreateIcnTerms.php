<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIcnTerms extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `icn_terms` (
  `term_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`    VARCHAR(200) NOT NULL DEFAULT '',
  `slug`    VARCHAR(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`term_id`),
  KEY `idx_slug` (`slug`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('icn_terms', true);
    }
}
