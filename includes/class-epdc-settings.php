<?php
/**
 * Plugin settings storage and accessors.
 *
 * @package EPDC_Product_Selector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPDC_Settings {

	/**
	 * Option key.
	 */
	public const OPTION_KEY = 'epdc_product_selector_settings';

	/**
	 * Default field selector.
	 */
	public const DEFAULT_INQUIRY_FIELD_SELECTOR = '.epdc-product-selection-field';

	/**
	 * Sanitize settings payload.
	 *
	 * @param mixed $input Raw option input.
	 * @return array<string, int|string>
	 */
	public static function sanitize_settings( $input ): array {
		$sanitized = [
			'inquiry_page_id'        => 0,
			'inquiry_field_selector' => self::DEFAULT_INQUIRY_FIELD_SELECTOR,
		];

		if ( ! is_array( $input ) ) {
			return $sanitized;
		}

		if ( isset( $input['inquiry_page_id'] ) ) {
			$sanitized['inquiry_page_id'] = absint( $input['inquiry_page_id'] );
		}

		if ( isset( $input['inquiry_field_selector'] ) ) {
			$sanitized['inquiry_field_selector'] = self::sanitize_inquiry_field_selector( (string) $input['inquiry_field_selector'] );
		}

		return $sanitized;
	}

	/**
	 * Get full option payload.
	 *
	 * @return array<string, int|string>
	 */
	public static function get_options(): array {
		$options = get_option( self::OPTION_KEY, [] );

		if ( ! is_array( $options ) ) {
			$options = [];
		}

		return wp_parse_args(
			$options,
			[
				'inquiry_page_id'        => 0,
				'inquiry_field_selector' => self::DEFAULT_INQUIRY_FIELD_SELECTOR,
			]
		);
	}

	/**
	 * Get inquiry page ID.
	 */
	public static function get_inquiry_page_id(): int {
		$options = self::get_options();

		return absint( $options['inquiry_page_id'] );
	}

	/**
	 * Get inquiry page URL.
	 */
	public static function get_inquiry_page_url(): string {
		$page_id = self::get_inquiry_page_id();

		if ( $page_id <= 0 ) {
			return '';
		}

		$url = get_permalink( $page_id );

		return is_string( $url ) ? $url : '';
	}

	/**
	 * Get configured inquiry field selector.
	 */
	public static function get_inquiry_field_selector(): string {
		$options = self::get_options();

		return self::sanitize_inquiry_field_selector( (string) $options['inquiry_field_selector'] );
	}

	/**
	 * Sanitize CSS selector setting.
	 */
	private static function sanitize_inquiry_field_selector( string $selector ): string {
		$selector = trim( wp_strip_all_tags( $selector ) );

		if ( '' === $selector ) {
			return self::DEFAULT_INQUIRY_FIELD_SELECTOR;
		}

		return sanitize_text_field( $selector );
	}
}
