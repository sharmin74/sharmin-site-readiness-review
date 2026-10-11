<?php

// Prevent direct access to this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// Check if search engines are allowed to index the website.
function slc_check_search_engine_visibility() {
	$blog_public = get_option( 'blog_public' );

	if ( '1' === $blog_public ) {
		return array(
			'status'  => 'pass',
			'title'   => __( 'Search Engine Visibility', 'sharmin-site-readiness-review' ),
			'message' => __( 'Search engines are allowed to index this website.', 'sharmin-site-readiness-review' ),
		);
	}

	return array(
		'status'  => 'warning',
		'title'   => __( 'Search Engine Visibility', 'sharmin-site-readiness-review' ),
		'message' => __( 'Search engines are currently discouraged from indexing this website.', 'sharmin-site-readiness-review' ),
	);
}


// Check whether WP_DEBUG is enabled.
function slc_check_wp_debug() {
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		return array(
			'status'  => 'warning',
			'title'   => __( 'Debug Mode', 'sharmin-site-readiness-review' ),
			'message' => __( 'WP_DEBUG is enabled. Consider disabling it before launching the website.', 'sharmin-site-readiness-review' ),
		);
	}

	return array(
		'status'  => 'pass',
		'title'   => __( 'Debug Mode', 'sharmin-site-readiness-review' ),
		'message' => __( 'WP_DEBUG is disabled.', 'sharmin-site-readiness-review' ),
	);
}


// Check whether the website is using HTTPS.
function slc_check_ssl() {
	if ( is_ssl() ) {
		return array(
			'status'  => 'pass',
			'title'   => __( 'HTTPS / SSL', 'sharmin-site-readiness-review' ),
			'message' => __( 'This website is using HTTPS.', 'sharmin-site-readiness-review' ),
		);
	}

	return array(
		'status'  => 'fail',
		'title'   => __( 'HTTPS / SSL', 'sharmin-site-readiness-review' ),
		'message' => __( 'This website is not using HTTPS. Enable SSL before launching.', 'sharmin-site-readiness-review' ),
	);
}


// Check whether the site title and tagline are configured.
function slc_check_site_identity() {
	$site_title = get_option( 'blogname' );
	$tagline    = get_option( 'blogdescription' );

	if ( empty( $site_title ) ) {
		return array(
			'status'  => 'fail',
			'title'   => __( 'Site Title & Tagline', 'sharmin-site-readiness-review' ),
			'message' => __( 'Your site title is empty. Add a site title before launching.', 'sharmin-site-readiness-review' ),
		);
	}

	if ( empty( $tagline ) ) {
		return array(
			'status'  => 'warning',
			'title'   => __( 'Site Title & Tagline', 'sharmin-site-readiness-review' ),
			'message' => __( 'Your site title is set, but the tagline is empty.', 'sharmin-site-readiness-review' ),
		);
	}

	return array(
		'status'  => 'pass',
		'title'   => __( 'Site Title & Tagline', 'sharmin-site-readiness-review' ),
		'message' => __( 'Your site title and tagline are configured.', 'sharmin-site-readiness-review' ),
	);
}


// Check whether a site icon/favicon is configured.
function slc_check_site_icon() {
	if ( has_site_icon() ) {
		return array(
			'status'  => 'pass',
			'title'   => __( 'Site Icon', 'sharmin-site-readiness-review' ),
			'message' => __( 'A site icon is configured.', 'sharmin-site-readiness-review' ),
		);
	}

	return array(
		'status'  => 'warning',
		'title'   => __( 'Site Icon', 'sharmin-site-readiness-review' ),
		'message' => __( 'No site icon is configured.', 'sharmin-site-readiness-review' ),
	);
}


// Check whether a custom permalink structure is being used.
function slc_check_permalinks() {
	$permalink_structure = get_option( 'permalink_structure' );

	if ( empty( $permalink_structure ) ) {
		return array(
			'status'  => 'warning',
			'title'   => __( 'Permalink Structure', 'sharmin-site-readiness-review' ),
			'message' => __( 'The site is using plain permalinks. Consider using a more descriptive permalink structure.', 'sharmin-site-readiness-review' ),
		);
	}

	return array(
		'status'  => 'pass',
		'title'   => __( 'Permalink Structure', 'sharmin-site-readiness-review' ),
		'message' => __( 'A custom permalink structure is configured.', 'sharmin-site-readiness-review' ),
	);
}


// Check whether a privacy policy page is configured.
function slc_check_privacy_policy() {
	$privacy_policy_url = get_privacy_policy_url();

	if ( empty( $privacy_policy_url ) ) {
		return array(
			'status'  => 'warning',
			'title'   => __( 'Privacy Policy', 'sharmin-site-readiness-review' ),
			'message' => __( 'No privacy policy page is configured.', 'sharmin-site-readiness-review' ),
		);
	}

	return array(
		'status'  => 'pass',
		'title'   => __( 'Privacy Policy', 'sharmin-site-readiness-review' ),
		'message' => __( 'A privacy policy page is configured.', 'sharmin-site-readiness-review' ),
	);
}


// Check whether a static homepage is configured.
function slc_check_homepage() {
	$show_on_front = get_option( 'show_on_front' );

	if ( 'page' === $show_on_front ) {
		return array(
			'status'  => 'pass',
			'title'   => __( 'Homepage', 'sharmin-site-readiness-review' ),
			'message' => __( 'A static homepage is configured.', 'sharmin-site-readiness-review' ),
		);
	}

	return array(
		'status'  => 'warning',
		'title'   => __( 'Homepage', 'sharmin-site-readiness-review' ),
		'message' => __( 'The homepage is currently displaying the latest posts.', 'sharmin-site-readiness-review' ),
	);
}


// Return all site-readiness checks.
function slc_get_checks() {
	return array(
		slc_check_search_engine_visibility(),
		slc_check_wp_debug(),
		slc_check_ssl(),
		slc_check_site_identity(),
		slc_check_site_icon(),
		slc_check_permalinks(),
		slc_check_privacy_policy(),
		slc_check_homepage(),
	);
}