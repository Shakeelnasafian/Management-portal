<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIcManageRssLink extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `ic_manage_rss_link` (
  `id`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rss_link`   VARCHAR(500) NOT NULL DEFAULT '',
  `rss_name`   VARCHAR(200) DEFAULT NULL,
  `status`     TINYINT(1)   NOT NULL DEFAULT 1,
  `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('ic_manage_rss_link', true);
    }
}
