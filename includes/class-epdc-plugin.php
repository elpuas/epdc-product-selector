<?php
/**
 * Main plugin orchestrator.
 *
 * @package EPDC_Product_Selector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPDC_Plugin {

	/**
	 * Hook loader.
	 *
	 * @var EPDC_Plugin_Loader
	 */
	private EPDC_Plugin_Loader $loader;

	/**
	 * Initialize plugin dependencies.
	 */
	public function __construct() {
		$this->loader = new EPDC_Plugin_Loader();
		$this->register_hooks();
	}

	/**
	 * Register all plugin hooks in one place.
	 */
	private function register_hooks(): void {
		$asset_registrar = new EPDC_Asset_Registrar();
		$block_registrar = new EPDC_Block_Registrar();
		$widget_registrar = new EPDC_Widget_Registrar();
		$form_integrator = new EPDC_Inquiry_Form_Integrator();
		$settings_page = new EPDC_Settings_Page();
		$frontend_config = new EPDC_Frontend_Config();

		$asset_registrar->register( $this->loader );
		$block_registrar->register( $this->loader );
		$widget_registrar->register( $this->loader );
		$form_integrator->register( $this->loader );
		$settings_page->register( $this->loader );
		$frontend_config->register( $this->loader );
	}

	/**
	 * Boot registered hooks.
	 */
	public function run(): void {
		$this->loader->run();
	}
}
