<?php 

	/**
	 * @link              https://metinsarac.net/
	 * @since           1.0.0
	 * @package      Wordpress_Code_Checker
	 *
	 * @wordpress-plugin
	 * Plugin Name:     Wordpress Code Checker
	 * Plugin URI:        https://metinsarac.net/wcc-test/
	 * Description:       Wordpress - Code Checker
	 * Version:            1.0.0
	 * Author:              Metin Saraç
	 * Author URI:        https://metinsarac.net/
	 * License:            GPL-3.0+
	 * License URI:      http://www.gnu.org/licenses/gpl-3.0.txt
	 * Text Domain:      wcchecker
	 * Domain Path:      /languages
	*/

// If this file is called directly, abort.

if ( ! defined( 'WPINC' ) ) {
	die;
}

// Hook

register_deactivation_hook( __FILE__, 'wcchecker_deactivate' );
register_activation_hook( __FILE__, 'wcchecker_activate' );

// Define Our Constants

define('wcchecker_CORE_ADMIN',dirname( __FILE__ ).'/admin/');
define('wcchecker_CORE_INC',dirname( __FILE__ ).'/inc/');
define('wcchecker_CORE_CSS',plugins_url( 'assets/css/', __FILE__ ));
define('wcchecker_CORE_JS',plugins_url( 'assets/js/', __FILE__ ));

// Register Css

function wcchecker_register_core_css(){

	wp_enqueue_style('wcchecker-core', wcchecker_CORE_CSS . 'wcchecker-core.css',null,time(),'all');

}

add_action( 'wp_enqueue_scripts', 'wcchecker_register_core_css' ); 
  
// Load plugin textdomain.

function wcchecker_load_textdomain() {

  load_plugin_textdomain( 'wcchecker', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 

}

add_action( 'init', 'wcchecker_load_textdomain' );

// Let's Start

if ( file_exists( wcchecker_CORE_ADMIN . 'admin.php' ) ) {
	require_once wcchecker_CORE_ADMIN . 'admin.php';
}    

if ( file_exists( wcchecker_CORE_INC . 'functions.php' ) ) {
	require_once wcchecker_CORE_INC . 'functions.php';
}    

if ( file_exists( wcchecker_CORE_INC . 'post-type.php' ) ) {
	require_once wcchecker_CORE_INC . 'post-type.php';
}    

if ( file_exists( wcchecker_CORE_INC . 'shortcode.php' ) ) {
	require_once wcchecker_CORE_INC . 'shortcode.php';
}    

if ( file_exists( wcchecker_CORE_INC . 'metabox.php' ) ) {
	require_once wcchecker_CORE_INC . 'metabox.php';
}    

// Deactivation Delete All Options

function wcchecker_deactivate() {
	delete_option('wcc_options');
}

// Activation All Options

function wcchecker_activate() {

	$options = array(
		'placeholder_value' => 'Secure Code',
		'send_button_value' => 'Check',
		'success_value' => 'The Code is Valid.',
		'error_value' => 'The Code is Not Valid.',
		'expired_time' => 'The Code Has Expired.',
		'pending_time' => 'The code is valid for a certain period of time.',
	);

	update_option( 'wcc_options',$options); 

}