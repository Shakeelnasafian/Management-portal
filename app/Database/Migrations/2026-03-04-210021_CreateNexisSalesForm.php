<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNexisSalesForm extends Migration
{
    public function up()
    {
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `nexis_sales_form` (
  `ID`               INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_name`      VARCHAR(200) DEFAULT NULL,
  `client_email`     VARCHAR(150) DEFAULT NULL,
  `client_company`   VARCHAR(200) DEFAULT NULL,
  `credit_request`   INT(11)      DEFAULT NULL,
  `client_country`   VARCHAR(100) DEFAULT NULL,
  `nexis_sqa_email`  VARCHAR(150) DEFAULT NULL,
  `nexis_am_email`   VARCHAR(150) DEFAULT NULL,
  `nexis_seller_email` VARCHAR(150) DEFAULT NULL,
  `user_id`          BIGINT(20) UNSIGNED DEFAULT NULL,
  `created_at`       DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
        $this->db->query($sql);
    }

    public function down()
    {
        $this->forge->dropTable('nexis_sales_form', true);
    }
}
