<?php
/**
 * Inquiry form integration registration.
 *
 * @package EPDC_Product_Selector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPDC_Inquiry_Form_Integrator {

	/**
	 * Register hooks.
	 *
	 * @param EPDC_Plugin_Loader $loader Hook loader.
	 */
	public function register( EPDC_Plugin_Loader $loader ): void {
		$loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_form_integration_asset' );
	}

	/**
	 * Enqueue form integration scaffold script.
	 */
	public function enqueue_form_integration_asset(): void {
		wp_enqueue_script( 'epdc-product-selector-form' );
	}
}
