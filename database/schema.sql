-- ============================================================
-- ICN Management Portal - Full Database Schema
-- Engine: MySQL 5.7+ / MariaDB 10.3+
-- Charset: utf8mb4
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------------------------------------
-- 1. ic_users  (Staff / Admin authentication)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ic_users` (
  `ID`              BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_login`      VARCHAR(60)  NOT NULL DEFAULT '',
  `user_email`      VARCHAR(100) NOT NULL DEFAULT '',
  `user_pass`       VARCHAR(255) NOT NULL DEFAULT '',
  `user_registered` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `icn_role`        VARCHAR(60)  NOT NULL DEFAULT 'editor',
  `user_role`       TINYINT(3) UNSIGNED DEFAULT NULL,
  `cell_phone`      VARCHAR(20)  DEFAULT NULL,
  `profile_image`   TEXT,
  `verify_code`     VARCHAR(10)  DEFAULT NULL,
  `created_at`      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `uq_user_login` (`user_login`),
  UNIQUE KEY `uq_user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 2. icn_users  (Kiosk / consumer users - WP-style)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `icn_users` (
  `ID`               BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_login`       VARCHAR(60)  NOT NULL DEFAULT '',
  `user_nicename`    VARCHAR(50)  NOT NULL DEFAULT '',
  `user_pass`        VARCHAR(255) NOT NULL DEFAULT '',
  `user_email`       VARCHAR(100) NOT NULL DEFAULT '',
  `display_name`     VARCHAR(250) NOT NULL DEFAULT '',
  `user_registered`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `uq_icn_user_login` (`user_login`),
  UNIQUE KEY `uq_icn_user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 3. icn_usermeta  (Key/value metadata for icn_users)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `icn_usermeta` (
  `umeta_id`   BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`    BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key`   VARCHAR(255) DEFAULT NULL,
  `meta_value` LONGTEXT,
  PRIMARY KEY (`umeta_id`),
  KEY `idx_user_id`  (`user_id`),
  KEY `idx_meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- meta_key values used: first_name, last_name, cell_phone,
--   state_region, corporate_address, city, country, icn_capabilities

