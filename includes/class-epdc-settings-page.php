<?php
/**
 * Admin settings page.
 *
 * @package EPDC_Product_Selector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPDC_Settings_Page {

	/**
	 * Settings page slug.
	 */
	private const PAGE_SLUG = 'epdc-product-selector';

	/**
	 * Settings section ID.
	 */
	private const SECTION_ID = 'epdc_product_selector_main_section';

	/**
	 * Register hooks.
	 *
	 * @param EPDC_Plugin_Loader $loader Hook loader.
	 */
	public function register( EPDC_Plugin_Loader $loader ): void {
		$loader->add_action( 'admin_menu', $this, 'register_settings_page' );
		$loader->add_action( 'admin_init', $this, 'register_settings' );
	}

	/**
	 * Register submenu page under Settings.
	 */
	public function register_settings_page(): void {
		add_options_page(
			esc_html__( 'EPDC Product Selector', 'epdc-product-selector' ),
			esc_html__( 'EPDC Product Selector', 'epdc-product-selector' ),
			'manage_options',
			self::PAGE_SLUG,
			[ $this, 'render_settings_page' ]
		);
	}

	/**
	 * Register plugin settings.
	 */
	public function register_settings(): void {
		register_setting(
			'epdc_product_selector_settings_group',
			EPDC_Settings::OPTION_KEY,
			[
				'type'              => 'array',
				'sanitize_callback' => [ EPDC_Settings::class, 'sanitize_settings' ],
				'default'           => EPDC_Settings::get_options(),
			]
		);

		add_settings_section(
			self::SECTION_ID,
			esc_html__( 'Inquiry Configuration', 'epdc-product-selector' ),
			'__return_false',
			self::PAGE_SLUG
		);

		add_settings_field(
			'epdc_inquiry_page_id',
			esc_html__( 'Inquiry Page', 'epdc-product-selector' ),
			[ $this, 'render_inquiry_page_field' ],
			self::PAGE_SLUG,
			self::SECTION_ID
		);

		add_settings_field(
			'epdc_inquiry_field_selector',
			esc_html__( 'Form Field Selector', 'epdc-product-selector' ),
			[ $this, 'render_inquiry_field_selector' ],
			self::PAGE_SLUG,
			self::SECTION_ID
		);

		add_settings_field(
			'epdc_primary_color',
			esc_html__( 'Primary Color', 'epdc-product-selector' ),
			[ $this, 'render_primary_color_field' ],
			self::PAGE_SLUG,
			self::SECTION_ID
		);

		add_settings_field(
			'epdc_primary_text_color',
			esc_html__( 'Primary Text Color', 'epdc-product-selector' ),
			[ $this, 'render_primary_text_color_field' ],
			self::PAGE_SLUG,
			self::SECTION_ID
		);
	}

	/**
	 * Render settings page.
	 *
	 * @return void
	 */
	public function render_settings_page(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php echo esc_html__( 'EPDC Product Selector', 'epdc-product-selector' ); ?></h1>
			<p><?php echo esc_html__( 'Configure inquiry behavior and shared UI styles.', 'epdc-product-selector' ); ?></p>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'epdc_product_selector_settings_group' );
				do_settings_sections( self::PAGE_SLUG );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Render inquiry page dropdown.
	 *
	 * @return void
	 */
	public function render_inquiry_page_field(): void {
		$selected_page = EPDC_Settings::get_inquiry_page_id();

		wp_dropdown_pages(
			[
				'name'              => EPDC_Settings::OPTION_KEY . '[inquiry_page_id]',
				'id'                => 'epdc_inquiry_page_id',
				'show_option_none'  => esc_html__( 'Select an inquiry page', 'epdc-product-selector' ),
				'option_none_value' => 0,
				'selected'          => $selected_page,
			]
		);

		echo '<p class="description">' . esc_html__( 'Visitors from the floating widget will be redirected to this page.', 'epdc-product-selector' ) . '</p>';
	}

	/**
	 * Render inquiry field selector input.
	 *
	 * @return void
	 */
	public function render_inquiry_field_selector(): void {
		$selector = EPDC_Settings::get_inquiry_field_selector();
		?>
		<input
			type="text"
			id="epdc_inquiry_field_selector"
			name="<?php echo esc_attr( EPDC_Settings::OPTION_KEY ); ?>[inquiry_field_selector]"
			value="<?php echo esc_attr( $selector ); ?>"
			class="regular-text"
			placeholder=".epdc-product-selection-field"
		/>
		<p class="description"><?php echo esc_html__( 'CSS selector for the inquiry form field that will receive selected products.', 'epdc-product-selector' ); ?></p>
		<?php
	}

	/**
	 * Render primary color input.
	 *
	 * @return void
	 */
	public function render_primary_color_field(): void {
		$primary_color = EPDC_Settings::get_primary_color();
		?>
		<input
			type="text"
			id="epdc_primary_color"
			name="<?php echo esc_attr( EPDC_Settings::OPTION_KEY ); ?>[primary_color]"
			value="<?php echo esc_attr( $primary_color ); ?>"
			class="regular-text"
			placeholder="#d62828"
			pattern="^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$"
		/>
		<p class="description"><?php echo esc_html__( 'Used by the selector button and floating widget action button.', 'epdc-product-selector' ); ?></p>
		<?php
	}

	/**
	 * Render primary text color input.
	 *
	 * @return void
	 */
	public function render_primary_text_color_field(): void {
		$primary_text_color = EPDC_Settings::get_primary_text_color();
		?>
		<input
			type="text"
			id="epdc_primary_text_color"
			name="<?php echo esc_attr( EPDC_Settings::OPTION_KEY ); ?>[primary_text_color]"
			value="<?php echo esc_attr( $primary_text_color ); ?>"
			class="regular-text"
			placeholder="#ffffff"
			pattern="^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$"
		/>
		<p class="description"><?php echo esc_html__( 'Text color for controls that use the shared primary color.', 'epdc-product-selector' ); ?></p>
		<?php
	}
}
