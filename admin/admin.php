<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'wccheckerAdmin' ) ) {

	class wccheckerAdmin {

		/**
		 * Start things up
		 *
		 * @since 1.0.0
		 */

		public function __construct() {

			// We only need to register the admin panel on the back-end

			if ( is_admin() ) {
				add_action( 'admin_menu', array( 'wccheckerAdmin', 'add_admin_menu' ) );
				add_action( 'admin_init', array( 'wccheckerAdmin', 'register_settings' ) );
			}

		}

		/**
		 * Returns all theme options
		 *
		 * @since 1.0.0
		 */

		public static function get_wcc_options() {
			return get_option( 'wcc_options' );
		}

		/**
		 * Returns single theme option
		 *
		 * @since 1.0.0
		 */

		public static function get_theme_option( $id ) {
			$options = self::get_wcc_options();
			if ( isset( $options[$id] ) ) {
				return $options[$id];
			}
		}

		/**
		 * Add sub menu page
		 *
		 * @since 1.0.0
		 */

		public static function add_admin_menu() {
			add_menu_page(
				esc_html__( 'wcChecker', 'wcchecker' ),
				esc_html__( 'wcChecker', 'wcchecker' ),
				'manage_options',
				'wc-checker',
				array( 'wccheckerAdmin', 'create_admin_page' ),
				'dashicons-post-status'
			);
			add_submenu_page( 
				'wc-checker',
				esc_html__( 'Security Code(s)', 'wcchecker' ),
				esc_html__( 'Security Code(s)', 'wcchecker' ),
				'manage_options',
				'edit.php?post_type=sc'
			);
			add_submenu_page( 
				'wc-checker',
				esc_html__( 'Install Demo', 'wcchecker' ),
				esc_html__( 'Install Demo', 'wcchecker' ),
				'manage_options',
				'install_demo',
				'wccheckerDemoContent'
			);
		}

		/**
		 * Register a setting and its sanitization callback.
		 *
		 * We are only registering 1 setting so we can store all options in a single option as
		 * an array. You could, however, register a new setting for each option
		 *
		 * @since 1.0.0
		 */

		public static function register_settings() {
			register_setting( 'wcc_options', 'wcc_options', array( 'wccheckerAdmin', 'sanitize' ) );
		}

		/**
		 * Sanitization callback
		 *
		 * @since 1.0.0
		 */

		public static function sanitize( $options ) {

			// If we have options lets sanitize them

			if ( $options ) {

				// Checkbox
				if ( ! empty( $options['checkbox_example'] ) ) {
					$options['checkbox_example'] = 'on';
				} else {
					unset( $options['checkbox_example'] ); // Remove from options if not checked
				}

				// Input
				if ( ! empty( $options['input_example'] ) ) {
					$options['input_example'] = sanitize_text_field( $options['input_example'] );
				} else {
					unset( $options['input_example'] ); // Remove from options if empty
				}

				// Select
				if ( ! empty( $options['select_example'] ) ) {
					$options['select_example'] = sanitize_text_field( $options['select_example'] );
				}

			}

			// Return sanitized options
			return $options;

		}

		/**
		 * Settings page output
		 *
		 * @since 1.0.0
		 */

		public static function create_admin_page() { ?>

			<div class="wrap">

				<h1><?php esc_html_e( 'Plugin Settings', 'wcchecker' ); ?></h1>

				<form method="post" action="options.php">

					<?php settings_fields( 'wcc_options' ); ?>

					<table class="form-table">
					
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Placeholder Text', 'wcchecker' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'placeholder_value' ); ?>
								<input type="text" name="wcc_options[placeholder_value]" placeholder="<?php esc_html_e( 'Secure Code', 'wcchecker' ); ?>"  value="<?php echo esc_attr( $value ); ?>">
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Check Button Text', 'wcchecker' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'send_button_value' ); ?>
								<input type="text" name="wcc_options[send_button_value]" placeholder="<?php esc_html_e( 'Check', 'wcchecker' ); ?>" value="<?php echo esc_attr( $value ); ?>">
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Successful Result Text', 'wcchecker' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'success_value' ); ?>
								<input type="text" name="wcc_options[success_value]" placeholder="<?php esc_html_e( 'The code is valid.', 'wcchecker' ); ?>" value="<?php echo esc_attr( $value ); ?>">
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Incorrect Result Text', 'wcchecker' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'error_value' ); ?>
								<input type="text" name="wcc_options[error_value]" placeholder="<?php esc_html_e( 'The code is not valid.', 'wcchecker' ); ?>" value="<?php echo esc_attr( $value ); ?>">
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Expire Date Text', 'wcchecker' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'expired_time' ); ?>
								<input type="text" name="wcc_options[expired_time]" placeholder="<?php esc_html_e( 'The code has expired.', 'wcchecker' ); ?>" value="<?php echo esc_attr( $value ); ?>">
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Pending Result Text', 'wcchecker' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'pending_time' ); ?>
								<input type="text" name="wcc_options[pending_time]" placeholder="<?php esc_html_e( 'The code is valid for a certain period of time.', 'wcchecker' ); ?>" value="<?php echo esc_attr( $value ); ?>">
							</td>
						</tr>

					</table>

					<?php submit_button(); ?>

				</form>

				<tr valign="top">
					<th scope="row"><?php esc_html_e( 'Shortcode', 'wcchecker' ); ?></th>
					<td>
						<code>[wcchecker]</code>
					</td>
				</tr>

			</div><!-- .wrap -->
		<?php }

	}
}
new wccheckerAdmin();

function wcchecker( $id = '' ) {
	return wccheckerAdmin::get_theme_option( $id );
}