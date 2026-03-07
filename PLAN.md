# ICN Management Portal — Migration Plan
## Phase 1: Database Creation → Phase 2: CI3 to CI4 Migration

> **Target executor:** Codex (autonomous AI coding agent)
> **Project:** ICN Management Portal (iCrowd)
> **Framework migration:** CodeIgniter 3.x → CodeIgniter 4.x
> **Current state:** CI3 codebase, no database schema on disk

---

## PHASE 1 — DATABASE SCHEMA CREATION

### 1.1 Overview

Create all database tables the application depends on. There is no existing SQL file in the repo. Tables are inferred from all models, helpers, and query logic throughout the codebase.

### 1.2 Create the Migration SQL File

Create the file at: `database/schema.sql`

```sql
-- ============================================================
-- ICN Management Portal — Full Database Schema
-- Engine: MySQL 5.7+ / MariaDB 10.3+
-- Charset: utf8mb4
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------------------------------------
-- 1. ic_users  (Staff / Admin authentication)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ic_users` (
  `ID`            BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_login`    VARCHAR(60)  NOT NULL DEFAULT '',
  `user_email`    VARCHAR(100) NOT NULL DEFAULT '',
  `user_pass`     VARCHAR(255) NOT NULL DEFAULT '',
  `icn_role`      VARCHAR(60)  NOT NULL DEFAULT 'editor',
  `cell_phone`    VARCHAR(20)  DEFAULT NULL,
  `verify_code`   VARCHAR(10)  DEFAULT NULL,
  `created_at`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `uq_user_login` (`user_login`),
  UNIQUE KEY `uq_user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 2. icn_users  (Kiosk / consumer users — WP-style)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `icn_users` (
  `ID`               BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_login`       VARCHAR(60)  NOT NULL DEFAULT '',
  `user_nicename`    VARCHAR(50)  NOT NULL DEFAULT '',
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
  `user_id`    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_owner` VARCHAR(100) NOT NULL DEFAULT '',
  `first_name` VARCHAR(100) DEFAULT NULL,
  `last_name`  VARCHAR(100) DEFAULT NULL,
  `username`   VARCHAR(100) DEFAULT NULL,
  `email`      VARCHAR(100) DEFAULT NULL,
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
-- 6. icn_posts  (Press releases — WP-style posts table)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `icn_posts` (
  `ID`           BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_author`  BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_date`    DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_content` LONGTEXT            NOT NULL,
  `post_title`   TEXT                NOT NULL,
  `post_name`    VARCHAR(200)        NOT NULL DEFAULT '',
  `post_status`  VARCHAR(20)         NOT NULL DEFAULT 'draft',
  `post_type`    VARCHAR(20)         NOT NULL DEFAULT 'post',
  `guid`         VARCHAR(255)        NOT NULL DEFAULT '',
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
-- 10. icn_terms  (Taxonomy terms — categories, tags)
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
-- 12. icn_term_relationships  (Post ↔ term associations)
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
  `department`      VARCHAR(50) DEFAULT NULL,
  `campaign_status` VARCHAR(50) NOT NULL DEFAULT 'active',
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
-- 18. kiosk_coupons_packages  (Coupon ↔ package mapping)
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
  `status`           TINYINT(1)       NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_status`  (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 22. nexis_sales_form  (Nexis user onboarding records)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexis_sales_form` (
  `ID`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- Additional columns to be added based on actual form fields

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
  `feed_url`   VARCHAR(500) NOT NULL DEFAULT '',
  `feed_name`  VARCHAR(200) DEFAULT NULL,
  `status`     TINYINT(1)   NOT NULL DEFAULT 1,
  `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 25. frankly_postlink  (Frankly distribution links)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `frankly_postlink` (
  `id`      INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `link`    TEXT,
  PRIMARY KEY (`id`),
  KEY `idx_post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 26. post_translation_links  (Multilingual PR links)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `post_translation_links` (
  `id`               INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `original_post_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  `translated_link`  TEXT,
  `language`         VARCHAR(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_original_post_id` (`original_post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------------------------
-- 27. internal_channels_post_links  (RSS channel distribution)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `internal_channels_post_links` (
  `rss_id`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id`        BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
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

SET FOREIGN_KEY_CHECKS = 1;
```

### 1.3 Create CI4 Database Migration Files

After Phase 2 sets up CI4, also create individual migration files in `app/Database/Migrations/`. Each migration class should correspond to one table.

Example naming pattern: `YYYY-MM-DD-HHMMSS_CreateTableName.php`

Use the CI4 `forge` API inside each migration's `up()` method.

### 1.4 Configure Database Connection

Update `app/Config/Database.php` (CI4 location):

```php
public array $default = [
    'DSN'      => '',
    'hostname' => 'localhost',
    'username' => 'root',         // change for production
    'password' => '',             // change for production
    'database' => 'icn_management',
    'DBDriver' => 'MySQLi',
    'DBPrefix' => '',
    'pConnect' => false,
    'DBDebug'  => true,
    'charset'  => 'utf8mb4',
    'DBCollat' => 'utf8mb4_general_ci',
    'swapPre'  => '',
    'encrypt'  => false,
    'compress' => false,
    'strictOn' => false,
    'failover' => [],
    'port'     => 3306,
];
```

Also create/update `.env`:

```
database.default.hostname = localhost
database.default.database = icn_management
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port     = 3306
```

---

## PHASE 2 — CI3 TO CI4 MIGRATION

### 2.0 Key Differences Reference

| CI3 | CI4 Equivalent |
|-----|---------------|
| `application/` directory | `app/` directory |
| No namespaces | All classes namespaced under `App\` |
| `extends CI_Controller` | `extends BaseController` |
| `extends CI_Model` | `extends Model` |
| `$this->load->model('Foo_model')` | `$this->fooModel = new FooModel()` or `model('FooModel')` |
| `$this->load->view('file', $data)` | `return view('file', $data)` |
| `$this->load->helper('url')` | `helper('url')` or autoload in `Config/Autoload.php` |
| `$this->load->library('form_validation')` | `$validation = \Config\Services::validation()` |
| `$this->session->userdata('key')` | `session()->get('key')` |
| `$this->session->set_userdata([])` | `session()->set([])` |
| `$this->session->unset_userdata('key')` | `session()->remove('key')` |
| `$this->session->sess_destroy()` | `session()->destroy()` |
| `$this->input->post('key')` | `$this->request->getPost('key')` |
| `$this->input->get('key')` | `$this->request->getGet('key')` |
| `$this->input->server('key')` | `$this->request->getServer('key')` |
| `$this->db->get('table')` | `$db->table('table')->get()` |
| `$this->db->insert('table', $data)` | `$db->table('table')->insert($data)` |
| `$this->db->update('table', $data, $where)` | `$db->table('table')->where($where)->update($data)` |
| `$this->db->where('col', 'val')` | `$builder->where('col', 'val')` (chained) |
| `$this->db->last_insert_id()` | `$db->insertID()` |
| `$this->db->insert_batch()` | `$db->table()->insertBatch()` |
| `$this->pagination->initialize($config)` | `$pager = service('pager')` |
| `$this->form_validation->set_rules()` | `$this->validate($rules)` or `$validation->setRules()` |
| `$this->form_validation->run()` | `$this->validate($rules)` returns bool |
| `base_url()` | `base_url()` (still works) |
| `redirect()` | `return redirect()->to(url)` |
| `show_404()` | `throw new \CodeIgniter\Exceptions\PageNotFoundException()` |
| `$this->load->library('email')` | `$email = \Config\Services::email()` |
| Hooks (`application/hooks/`) | Filters (`app/Filters/`) |
| `config('item')` | `config('ClassName')->property` |
| `APPPATH` constant | `APPPATH` still works |
| `$this->uri->segment(n)` | `$this->request->uri->getSegment(n)` |
| `$this->output->set_output()` | `return $this->response->setBody()` |

---

### 2.1 Step-by-Step Migration Tasks

---

#### TASK 1 — Install CodeIgniter 4

```bash
composer create-project codeigniter4/appstarter ci4_app
```

Or add CI4 to the existing project using Composer. Copy the new `app/` and `public/` skeleton into the project root. Do **not** delete the `application/` directory yet — use it as reference during migration.

The target directory structure after migration:

```
/project-root/
├── app/
│   ├── Config/
│   ├── Controllers/
│   ├── Database/
│   │   ├── Migrations/
│   │   └── Seeds/
│   ├── Filters/
│   ├── Helpers/
│   ├── Libraries/
│   ├── Models/
│   └── Views/
│       ├── inc/
│       ├── campaign/
│       ├── coupon/
│       ├── kiosk-users/
│       ├── management/
│       ├── operations/
│       ├── pressrelease/
│       ├── reporting/
│       ├── sales/
│       ├── search-engine/
│       ├── users/
│       └── utility/
├── database/
│   └── schema.sql
├── public/
│   └── index.php
├── assets/
├── vendor/
├── .env
└── composer.json
```

---

#### TASK 2 — Configuration Files

**2a. `app/Config/App.php`**

Map from `application/config/config.php`:
- `$baseURL` — set from `BASE_URL` constant logic (detect https)
- `$defaultLocale` = `'en'`
- `$negotiateLocale` = `false`
- `$supportedLocales` = `['en']`
- `$appTimezone` = `'America/Chicago'` (match existing timezone setting)
- `$charset` = `'UTF-8'`
- `$forceGlobalSecureRequests` = `false`
- `$sessionDriver` = `'CodeIgniter\Session\Handlers\DatabaseHandler'`
- `$sessionCookieName` = `'ci_session'`
- `$sessionExpiration` = `7200`
- `$sessionSavePath` = `'ci_sessions'` (table name for DB sessions)
- `$sessionMatchIP` = `false`
- `$sessionTimeToUpdate` = `300`
- `$sessionRegenerateDestroy` = `false`
- `$cookiePrefix` = `''`
- `$cookieDomain` = `''`
- `$cookiePath` = `'/'`
- `$cookieSecure` = `false`
- `$cookieHTTPOnly` = `false`
- `$CSRFProtection` = `true`
- `$CSRFTokenName` = `'csrf_token_name'`
- `$CSRFCookieName` = `'csrf_cookie_name'`
- `$CSRFExpire` = `7200`
- `$CSRFRegenerate` = `true`

**2b. `app/Config/Constants.php`**

Re-declare all constants from `application/config/constants.php`:

```php
<?php
defined('APPPATH') || exit('No direct script access');

define('SITE_NAME', 'ICN-Management');
define('ASSETS', base_url('assets/adminlte/'));
define('COUNTER_LIMIT', 30);

// RSS Feeds (update with real values from constants.php)
define('FRANKLY_RSS_FEED', env('FRANKLY_RSS_FEED', ''));
define('BIGPOND_RSS_FEED',  env('BIGPOND_RSS_FEED', ''));

// External API credentials — store in .env, never hardcode
define('PAYPAL_CLIENT', env('PAYPAL_CLIENT', ''));
define('PAYPAL_SECRET', env('PAYPAL_SECRET', ''));
define('ZOHO_NUM',      env('ZOHO_NUM', ''));
```

Move all credential values to `.env`:
```
FRANKLY_RSS_FEED = https://...
BIGPOND_RSS_FEED = https://...
PAYPAL_CLIENT    = ...
PAYPAL_SECRET    = ...
ZOHO_NUM         = ...
TWILIO_SID       = ...
TWILIO_TOKEN     = ...
TWILIO_FROM      = ...
AWS_KEY          = ...
AWS_SECRET       = ...
AWS_BUCKET       = icnimage
AWS_REGION       = us-west-2
```

**2c. `app/Config/Routes.php`**

```php
$routes->setDefaultController('Management');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(true);
$routes->set404Override();

// Explicit routes for all controllers
$routes->get('/',                         'Management::index');
$routes->get('management',                'Management::index');
$routes->post('management/date_searching','Management::date_searching');

$routes->get('campaign',                  'Campaign::index');
$routes->get('campaign/active',           'Campaign::active_campaigns');
$routes->get('campaign/completed',        'Campaign::completed_campaigns');
$routes->get('campaign/socialmedia',      'Campaign::socialmedia_dashboard');
$routes->get('campaign/operations',       'Campaign::operations_dashboard');
$routes->get('campaign/graphics',         'Campaign::graphics_dashboard');

$routes->get('operations/create',         'Operations::create_pressrelease');
$routes->post('operations/create',        'Operations::create_pressrelease');
$routes->get('operations/draft',          'Operations::draft_dashboard');
$routes->get('operations/pending',        'Operations::pending_dashboard');
$routes->get('operations/published',      'Operations::published_dashboard');
$routes->get('operations/schedule',       'Operations::schedule_dashboard');
$routes->get('operations/trashed',        'Operations::trashed_dashboard');

$routes->get('pressrelease/verified',     'Pressrelease::verified_prs');
$routes->get('pressrelease/unverified',   'Pressrelease::none_verified_prs');

$routes->get('coupon',                    'Coupon::icn_coupons');
$routes->get('coupon/expired',            'Coupon::expired_coupons');
$routes->get('coupon/add',                'Coupon::add_coupon');
$routes->post('coupon/add',               'Coupon::add_coupon');

$routes->get('sales',                     'Sales::pressreleases');
$routes->get('sales/coupons',             'Sales::coupons');
$routes->get('sales/credits',             'Sales::user_credits');

$routes->get('kiosk-users/search',        'KioskUsers::search_user');
$routes->post('kiosk-users/find',         'KioskUsers::find_user');

$routes->get('reporting',                 'Reporting::dashboard');
$routes->get('reporting/add',             'Reporting::add_report');
$routes->post('reporting/add',            'Reporting::add_report');

$routes->get('search-engine',             'SearchEngine::find_pressrelease');
$routes->post('search-engine',            'SearchEngine::find_pressrelease');

$routes->get('utility',                   'Utility::pr_media_sites_links');
$routes->get('rssfeed',                   'Rssfeed::read_rss_feed');
$routes->get('zoho/sync',                 'Zohosync::sync_icrowd_users_zoho');

$routes->get('users/login',               'Users::login');
$routes->post('users/login',              'Users::login');
$routes->get('users/logout',              'Users::logout');
$routes->get('users/forgot-password',     'Users::forgot_password');
$routes->post('users/forgot-password',    'Users::forgot_password');
$routes->get('users/profile',             'Users::profile');
```

**2d. `app/Config/Autoload.php`**

```php
public $helpers = ['url', 'form', 'utility'];
```

**2e. Create `app/Config/Services.php`** additions for custom libraries:

```php
public static function twilio(bool $getShared = true): \App\Libraries\Twilio
{
    return static::getSharedInstance('twilio', $getShared)
        ?? new \App\Libraries\Twilio();
}

public static function amazon(bool $getShared = true): \App\Libraries\Amazon
{
    return static::getSharedInstance('amazon', $getShared)
        ?? new \App\Libraries\Amazon();
}
```

---

#### TASK 3 — Create the Auth Filter

Create `app/Filters/AuthFilter.php` to replace the inline session checks in every CI3 controller:

```php
<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (! $session->get('logged_in')) {
            return redirect()->to(base_url('users/login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing
    }
}
```

Register in `app/Config/Filters.php`:

```php
public array $aliases = [
    'auth' => \App\Filters\AuthFilter::class,
];

public array $filters = [
    'auth' => [
        'before' => [
            'management*', 'campaign*', 'operations*',
            'pressrelease*', 'coupon*', 'sales*',
            'kiosk-users*', 'reporting*', 'search-engine*',
            'utility*', 'rssfeed*', 'zoho*',
            'users/add', 'users/profile', 'users/change-password',
        ],
    ],
];
```

---

#### TASK 4 — Migrate Controllers

Create all 13 controllers in `app/Controllers/`. Each controller must:

1. Start with `<?php namespace App\Controllers;`
2. Extend `BaseController` (already extends `\CodeIgniter\Controller`)
3. Replace `$this->load->model()` with model instantiation
4. Replace `$this->load->view()` with `return view()`
5. Replace all session calls using `session()` helper
6. Replace `$this->input->post()` with `$this->request->getPost()`
7. Replace `redirect()` with `return redirect()->to()`
8. Remove all `$this->load->library()` / `$this->load->helper()` calls
9. Remove the inline `logged_in` check (handled by AuthFilter)

**Template for each controller:**

```php
<?php
namespace App\Controllers;

use App\Models\FooModel;

class Foo extends BaseController
{
    protected FooModel $fooModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->fooModel = new FooModel();
    }

    public function index(): string
    {
        $data = [
            'title' => 'Dashboard',
            'items' => $this->fooModel->getAll(),
        ];
        return view('foo/index', $data);
    }
}
```

**Controllers to migrate (13 total):**

| Old file | New file | New class name |
|----------|----------|----------------|
| `Management.php` | `app/Controllers/Management.php` | `Management` |
| `Campaign.php` | `app/Controllers/Campaign.php` | `Campaign` |
| `Operations.php` | `app/Controllers/Operations.php` | `Operations` |
| `Pressrelease.php` | `app/Controllers/Pressrelease.php` | `Pressrelease` |
| `Coupon.php` | `app/Controllers/Coupon.php` | `Coupon` |
| `Sales.php` | `app/Controllers/Sales.php` | `Sales` |
| `Kiosk_users.php` | `app/Controllers/KioskUsers.php` | `KioskUsers` |
| `Reporting.php` | `app/Controllers/Reporting.php` | `Reporting` |
| `Search_engine.php` | `app/Controllers/SearchEngine.php` | `SearchEngine` |
| `Utility.php` | `app/Controllers/Utility.php` | `Utility` |
| `Rssfeed.php` | `app/Controllers/Rssfeed.php` | `Rssfeed` |
| `Zohosync.php` | `app/Controllers/Zohosync.php` | `Zohosync` |
| `Users.php` | `app/Controllers/Users.php` | `Users` |

**Special handling for `Users.php` (login / 2FA flow):**

```php
// CI3 pattern:
$this->session->set_userdata(['logged_in' => true, 'user_session' => $user]);

// CI4 equivalent:
session()->set(['logged_in' => true, 'user_session' => $user]);

// CI3 logout:
$this->session->sess_destroy();
redirect('users/login');

// CI4 logout:
session()->destroy();
return redirect()->to(base_url('users/login'));
```

**Special handling for AJAX responses** (used in Management, Campaign, etc.):

```php
// CI3:
echo json_encode($result);

// CI4:
return $this->response->setJSON($result);
```

**Pagination migration** (used in Sales, Reporting):

```php
// CI3:
$config['base_url']   = base_url('sales/pressreleases');
$config['total_rows'] = $total;
$config['per_page']   = 20;
$this->pagination->initialize($config);
$data['links'] = $this->pagination->create_links();

// CI4:
$pager = service('pager');
$data['pressreleases'] = $this->salesModel->paginate(20);
$data['pager']         = $this->salesModel->pager;
// In view: <?= $pager->links() ?>
```

**Role checking** — extract to a BaseController method:

```php
// In app/Controllers/BaseController.php, add:
protected function checkRole(string ...$allowedRoles): void
{
    $role = session()->get('user_session')['icn_role'] ?? '';
    if (! in_array($role, $allowedRoles)) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
}

// Usage in controllers:
$this->checkRole('Administrator', 'Operations-Staff');
```

---

#### TASK 5 — Migrate Models

Create all 13 models in `app/Models/`. Each model must:

1. Start with `<?php namespace App\Models;`
2. Extend `\CodeIgniter\Model`
3. Set `$table`, `$primaryKey`, `$allowedFields`
4. Replace `$this->db->` with `$this->db->` (still works — CI4 models have `$this->db` available)
5. Replace `$this->db->get()->result()` with `->get()->getResultArray()` or `->get()->getResult()`
6. Replace `$this->db->get()->row()` with `->get()->getRowArray()`
7. Replace `$this->db->insert_batch()` with `->insertBatch()`
8. Replace `$this->db->last_insert_id()` with `$this->db->insertID()`
9. Replace `$this->db->affected_rows()` with `$this->db->affectedRows()`

**Model template:**

```php
<?php
namespace App\Models;

use CodeIgniter\Model;

class FooModel extends Model
{
    protected $table      = 'foo_table';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['col1', 'col2', 'col3'];

    public function getAll(): array
    {
        return $this->findAll();
    }
}
```

**Models to migrate (13 total):**

| Old file | New file | New class | Primary table |
|----------|----------|-----------|---------------|
| `Campaign_model.php` | `app/Models/CampaignModel.php` | `CampaignModel` | `ic_campaign_tracking` |
| `Coupon_model.php` | `app/Models/CouponModel.php` | `CouponModel` | `kiosk_coupons` |
| `Management_model.php` | `app/Models/ManagementModel.php` | `ManagementModel` | `ic_management` |
| `Operations_model.php` | `app/Models/OperationsModel.php` | `OperationsModel` | `icn_posts` |
| `Pressrelease_model.php` | `app/Models/PressreleaseModel.php` | `PressreleaseModel` | `ic_management` |
| `Sales_model.php` | `app/Models/SalesModel.php` | `SalesModel` | `icn_posts` |
| `Kiosk_users_model.php` | `app/Models/KioskUsersModel.php` | `KioskUsersModel` | `kiosk_users` |
| `Reporting_model.php` | `app/Models/ReportingModel.php` | `ReportingModel` | `icn_mdr_report_data` |
| `Search_engine_model.php` | `app/Models/SearchEngineModel.php` | `SearchEngineModel` | `icn_posts_archive` |
| `Utility_model.php` | `app/Models/UtilityModel.php` | `UtilityModel` | `kiosks_list` |
| `Rssfeed_model.php` | `app/Models/RssfeedModel.php` | `RssfeedModel` | `ic_manage_rss_link` |
| `Zohosync_model.php` | `app/Models/ZohosyncModel.php` | `ZohosyncModel` | `icn_users` |
| `Users_model.php` | `app/Models/UsersModel.php` | `UsersModel` | `ic_users` |

**Query Builder method name changes (CI3 → CI4):**

| CI3 method | CI4 method |
|-----------|-----------|
| `->get()->result()` | `->get()->getResult()` |
| `->get()->result_array()` | `->get()->getResultArray()` |
| `->get()->row()` | `->get()->getRow()` |
| `->get()->row_array()` | `->get()->getRowArray()` |
| `->get()->num_rows()` | `->get()->getNumRows()` |
| `->count_all_results()` | `->countAllResults()` |
| `->insert_batch()` | `->insertBatch()` |
| `->update_batch()` | `->updateBatch()` |
| `->last_insert_id()` | `$this->db->insertID()` |
| `->affected_rows()` | `$this->db->affectedRows()` |
| `->or_where()` | `->orWhere()` |
| `->where_in()` | `->whereIn()` |
| `->not_like()` | `->notLike()` |
| `->order_by()` | `->orderBy()` |
| `->group_by()` | `->groupBy()` |
| `->join()` | `->join()` (same) |
| `->select()` | `->select()` (same) |
| `->limit()` | `->limit()` (same) |
| `->offset()` | `->offset()` (same) |

---

#### TASK 6 — Migrate Helpers

Copy `application/helpers/utility_helper.php` to `app/Helpers/utility_helper.php`.

Update all helper function internals:
- Replace `$this->db` (cannot be used in helpers) with `$db = db_connect()`
- Replace `$CI =& get_instance()` with direct service calls
- Replace `$CI->load->library()` with `service()` or `new LibraryClass()`
- Replace `$CI->session->userdata()` with `session()->get()`

**Specific functions that need updating:**

```php
// OLD: uses CI3 superobject
function show_kiosks_name_view($id) {
    $CI =& get_instance();
    $CI->db->where('kiosk_id', $id);
    $result = $CI->db->get('kiosks_list')->row();
    return $result ? $result->title : '';
}

// NEW: uses CI4 db_connect()
function show_kiosks_name_view(int $id): string {
    $db     = db_connect();
    $result = $db->table('kiosks_list')->where('kiosk_id', $id)->get()->getRowArray();
    return $result['title'] ?? '';
}
```

```php
// OLD: Twilio via library
function send_message($mobile_number, $text) {
    $CI =& get_instance();
    $CI->load->library('Twilio');
    $CI->twilio->send_message($mobile_number, $text);
}

// NEW: Twilio via Services
function send_message(string $mobile_number, string $text): void {
    service('twilio')->send_message($mobile_number, $text);
}
```

```php
// OLD: upload via library
function upload_image($key, $source) {
    $CI =& get_instance();
    $CI->load->library('Amazon');
    return $CI->amazon->amazon_s3_upload($key, $source);
}

// NEW:
function upload_image(string $key, string $source): string {
    return service('amazon')->amazon_s3_upload($key, $source);
}
```

---

#### TASK 7 — Migrate Libraries

**7a. `app/Libraries/Twilio.php`**

```php
<?php
namespace App\Libraries;

class Twilio
{
    protected string $sid;
    protected string $token;
    protected string $from;

    public function __construct()
    {
        $this->sid   = env('TWILIO_SID');
        $this->token = env('TWILIO_TOKEN');
        $this->from  = env('TWILIO_FROM');
    }

    public function send_message(string $to, string $body): void
    {
        $client = new \Twilio\Rest\Client($this->sid, $this->token);
        $client->messages->create($to, ['from' => $this->from, 'body' => $body]);
    }
}
```

**7b. `app/Libraries/Amazon.php`**

```php
<?php
namespace App\Libraries;

use Aws\S3\S3Client;

class Amazon
{
    protected S3Client $s3;
    protected string   $bucket;

    public function __construct()
    {
        $this->bucket = env('AWS_BUCKET', 'icnimage');
        $this->s3     = new S3Client([
            'version'     => 'latest',
            'region'      => env('AWS_REGION', 'us-west-2'),
            'credentials' => [
                'key'    => env('AWS_KEY'),
                'secret' => env('AWS_SECRET'),
            ],
        ]);
    }

    public function amazon_s3_upload(string $key, string $source): string
    {
        $result = $this->s3->putObject([
            'Bucket'     => $this->bucket,
            'Key'        => $key,
            'SourceFile' => $source,
            'ACL'        => 'public-read',
        ]);
        return (string) $result->get('ObjectURL');
    }
}
```

**7c. Copy `application/third_party/class-phpass.php`** to `app/Libraries/PasswordHash.php` and add:

```php
namespace App\Libraries;
```

at the top (or simply require it as a standalone file via Composer autoload).

**7d. Copy `application/third_party/FeedParser/`** to `app/Libraries/FeedParser/` and add namespace headers to each file.

---

#### TASK 8 — Migrate Views

Views are largely compatible between CI3 and CI4. Copy all view files from `application/views/` to `app/Views/`.

Update the following patterns in every view file:

```php
// OLD: CI3 base_url / site_url helpers (still work in CI4, no change needed)
<?= base_url('assets/...') ?>

// OLD: CI3 form_open helper (still works in CI4)
<?= form_open('controller/method') ?>

// OLD: validation errors
<?= form_error('field_name') ?>

// NEW: CI4 validation errors
<?= service('validation')->getError('field_name') ?>
// or use:
<?= validation_show_error('field_name') ?>

// OLD: CI3 flash messages
<?= $this->session->flashdata('success') ?>

// NEW: CI4 flash messages
<?= session()->getFlashdata('success') ?>

// OLD: site_url helper
<?= site_url('controller/method') ?>
// Still works in CI4 — no change needed
```

**Pagination in views:**

```php
// OLD:
<?= $links ?>

// NEW (when using CI4 pager):
<?= $pager->links() ?>
// Or with custom template:
<?= $pager->links('default', 'bootstrap_pagination') ?>
```

---

#### TASK 9 — Create `app/Views/inc/` Layout Partials

Review each partial and update session references:

```php
// OLD (in sidebar.php, header.php etc.):
$this->session->userdata('user_session')

// NEW:
session()->get('user_session')
```

---

#### TASK 10 — Session Database Table

CI4's database session handler requires a `ci_sessions` table. Create it:

```sql
CREATE TABLE IF NOT EXISTS `ci_sessions` (
    `id`         VARCHAR(128) NOT NULL,
    `ip_address` VARCHAR(45)  NOT NULL,
    `timestamp`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `data`       BLOB         NOT NULL,
    PRIMARY KEY (`id`),
    KEY `ci_sessions_timestamp` (`timestamp`)
);
```

---

#### TASK 11 — `public/.htaccess`

CI4 uses `public/` as the webroot. Create `public/.htaccess`:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```

Update the project root `.htaccess` to redirect to `public/`:

```apache
RewriteEngine On
RewriteRule ^(.*)$ public/$1 [L]
```

---

#### TASK 12 — `composer.json` Update

Ensure CI4 and all existing dependencies are present:

```json
{
    "require": {
        "php":                     "^8.1",
        "codeigniter4/framework":  "^4.5",
        "twilio/sdk":              "^8.0",
        "aws/aws-sdk-php":         "^3.0"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        },
        "files": [
            "app/Helpers/utility_helper.php"
        ]
    }
}
```

Run after updating:
```bash
composer install
```

---

#### TASK 13 — Email Configuration

CI3's email library becomes CI4's `Services::email()`. In `app/Config/Email.php`:

```php
public string $protocol    = 'smtp';
public string $SMTPHost    = '';   // set via .env
public int    $SMTPPort    = 587;
public string $SMTPUser    = '';   // set via .env
public string $SMTPPass    = '';   // set via .env
public bool   $SMTPCrypto  = true;
public string $wordWrap    = true;
public int    $wrapChars   = 76;
public string $mailType    = 'html';
public string $charset     = 'utf-8';
public string $fromEmail   = '';
public string $fromName    = 'ICN Management';
```

In controllers, replace:

```php
// CI3:
$this->load->library('email');
$this->email->from('no-reply@example.com', 'ICN');
$this->email->to($to);
$this->email->subject($subject);
$this->email->message($body);
$this->email->send();

// CI4:
$email = \Config\Services::email();
$email->setFrom('no-reply@example.com', 'ICN');
$email->setTo($to);
$email->setSubject($subject);
$email->setMessage($body);
$email->send();
```

---

#### TASK 14 — Error Pages

Copy/recreate error views in `app/Views/errors/html/` matching CI4's expected files:
- `error_404.php`
- `error_exception.php`
- `error_general.php`
- `production.php`

---

#### TASK 15 — Remove CI3 Artifacts

After the migration is complete and tested:

1. Delete `application/` directory
2. Delete `system/` directory (CI3 core)
3. Remove old `index.php` (CI3 entry point) from project root
4. Update `.gitignore` to include `/vendor/`, `/.env`, `/writable/`

---

## PHASE 3 — TESTING CHECKLIST

After all migration tasks are complete, verify each of the following manually or with automated tests:

### Authentication
- [ ] Login with valid credentials → redirected to Management dashboard
- [ ] SMS 2FA code sent via Twilio → code verified → session established
- [ ] Forgot password → reset link email sent
- [ ] Access any protected route while logged out → redirected to login
- [ ] Role restrictions enforced (e.g., SEO-Staff cannot access Campaign)

### Management (Dashboard)
- [ ] Main dashboard loads with correct counts
- [ ] Date search returns correct filtered results
- [ ] AJAX requests return valid JSON

### Operations (Press Releases)
- [ ] Create new press release → saved to `icn_posts` with correct metadata
- [ ] Draft dashboard lists drafts
- [ ] Edit press release → updates saved
- [ ] Move PR to trash → status set to 'trash'
- [ ] Category relationships saved to `icn_term_relationships`
- [ ] Image upload → file stored in S3, URL saved to postmeta

### Pressrelease (Verification)
- [ ] Verified PRs list loads
- [ ] Unverified PRs list loads
- [ ] Verify action → record updated in `ic_management`

### Campaign
- [ ] Campaign dashboard loads
- [ ] Create campaign → inserted into `ic_campaign_tracking`
- [ ] Mockup link saved correctly
- [ ] Status toggle (active/completed) works

### Coupon
- [ ] Active coupons list loads (date_expire >= today)
- [ ] Expired coupons list loads
- [ ] Add coupon → inserted with packages
- [ ] Edit coupon → updated
- [ ] Usage stats calculated correctly (SUM by status)

### Sales
- [ ] Published PRs list with pagination
- [ ] Coupon sales data loads
- [ ] User credits list loads
- [ ] Filters produce correct results

### Kiosk Users
- [ ] Search user by email/username
- [ ] Update user credits → `bulk_package` updated
- [ ] Add credits → insert into `bulk_package`

### Reporting
- [ ] Dashboard loads with paginated results
- [ ] Create report → inserted into `icn_mdr_report_data`
- [ ] PDF upload → S3 URL stored in `icn_postmeta`

### Search Engine
- [ ] Search archive by post_name
- [ ] Edit SEO fields → `icn_postmeta_archive` updated

### Utility
- [ ] Media sites links list loads
- [ ] Add marketplace site
- [ ] Language links display

### RSS Feed
- [ ] RSS feed parsed and items stored

### Zoho Sync
- [ ] Users loaded and sync request made to Zoho API

---

## FILE MIGRATION CHECKLIST

```
application/controllers/Management.php     → app/Controllers/Management.php
application/controllers/Campaign.php       → app/Controllers/Campaign.php
application/controllers/Operations.php     → app/Controllers/Operations.php
application/controllers/Pressrelease.php   → app/Controllers/Pressrelease.php
application/controllers/Coupon.php         → app/Controllers/Coupon.php
application/controllers/Sales.php          → app/Controllers/Sales.php
application/controllers/Kiosk_users.php    → app/Controllers/KioskUsers.php
application/controllers/Reporting.php      → app/Controllers/Reporting.php
application/controllers/Search_engine.php  → app/Controllers/SearchEngine.php
application/controllers/Utility.php        → app/Controllers/Utility.php
application/controllers/Rssfeed.php        → app/Controllers/Rssfeed.php
application/controllers/Zohosync.php       → app/Controllers/Zohosync.php
application/controllers/Users.php          → app/Controllers/Users.php

application/models/Campaign_model.php      → app/Models/CampaignModel.php
application/models/Coupon_model.php        → app/Models/CouponModel.php
application/models/Management_model.php    → app/Models/ManagementModel.php
application/models/Operations_model.php    → app/Models/OperationsModel.php
application/models/Pressrelease_model.php  → app/Models/PressreleaseModel.php
application/models/Sales_model.php         → app/Models/SalesModel.php
application/models/Kiosk_users_model.php   → app/Models/KioskUsersModel.php
application/models/Reporting_model.php     → app/Models/ReportingModel.php
application/models/Search_engine_model.php → app/Models/SearchEngineModel.php
application/models/Utility_model.php       → app/Models/UtilityModel.php
application/models/Rssfeed_model.php       → app/Models/RssfeedModel.php
application/models/Zohosync_model.php      → app/Models/ZohosyncModel.php
application/models/Users_model.php         → app/Models/UsersModel.php

application/helpers/utility_helper.php     → app/Helpers/utility_helper.php
application/libraries/Twilio.php           → app/Libraries/Twilio.php
application/libraries/Amazon.php           → app/Libraries/Amazon.php
application/third_party/class-phpass.php   → app/Libraries/PasswordHash.php
application/third_party/FeedParser/        → app/Libraries/FeedParser/

application/views/ (all files)             → app/Views/ (preserve subdirectory structure)
application/config/constants.php           → app/Config/Constants.php
application/config/routes.php              → app/Config/Routes.php (rewritten)
application/config/config.php              → app/Config/App.php
application/config/database.php            → app/Config/Database.php
application/config/autoload.php            → app/Config/Autoload.php
```

---

## EXECUTION ORDER FOR CODEX

Execute tasks in this exact order to avoid dependency issues:

1. `TASK 1` — Install CI4 framework scaffold
2. `PHASE 1 §1.2` — Create `database/schema.sql`
3. `TASK 2` — Write all Config files (App, Constants, Routes, Autoload, Database)
4. `TASK 3` — Create `AuthFilter`
5. `TASK 7` — Migrate Libraries (Twilio, Amazon, PasswordHash, FeedParser)
6. `TASK 6` — Migrate Helper (`utility_helper.php`)
7. `TASK 5` — Migrate all 13 Models
8. `TASK 4` — Migrate all 13 Controllers
9. `TASK 8` — Copy and update all Views
10. `TASK 10` — Add `ci_sessions` table SQL to `database/schema.sql`
11. `TASK 11` — Write `.htaccess` files
12. `TASK 12` — Update `composer.json` and run `composer install`
13. `TASK 13` — Configure email
14. `TASK 14` — Create CI4 error pages
15. `TASK 15` — Remove CI3 artifacts
16. `PHASE 3` — Run the testing checklist
