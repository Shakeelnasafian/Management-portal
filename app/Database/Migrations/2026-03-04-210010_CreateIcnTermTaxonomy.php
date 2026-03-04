<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIcnTermTaxonomy extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `icn_term_taxonomy` (
  `term_taxonomy_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `term_id`          BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `taxonomy`         VARCHAR(32)          NOT NULL DEFAULT '',
  PRIMARY KEY (`term_taxonomy_id`),
  KEY `idx_term_id`  (`term_id`),
  KEY `idx_taxonomy` (`taxonomy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('icn_term_taxonomy', true);
    }
}
