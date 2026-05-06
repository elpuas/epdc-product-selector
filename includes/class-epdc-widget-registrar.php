<?php
/**
 * Floating widget registration.
 *
 * @package EPDC_Product_Selector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPDC_Widget_Registrar {

	/**
	 * Register hooks.
	 *
	 * @param EPDC_Plugin_Loader $loader Hook loader.
	 */
	public function register( EPDC_Plugin_Loader $loader ): void {
		$loader->add_action( 'wp_footer', $this, 'render_widget_mount_point' );
	}

	/**
	 * Render global mount point for inquiry widget.
	 */
	public function render_widget_mount_point(): void {
		echo '<div id="epdc-product-selector-widget" data-epdc-widget="1"></div>';
	}
}
