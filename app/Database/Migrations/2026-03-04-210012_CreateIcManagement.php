<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIcManagement extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `ic_management` (
  `id`              INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pr_id`           BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `pr_name`         VARCHAR(200)     DEFAULT '',
  `pr_title`        VARCHAR(500)     NOT NULL DEFAULT '',
  `post_status`     TINYINT(1)       NOT NULL DEFAULT 0 COMMENT '0=not verified,1=verified',
  `post_author`     BIGINT(20) UNSIGNED DEFAULT NULL,
  `pr_publish_time` DATETIME         DEFAULT NULL,
  `frankly_links`   TEXT,
  `bignews_links`   TEXT,
  `financial_links` TEXT,
  `payment_type`    VARCHAR(50)      DEFAULT NULL,
  `transaction_id`  VARCHAR(100)     DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pr_id`           (`pr_id`),
  KEY `idx_post_status`     (`post_status`),
  KEY `idx_pr_publish_time` (`pr_publish_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('ic_management', true);
    }
}
