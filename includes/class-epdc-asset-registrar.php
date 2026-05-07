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
		$loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_store_module' );
		$loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_frontend_style' );
	}

	/**
	 * Register scaffold assets for future feature modules.
	 */
	public function register_assets(): void {
		if ( function_exists( 'wp_register_script_module' ) ) {
			wp_register_script_module(
				'epdc-product-selector-store',
				EPDC_PRODUCT_SELECTOR_URL . 'assets/js/store.js',
				[ '@wordpress/interactivity' ],
				EPDC_PRODUCT_SELECTOR_VERSION
			);
		} else {
			wp_register_script(
				'epdc-product-selector-store',
				EPDC_PRODUCT_SELECTOR_URL . 'assets/js/store.js',
				[],
				EPDC_PRODUCT_SELECTOR_VERSION,
				true
			);
		}

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

	/**
	 * Enqueue the Interactivity API store module on the frontend.
	 */
	public function enqueue_store_module(): void {
		if ( function_exists( 'wp_enqueue_script_module' ) ) {
			wp_enqueue_script_module( 'epdc-product-selector-store' );
			return;
		}

		wp_enqueue_script( 'epdc-product-selector-store' );
	}

	/**
	 * Enqueue frontend styles for block and floating widget.
	 */
	public function enqueue_frontend_style(): void {
		wp_enqueue_style( 'epdc-product-selector-frontend' );
	}
}
