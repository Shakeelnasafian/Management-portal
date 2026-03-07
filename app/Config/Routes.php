<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Management');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(true);
$routes->set404Override();
$routes->setAutoRoute(true);

// Explicit routes for core controllers
$routes->get('/', 'Management::index');
$routes->get('management', 'Management::index');
$routes->post('management/date_searching', 'Management::date_searching');

$routes->get('campaign', 'Campaign::index');
$routes->get('campaign/active', 'Campaign::active_campaigns');
$routes->get('campaign/completed', 'Campaign::completed_campaigns');
$routes->get('campaign/socialmedia', 'Campaign::socialmedia_dashboard');
$routes->get('campaign/operations', 'Campaign::operations_dashboard');
$routes->get('campaign/graphics', 'Campaign::graphics_dashboard');

$routes->get('operations/create', 'Operations::create_pressrelease');
$routes->post('operations/create', 'Operations::create_pressrelease');
$routes->get('operations/draft', 'Operations::draft_dashboard');
$routes->get('operations/pending', 'Operations::pending_dashboard');
$routes->get('operations/published', 'Operations::published_dashboard');
$routes->get('operations/schedule', 'Operations::schedule_dashboard');
$routes->get('operations/trashed', 'Operations::trashed_dashboard');

$routes->get('pressrelease/verified', 'Pressrelease::verified_prs');
$routes->get('pressrelease/unverified', 'Pressrelease::none_verified_prs');

$routes->get('coupon', 'Coupon::icn_coupons');
$routes->get('coupon/expired', 'Coupon::expired_coupons');
$routes->get('coupon/add', 'Coupon::add_coupon');
$routes->post('coupon/add', 'Coupon::add_coupon');

$routes->get('sales', 'Sales::pressreleases');
$routes->get('sales/coupons', 'Sales::coupons');
$routes->get('sales/credits', 'Sales::user_credits');

$routes->get('kiosk-users/search', 'KioskUsers::search_user');
$routes->post('kiosk-users/find', 'KioskUsers::find_user');

$routes->get('reporting', 'Reporting::dashboard');
$routes->get('reporting/add', 'Reporting::add_report');
$routes->post('reporting/add', 'Reporting::add_report');

$routes->get('search-engine', 'SearchEngine::find_pressrelease');
$routes->post('search-engine', 'SearchEngine::find_pressrelease');

$routes->get('utility', 'Utility::pr_media_sites_links');
$routes->get('rssfeed', 'Rssfeed::read_rss_feed');
$routes->get('zoho/sync/(:any)', 'Zohosync::sync_icrowd_users_zoho/$1');

$routes->get('users/login', 'Users::login');
$routes->post('users/login', 'Users::login');
$routes->get('users/logout', 'Users::logout');
$routes->get('users/forgot-password', 'Users::forgot_password');
$routes->post('users/forgot-password', 'Users::forgot_password');
$routes->get('users/edit-profile/(:num)', 'Users::edit_profile/$1');
