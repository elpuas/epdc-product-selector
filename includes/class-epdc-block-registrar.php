<?php
/**
 * Dynamic block registration.
 *
 * @package EPDC_Product_Selector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPDC_Block_Registrar {

	/**
	 * Register hooks.
	 *
	 * @param EPDC_Plugin_Loader $loader Hook loader.
	 */
	public function register( EPDC_Plugin_Loader $loader ): void {
		$loader->add_action( 'init', $this, 'register_blocks' );
	}

	/**
	 * Register plugin dynamic blocks.
	 *
	 * @return void
	 */
	public function register_blocks(): void {
		register_block_type( EPDC_PRODUCT_SELECTOR_BLOCK_PATH . 'product-selector' );
	}
}
