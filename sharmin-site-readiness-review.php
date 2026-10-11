<?php
/**
 * Plugin Name: Sharmin Site Readiness Review
 * Description: Check whether your WordPress website is ready to launch with a simple site-readiness checklist.
 * Version: 1.0.0
 * Requires at least: 6.5
 * Requires PHP: 7.4
 * Author: Sharmin Oomatia
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: sharmin-site-readiness-review
 *
 * @package SharminSiteReadinessReview
 */

// Prevent direct access to this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// Plugin version.
define( 'SLC_VERSION', '1.0.0' );


// Load the site check functions.
require_once plugin_dir_path( __FILE__ ) . 'includes/checks.php';


// Load the WordPress admin page.
require_once plugin_dir_path( __FILE__ ) . 'admin/admin-page.php';