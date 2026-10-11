<?php

// Prevent direct access to this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// Run our menu registration function when WordPress builds the admin menu.
add_action( 'admin_menu', 'slc_add_admin_menu' );


// Load plugin admin assets.
add_action( 'admin_enqueue_scripts', 'slc_enqueue_admin_assets' );


// Add Sharmin Site Readiness Review to the WordPress admin menu.
function slc_add_admin_menu() {
	add_menu_page(
		__( 'Sharmin Site Readiness Review', 'sharmin-site-readiness-review' ),
		__( 'Site Readiness Review', 'sharmin-site-readiness-review' ),
		'manage_options',
		'sharmin-site-readiness-review',
		'slc_render_admin_page',
		'dashicons-yes-alt',
		80
	);
}


// Load CSS and JavaScript only on the Sharmin Site Readiness Review admin page.
function slc_enqueue_admin_assets( $hook ) {

	if ( 'toplevel_page_sharmin-site-readiness-review' !== $hook ) {
		return;
	}

	wp_enqueue_style(
		'slc-admin',
		plugin_dir_url( __FILE__ ) . 'css/admin.css',
		array(),
		SLC_VERSION
	);

	wp_enqueue_script(
		'slc-admin',
		plugin_dir_url( __FILE__ ) . 'js/admin.js',
		array(),
		SLC_VERSION,
		true
	);
}


// Render the Sharmin Site Readiness Review admin page.
function slc_render_admin_page() {

	// Only administrators with the required capability should access this page.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Get all site-readiness check results.
	$checks = slc_get_checks();

	// Count each type of result.
	$passed   = 0;
	$warnings = 0;
	$failed   = 0;

	foreach ( $checks as $check ) {
		switch ( $check['status'] ) {

			case 'pass':
				$passed++;
				break;

			case 'warning':
				$warnings++;
				break;

			case 'fail':
				$failed++;
				break;
		}
	}

	$total = count( $checks );

	// Calculate the percentage of checks that passed.
	$score = $total > 0 ? round( ( $passed / $total ) * 100 ) : 0;

	?>

	<div class="wrap slc-wrap">

		<div class="slc-header">

			<div>
				<h1>
					<?php esc_html_e( 'Sharmin Site Readiness Review', 'sharmin-site-readiness-review' ); ?>
				</h1>

				<p>
					<?php esc_html_e( 'Check your WordPress site before you go live.', 'sharmin-site-readiness-review' ); ?>
				</p>
			</div>

			<div class="slc-score">

				<span class="slc-score-number">
					<?php echo esc_html( $score ); ?>%
				</span>

				<span class="slc-score-label">
					<?php esc_html_e( 'Site Ready', 'sharmin-site-readiness-review' ); ?>
				</span>

			</div>

		</div>


		<div class="slc-summary">

			<div class="slc-summary-item slc-summary-pass">

				<span class="slc-summary-number">
					<?php echo esc_html( $passed ); ?>
				</span>

				<span>
					<?php esc_html_e( 'Passed', 'sharmin-site-readiness-review' ); ?>
				</span>

			</div>


			<div class="slc-summary-item slc-summary-warning">

				<span class="slc-summary-number">
					<?php echo esc_html( $warnings ); ?>
				</span>

				<span>
					<?php esc_html_e( 'Warnings', 'sharmin-site-readiness-review' ); ?>
				</span>

			</div>


			<div class="slc-summary-item slc-summary-fail">

				<span class="slc-summary-number">
					<?php echo esc_html( $failed ); ?>
				</span>

				<span>
					<?php esc_html_e( 'Failed', 'sharmin-site-readiness-review' ); ?>
				</span>

			</div>

		</div>


		<div class="slc-filters">

			<button type="button" class="slc-filter active" data-filter="all">

				<?php esc_html_e( 'All', 'sharmin-site-readiness-review' ); ?>

				<span>
					<?php echo esc_html( $total ); ?>
				</span>

			</button>


			<button type="button" class="slc-filter" data-filter="pass">

				<?php esc_html_e( 'Passed', 'sharmin-site-readiness-review' ); ?>

				<span>
					<?php echo esc_html( $passed ); ?>
				</span>

			</button>


			<button type="button" class="slc-filter" data-filter="warning">

				<?php esc_html_e( 'Warnings', 'sharmin-site-readiness-review' ); ?>

				<span>
					<?php echo esc_html( $warnings ); ?>
				</span>

			</button>


			<button type="button" class="slc-filter" data-filter="fail">

				<?php esc_html_e( 'Failed', 'sharmin-site-readiness-review' ); ?>

				<span>
					<?php echo esc_html( $failed ); ?>
				</span>

			</button>

		</div>


		<div class="slc-checks">

			<?php foreach ( $checks as $check ) : ?>

				<div
					class="slc-check slc-check-<?php echo esc_attr( $check['status'] ); ?>"
					data-status="<?php echo esc_attr( $check['status'] ); ?>"
				>

					<div class="slc-check-icon">

						<?php if ( 'pass' === $check['status'] ) : ?>

							<span class="dashicons dashicons-yes-alt"></span>

						<?php elseif ( 'warning' === $check['status'] ) : ?>

							<span class="dashicons dashicons-warning"></span>

						<?php else : ?>

							<span class="dashicons dashicons-dismiss"></span>

						<?php endif; ?>

					</div>


					<div class="slc-check-content">

						<div class="slc-check-heading">

							<h2>
								<?php echo esc_html( $check['title'] ); ?>
							</h2>


							<span class="slc-status slc-status-<?php echo esc_attr( $check['status'] ); ?>">

								<?php
								if ( 'pass' === $check['status'] ) {
									esc_html_e( 'Pass', 'sharmin-site-readiness-review' );
								} elseif ( 'warning' === $check['status'] ) {
									esc_html_e( 'Warning', 'sharmin-site-readiness-review' );
								} else {
									esc_html_e( 'Fail', 'sharmin-site-readiness-review' );
								}
								?>

							</span>

						</div>


						<p>
							<?php echo esc_html( $check['message'] ); ?>
						</p>

					</div>

				</div>

			<?php endforeach; ?>

		</div>

	</div>

	<?php
}