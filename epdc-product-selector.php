<?php
/**
 * Plugin Name: EPDC Product Selector
 * Plugin URI:  https://github.com/elpuas/epdc-product-selector
 * Description: Product inquiry selection scaffold for catalog-based WordPress websites.
 * Version:     1.0.1
 * Author:      ElPuas Digital Crafts
 * Text Domain: epdc-product-selector
 * Domain Path: /languages
 *
 * @package EPDC_Product_Selector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'EPDC_PRODUCT_SELECTOR_VERSION' ) ) {
	define( 'EPDC_PRODUCT_SELECTOR_VERSION', '1.0.1' );
}

if ( ! defined( 'EPDC_PRODUCT_SELECTOR_PATH' ) ) {
	define( 'EPDC_PRODUCT_SELECTOR_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'EPDC_PRODUCT_SELECTOR_URL' ) ) {
	define( 'EPDC_PRODUCT_SELECTOR_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'EPDC_PRODUCT_SELECTOR_BLOCK_PATH' ) ) {
	define( 'EPDC_PRODUCT_SELECTOR_BLOCK_PATH', EPDC_PRODUCT_SELECTOR_PATH . 'blocks/' );
}

require_once EPDC_PRODUCT_SELECTOR_PATH . 'includes/class-epdc-plugin-loader.php';
require_once EPDC_PRODUCT_SELECTOR_PATH . 'includes/class-epdc-asset-registrar.php';
require_once EPDC_PRODUCT_SELECTOR_PATH . 'includes/class-epdc-block-registrar.php';
require_once EPDC_PRODUCT_SELECTOR_PATH . 'includes/class-epdc-widget-registrar.php';
require_once EPDC_PRODUCT_SELECTOR_PATH . 'includes/class-epdc-inquiry-form-integrator.php';
require_once EPDC_PRODUCT_SELECTOR_PATH . 'includes/class-epdc-settings.php';
require_once EPDC_PRODUCT_SELECTOR_PATH . 'includes/class-epdc-settings-page.php';
require_once EPDC_PRODUCT_SELECTOR_PATH . 'includes/class-epdc-frontend-config.php';
require_once EPDC_PRODUCT_SELECTOR_PATH . 'includes/class-epdc-plugin.php';

add_action(
	'plugins_loaded',
	static function () {
		$plugin = new EPDC_Plugin();
		$plugin->run();
	}
);
