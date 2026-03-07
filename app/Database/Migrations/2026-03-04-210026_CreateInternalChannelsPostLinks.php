<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInternalChannelsPostLinks extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `internal_channels_post_links` (
  `rss_id`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id`        BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `rss_name`       VARCHAR(100) DEFAULT NULL,
  `post_link`      TEXT,
  `fetch_date`     DATETIME     DEFAULT NULL,
  `rss_channel_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`rss_id`),
  KEY `idx_post_id`        (`post_id`),
  KEY `idx_rss_channel_id` (`rss_channel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('internal_channels_post_links', true);
    }
}
