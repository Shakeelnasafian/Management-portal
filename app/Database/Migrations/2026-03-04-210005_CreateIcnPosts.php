<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIcnPosts extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `icn_posts` (
  `ID`                  BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_author`         BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_date`           DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_date_gmt`       DATETIME            DEFAULT NULL,
  `post_content`        LONGTEXT            NOT NULL,
  `post_title`          TEXT                NOT NULL,
  `post_excerpt`        TEXT,
  `post_status`         VARCHAR(20)         NOT NULL DEFAULT 'draft',
  `comment_status`      VARCHAR(20)         NOT NULL DEFAULT 'closed',
  `ping_status`         VARCHAR(20)         NOT NULL DEFAULT 'closed',
  `post_password`       VARCHAR(255)        NOT NULL DEFAULT '',
  `post_name`           VARCHAR(200)        NOT NULL DEFAULT '',
  `to_ping`             TEXT,
  `pinged`              TEXT,
  `post_modified`       DATETIME            DEFAULT NULL,
  `post_modified_gmt`   DATETIME            DEFAULT NULL,
  `post_content_filtered` LONGTEXT,
  `post_parent`         BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `guid`                VARCHAR(255)        NOT NULL DEFAULT '',
  `menu_order`          INT(11)             NOT NULL DEFAULT 0,
  `post_type`           VARCHAR(20)         NOT NULL DEFAULT 'post',
  `post_mime_type`      VARCHAR(100)        NOT NULL DEFAULT '',
  `comment_count`       BIGINT(20)          NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  KEY `idx_post_status` (`post_status`),
  KEY `idx_post_type`   (`post_type`),
  KEY `idx_post_author` (`post_author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('icn_posts', true);
    }
}