-- ----------------------------------------------------------
-- 4. kiosk_users  (Kiosk-specific user records)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiosk_users` (
  `user_id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_owner`       VARCHAR(100) NOT NULL DEFAULT '',
  `first_name`       VARCHAR(100) DEFAULT NULL,
  `last_name`        VARCHAR(100) DEFAULT NULL,
  `username`         VARCHAR(100) DEFAULT NULL,
  `email`            VARCHAR(100) DEFAULT NULL,
  `registration_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `cellphone`        VARCHAR(50)  DEFAULT NULL,
  `corporateAddress` VARCHAR(255) DEFAULT NULL,
  `city`             VARCHAR(100) DEFAULT NULL,
  `country`          VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `idx_user_owner` (`user_owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- user_owner values: 'Legal Newswire', 'Content Marketing', 'Wire.RealEstate'

-- ----------------------------------------------------------
-- 5. kiosks_list  (Available kiosk definitions)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiosks_list` (
  `kiosk_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`    VARCHAR(255) NOT NULL DEFAULT '',
  `name`     VARCHAR(100) NOT NULL DEFAULT '',
  `status`   TINYINT(1)   NOT NULL DEFAULT 1,
  PRIMARY KEY (`kiosk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 6. icn_posts  (Press releases - WP-style posts table)
-- ----------------------------------------------------------
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
-- post_status values: draft, pending, publish, future, trash

-- ----------------------------------------------------------
-- 7. icn_postmeta  (Key/value metadata for icn_posts)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `icn_postmeta` (
  `meta_id`    BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id`    BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key`   VARCHAR(255) DEFAULT NULL,
  `meta_value` LONGTEXT,
  PRIMARY KEY (`meta_id`),
  KEY `idx_post_id`  (`post_id`),
  KEY `idx_meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- meta_key values: cf_payGo, cf_kiosk_id, cf_cont_info,
--   cf_campaign_link, cf_keywords, _websites,
--   _impressions, _clicks, Report_PDF_Link,
--   seo_meta_title, seo_meta_description

-- ----------------------------------------------------------
-- 8. icn_posts_archive  (SEO archive of published PRs)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `icn_posts_archive` (
  `ID`         BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_title` TEXT                NOT NULL,
  `post_name`  VARCHAR(200)        NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `idx_post_name` (`post_name`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 9. icn_postmeta_archive  (Metadata for archived PRs)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `icn_postmeta_archive` (
  `meta_id`    BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id`    BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key`   VARCHAR(255) DEFAULT NULL,
  `meta_value` LONGTEXT,
  PRIMARY KEY (`meta_id`),
  KEY `idx_post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- meta_key values: seo_meta_title, seo_meta_description

-- ----------------------------------------------------------
-- 10. icn_terms  (Taxonomy terms - categories, tags)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `icn_terms` (
  `term_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`    VARCHAR(200) NOT NULL DEFAULT '',
  `slug`    VARCHAR(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`term_id`),
  KEY `idx_slug` (`slug`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 11. icn_term_taxonomy  (Term taxonomy associations)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `icn_term_taxonomy` (
  `term_taxonomy_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `term_id`          BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `taxonomy`         VARCHAR(32)          NOT NULL DEFAULT '',
  PRIMARY KEY (`term_taxonomy_id`),
  KEY `idx_term_id`  (`term_id`),
  KEY `idx_taxonomy` (`taxonomy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- taxonomy values: category

-- ----------------------------------------------------------
-- 12. icn_term_relationships  (Post - term associations)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `icn_term_relationships` (
  `object_id`        BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_taxonomy_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`object_id`, `term_taxonomy_id`),
  KEY `idx_term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 13. ic_management  (Published PR tracking / distribution)
-- ----------------------------------------------------------
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

-- ----------------------------------------------------------
-- 14. ic_management_channels  (Distribution channel log)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ic_management_channels` (
  `id`           INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pr_id`        BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `channel_name` VARCHAR(100)      NOT NULL DEFAULT '',
  `date`         DATETIME          DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pr_id` (`pr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- channel_name values: frankly_links, bignews_links,
--   financial_links, ips_links

-- ----------------------------------------------------------
-- 15. ic_campaign_tracking  (Campaign tracking per PR)
-- ----------------------------------------------------------
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
-- department values: social-media, graphics-design, operations
-- campaign_status values: active, completed

-- ----------------------------------------------------------
-- 16. kiosk_subscriptions  (PR purchase / subscription)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiosk_subscriptions` (
  `subscription_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id`         BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `user_id`         BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `kiosk_id`        INT(11) UNSIGNED    DEFAULT NULL,
  `pack_id`         INT(11) UNSIGNED    DEFAULT NULL,
  `coupons_used`    VARCHAR(255)        DEFAULT NULL,
  `cf_payGo`        VARCHAR(50)         DEFAULT NULL,
  PRIMARY KEY (`subscription_id`),
  KEY `idx_post_id`  (`post_id`),
  KEY `idx_user_id`  (`user_id`),
  KEY `idx_kiosk_id` (`kiosk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 17. kiosk_coupons  (Coupon definitions)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiosk_coupons` (
  `coupon_id`   INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `coupon_code` VARCHAR(100)     NOT NULL DEFAULT '',
  `date_expire` DATE             NOT NULL,
  `pack_id`     INT(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`coupon_id`),
  UNIQUE KEY `uq_coupon_code` (`coupon_code`),
  KEY `idx_date_expire` (`date_expire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 18. kiosk_coupons_packages  (Coupon - package mapping)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiosk_coupons_packages` (
  `id`        INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `coupon_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,
  `pack_id`   INT(11) UNSIGNED NOT NULL DEFAULT 0,
  `status`    TINYINT(1)       NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_coupon_id` (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 19. kiosk_coupon_used  (Per-PR coupon usage log)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiosk_coupon_used` (
  `id`        INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `coupon_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,
  `post_id`   BIGINT(20) UNSIGNED DEFAULT NULL,
  `status`    TINYINT(1)       NOT NULL DEFAULT 0
              COMMENT '0=applied/pending, 1=used/completed',
  PRIMARY KEY (`id`),
  KEY `idx_coupon_id` (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 20. kiosk_coupon_history  (Audit log for coupon events)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `kiosk_coupon_history` (
  `id`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `coupon_id`  INT(11) UNSIGNED NOT NULL DEFAULT 0,
  `event`      VARCHAR(100)     DEFAULT NULL,
  `created_at` DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_coupon_id` (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 21. bulk_package  (Credit / bulk purchase packages)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `bulk_package` (
  `id`               INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`          BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `total_credit`     INT(11)          DEFAULT 0,
  `current_credit`   INT(11)          DEFAULT 0,
  `package_selected` VARCHAR(100)     DEFAULT NULL,
  `enable_post_limit` VARCHAR(10)     DEFAULT NULL,
  `subscription_date` DATETIME        DEFAULT NULL,
  `status`           TINYINT(1)       NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_status`  (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 22. nexis_sales_form  (Nexis user onboarding records)
-- ----------------------------------------------------------
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

-- ----------------------------------------------------------
-- 23. icn_mdr_report_data  (Social media reporting data)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `icn_mdr_report_data` (
  `id`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id`    BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `saved_by`   BIGINT(20) UNSIGNED DEFAULT NULL,
  `created_at` DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME            DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 24. ic_manage_rss_link  (RSS feed sources)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ic_manage_rss_link` (
  `id`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rss_link`   VARCHAR(500) NOT NULL DEFAULT '',
  `rss_name`   VARCHAR(200) DEFAULT NULL,
  `status`     TINYINT(1)   NOT NULL DEFAULT 1,
  `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 25. frankly_postlink  (Frankly distribution links)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `frankly_postlink` (
  `id`       INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id`  BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_link` TEXT,
  PRIMARY KEY (`id`),
  KEY `idx_post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 26. post_translation_links  (Multilingual PR links)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `post_translation_links` (
  `id`               INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `original_post_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_link`        TEXT,
  `post_language`    VARCHAR(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_original_post_id` (`original_post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 27. internal_channels_post_links  (RSS channel distribution)
-- ----------------------------------------------------------
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

-- ----------------------------------------------------------
-- 28. icn_wpuf_transaction  (Payment transaction records)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `icn_wpuf_transaction` (
  `post_id`        INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` VARCHAR(100)     DEFAULT NULL,
  `amount`         DECIMAL(10,2)    DEFAULT NULL,
  `status`         VARCHAR(20)      DEFAULT NULL,
  `created_at`     DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 29. ci_sessions  (CI4 session handler)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id`         VARCHAR(128) NOT NULL,
  `ip_address` VARCHAR(45)  NOT NULL,
  `timestamp`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `data`       BLOB         NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
