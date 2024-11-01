<?php

/**
 * Plugin Name: WooCommerce Arabic
 * Plugin URI: https://twitter.com/WooCommerceAR
 * Description: Adds completed & proper Arabic translation to WooCommerce in addition to some missing GCC currencies.
 * Version: 1.0.3
 * Author: Abdullah Helayel
 * Author URI: http://updu.la/
 * Text Domain: wc_ar
 * Domain Path: /languages/
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

  /**
   * Add GCC currencies
   */
  add_filter( 'woocommerce_currencies', 'wc_ar_currencies' );

  function wc_ar_currencies( $currencies ) {
    $currencies['BHD'] = __( 'Bahraini Dinar', 'wc_ar' );
    $currencies['KWD'] = __( 'Kuwaiti Dinar', 'wc_ar' );
    $currencies['OMR'] = __( 'Omani Rial', 'wc_ar' );
    $currencies['QAR'] = __( 'Qatari Riyal', 'wc_ar' );
    $currencies['SAR'] = __( 'Saudi Riyal', 'wc_ar' );
    return $currencies;
  }

  add_filter('woocommerce_currency_symbol', 'wc_ar_currencies_symbol', 10, 2);

  function wc_ar_currencies_symbol( $currency_symbol, $currency ) {
    switch( $currency ) {
      case 'BHD': $currency_symbol = __( 'BHD', 'wc_ar' ); break;
      case 'KWD': $currency_symbol = __( 'KWD', 'wc_ar' ); break;
      case 'OMR': $currency_symbol = __( 'OMR', 'wc_ar' ); break;
      case 'QAR': $currency_symbol = __( 'QAR', 'wc_ar' ); break;
      case 'SAR': $currency_symbol = __( 'SAR', 'wc_ar' ); break;
    }
    return $currency_symbol;
  }


  /**
   * Load Arabic translation from plugin directory
   */
  add_action( 'plugins_loaded', 'wc_ar_translation' );

  function wc_ar_translation() {

    // Get current language
    $locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce' );

    // Load WooCommerce admin translation
    if ( is_admin() ) {
      load_textdomain( 'woocommerce', plugin_dir_path( __FILE__ ) . 'languages/woocommerce-admin-' . $locale . '.mo' );
    }

    // Load main WooCommerce translation
    load_textdomain( 'woocommerce', plugin_dir_path( __FILE__ ) . 'languages/woocommerce-' . $locale . '.mo' );

    // Load this plugin translation
    load_plugin_textdomain( 'wc_ar', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

  }


} // End of WooCommerce check
