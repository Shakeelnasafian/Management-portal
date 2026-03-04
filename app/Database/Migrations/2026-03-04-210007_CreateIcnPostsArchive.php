<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIcnPostsArchive extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `icn_posts_archive` (
  `ID`         BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_title` TEXT                NOT NULL,
  `post_name`  VARCHAR(200)        NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `idx_post_name` (`post_name`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('icn_posts_archive', true);
    }
}
