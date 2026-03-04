<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostTranslationLinks extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `post_translation_links` (
  `id`               INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `original_post_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_link`        TEXT,
  `post_language`    VARCHAR(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_original_post_id` (`original_post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('post_translation_links', true);
    }
}
