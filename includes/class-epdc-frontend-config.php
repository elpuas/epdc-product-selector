<?php
/**
 * Frontend settings exposure.
 *
 * @package EPDC_Product_Selector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPDC_Frontend_Config {

	/**
	 * Register hooks.
	 *
	 * @param EPDC_Plugin_Loader $loader Hook loader.
	 */
	public function register( EPDC_Plugin_Loader $loader ): void {
		$loader->add_action( 'wp_enqueue_scripts', $this, 'expose_config' );
	}

	/**
	 * Expose plugin config to frontend JavaScript.
	 *
	 * @return void
	 */
	public function expose_config(): void {
		if ( ! wp_script_is( 'epdc-product-selector-form', 'registered' ) ) {
			return;
		}

		$config = [
			'inquiryUrl'    => esc_url_raw( EPDC_Settings::get_inquiry_page_url() ),
			'fieldSelector' => EPDC_Settings::get_inquiry_field_selector(),
		];

		$inline_script = 'window.EPDCProductSelectorConfig = ' . wp_json_encode( $config ) . ';';
		wp_add_inline_script( 'epdc-product-selector-form', $inline_script, 'before' );
	}
}
