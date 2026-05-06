<?php
/**
 * Frontend asset registration.
 *
 * @package EPDC_Product_Selector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPDC_Asset_Registrar {

	/**
	 * Register hooks.
	 *
	 * @param EPDC_Plugin_Loader $loader Hook loader.
	 */
	public function register( EPDC_Plugin_Loader $loader ): void {
		$loader->add_action( 'wp_enqueue_scripts', $this, 'register_assets' );
	}

	/**
	 * Register scaffold assets for future feature modules.
	 */
	public function register_assets(): void {
		wp_register_script(
			'epdc-product-selector-store',
			EPDC_PRODUCT_SELECTOR_URL . 'assets/js/store.js',
			[],
			EPDC_PRODUCT_SELECTOR_VERSION,
			true
		);

		wp_register_script(
			'epdc-product-selector-form',
			EPDC_PRODUCT_SELECTOR_URL . 'assets/js/form.js',
			[],
			EPDC_PRODUCT_SELECTOR_VERSION,
			true
		);

		wp_register_style(
			'epdc-product-selector-frontend',
			EPDC_PRODUCT_SELECTOR_URL . 'assets/css/frontend.css',
			[],
			EPDC_PRODUCT_SELECTOR_VERSION
		);
	}
}
