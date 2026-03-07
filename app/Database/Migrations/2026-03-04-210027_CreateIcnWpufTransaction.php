<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIcnWpufTransaction extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `icn_wpuf_transaction` (
  `post_id`        INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` VARCHAR(100)     DEFAULT NULL,
  `amount`         DECIMAL(10,2)    DEFAULT NULL,
  `status`         VARCHAR(20)      DEFAULT NULL,
  `created_at`     DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('icn_wpuf_transaction', true);
    }
}
