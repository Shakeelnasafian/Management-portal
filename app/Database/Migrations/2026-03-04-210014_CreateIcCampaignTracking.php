<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIcCampaignTracking extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `ic_campaign_tracking` (
  `campaign_id`     INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id`         BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_title`      TEXT,
  `post_name`       VARCHAR(200) DEFAULT NULL,
  `pr_package`      VARCHAR(100) DEFAULT NULL,
  `start_date`      DATE         DEFAULT NULL,
  `end_date`        DATE         DEFAULT NULL,
  `client_name`     VARCHAR(255) DEFAULT NULL,
  `product_name`    VARCHAR(255) DEFAULT NULL,
  `department`      VARCHAR(50)  DEFAULT NULL,
  `campaign_status` VARCHAR(50)  NOT NULL DEFAULT 'active',
  `pr_mockup_link`  TEXT,
  PRIMARY KEY (`campaign_id`),
  KEY `idx_post_id`    (`post_id`),
  KEY `idx_department` (`department`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('ic_campaign_tracking', true);
    }
}
