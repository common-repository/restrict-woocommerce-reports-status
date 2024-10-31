<?php
/**
 * Plugin Name: Restrict WooCommerce Reports Status
 * Description: Make WooCommerce consider only "Completed" and "Processing" status for reports, not "On Hold"
 * Author: Fernando Acosta
 * Author URI: https://fernandoacosta.net
 * Version: 1.0.0
 * License: GPLv2 or later
 * Text Domain: restrict-woocommerce-reports-status
 * WC requires at least: 3.0.0
 * WC tested up to:      3.4.0
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
 * Restrict_WC_Reports_Status main class.
 *
 * @package  Restrict_WC_Reports_Status
 * @category Core
 * @author   Fernando Acosta
 */
class Restrict_WC_Reports_Status {
  /**
   * Plugin version.
   *
   * @var string
   */
  const VERSION = '1.0.0';

  /**
   * Instance of this class.
   *
   * @var object
   */
  protected static $instance = null;

  /**
   * Initialize the plugin.
   */
  private function __construct() {
    // Load plugin text domain.
    add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

    // apply rules
    add_filter( 'woocommerce_reports_order_statuses', array( $this, 'reports_statuses' ) );
  }

  /**
   * Return an instance of this class.
   *
   * @return object A single instance of this class.
   */
  public static function get_instance() {
    if ( null == self::$instance ) {
      self::$instance = new self;
    }

    return self::$instance;
  }

  /**
   * Load the plugin text domain for translation.
   */
  public function load_plugin_textdomain() {
    load_plugin_textdomain( 'restrict-woocommerce-reports-status', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
  }

  public function reports_statuses() {
    return array( 'completed', 'processing' );
  }
}

/**
 * Init the plugin.
 */
add_action( 'plugins_loaded', array( 'Restrict_WC_Reports_Status', 'get_instance' ) );
