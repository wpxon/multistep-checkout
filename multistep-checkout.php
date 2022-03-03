<?php
/**
 * Plugin Name: MultiStep Checkout
 * Plugin URI:  https://wpxon.com/plugins/multistep-checkout
 * Description: A MultiStep Checkout plugin for WooCommerce.
 * Author:      WPxon
 * Author URI:  https://wpxon.com
 * Version:     1.0.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Tags: multistep checkout, multi step checkout, woocommerce multistep checkout,  woocommerce multi step checkout, WooCommerce checkout steps
 * Text Domain: multistep-checkout
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class MultiStep_Checkout {

	/**
	 * plugin version
	 *
	 * @var string
	 */
	const version = '1.0.0';

	/**
	 * Class constructor
	 */
	function __construct() {
		$this->define_constants();
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'settings_action' ) ); 
		add_filter( 'woocommerce_locate_template', array( $this, 'load_checkout_template' ), 10, 3 );

	}

	/**
	 * Initializes a singletone instance
	 *
	 * @return \MultiStep_Checkout
	 */
	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Define the required plugin constants
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'MSC_VERSION', self::version );
		define( 'MSC_FILE', __FILE__ );
		define( 'MSC_PATH', __DIR__ );
		define( 'MSC_URL', plugins_url( '', MSC_FILE ) );
		define( 'MSC_ASSETS', MSC_URL . '/assets' );
	}


	public function init_plugin() {

		$this->woo_actions();

		new MultiStep_Checkout\Assets();

		if ( is_admin() ) {
			new MultiStep_Checkout\Admin();
		}
	}

	/**
	 * Do stuff uplon plugin activation
	 *
	 * @return void
	 */
	public function activate() {
		// save version.
		$installed = get_option( 'msc_installed' );
		if ( ! $installed ) {
			update_option( 'msc_installed', time() );
		}
		update_option( 'msc_version', MSC_VERSION ); 
	}

	/**
	 * Add settings page link to plugin action row
	 *
	 * @return void
	 */
	public function settings_action( $links ) {
		$settings_link = '<a href="admin.php?page=multistep-checkout">Settings</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}

	/**
	 * Load checkout template
	 */
	public function load_checkout_template( $template, $template_name, $template_path ) {

		if ( 'checkout/form-checkout.php' == $template_name ) {

			$template = MSC_PATH . '/woocommerce/checkout/form-checkout.php';

		}

		return $template;
	}

	public function woo_actions() {
		remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
		add_action( 'woocommerce_checkout_after_order_review', 'woocommerce_checkout_payment', 20 );
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
	}
}

/**
 * Initializes the main plugin
 *
 * @return \MultiStep_Checkout
 */
function multistep_checkout() {
	return MultiStep_Checkout::init();
}

// kick-off the plugin
multistep_checkout();
