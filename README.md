# ICN Management Portal

An internal management portal for iCrowd, built with **CodeIgniter 4**. It handles campaigns, press releases, kiosk users, sales reporting, RSS feeds, search engine management, coupon management, and Zoho CRM synchronization.

## Requirements

- PHP 8.1+
- MySQL 5.7+ or MariaDB 10.3+
- Composer

## Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/shakeelnasafian/management-portal.git
cd management-portal
```

### 2. Install dependencies

```bash
composer install
```

### 3. Configure environment

Copy the example environment file and update it with your settings:

```bash
cp env .env
```

Edit `.env` and set at minimum:

```
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = icn_management
database.default.username = your_db_user
database.default.password = your_db_password
database.default.DBDriver = MySQLi
```

### 4. Set up the database

Create the database, then import the schema:

```bash
mysql -u your_db_user -p icn_management < database/schema.sql
```

### 5. Configure third-party services

Set the following in your `.env` file as needed:

- **Twilio** – SMS/phone verification
- **AWS** – Cloud services (S3, etc.)

### 6. Run the application

```bash
php spark serve
```

The portal will be available at `http://localhost:8080`.

## Project Structure

```
app/
├── Controllers/      # Route handlers
│   ├── Campaign.php
│   ├── Coupon.php
│   ├── KioskUsers.php
│   ├── Management.php
│   ├── Operations.php
│   ├── Pressrelease.php
│   ├── Reporting.php
│   ├── Rssfeed.php
│   ├── Sales.php
│   ├── SearchEngine.php
│   ├── Users.php
│   ├── Utility.php
│   └── Zohosync.php
├── Models/           # Database models
├── Views/            # Templates
├── Helpers/          # Custom helpers
├── Filters/          # Auth / middleware filters
└── Libraries/        # Custom libraries
database/
└── schema.sql        # Full database schema
```

## Key Features

| Module | Description |
|---|---|
| Campaigns | Create and manage marketing campaigns |
| Press Releases | Draft, schedule, and publish press releases |
| Kiosk Users | Manage kiosk-specific user accounts |
| Sales | Sales tracking and reporting |
| Reporting | Data reports and analytics |
| RSS Feeds | Manage and distribute RSS content |
| Search Engine | Search engine configuration and management |
| Coupons | Coupon creation and redemption tracking |
| Zoho Sync | Sync records with Zoho CRM |
| Users | Staff and admin account management |

## Dependencies

| Package | Purpose |
|---|---|
| `codeigniter4/framework` ^4.5 | MVC framework |
| `twilio/sdk` ^8.0 | SMS and voice services |
| `aws/aws-sdk-php` ^3.0 | AWS cloud services |

## Contributing

See [contributing.md](contributing.md) for coding standards and pull request guidelines.

## License

See [license.txt](license.txt).
