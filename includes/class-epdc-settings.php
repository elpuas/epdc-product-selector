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
	 * Default primary color.
	 */
	public const DEFAULT_PRIMARY_COLOR = '#d62828';

	/**
	 * Default primary text color.
	 */
	public const DEFAULT_PRIMARY_TEXT_COLOR = '#ffffff';

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
			'primary_color'          => self::DEFAULT_PRIMARY_COLOR,
			'primary_text_color'     => self::DEFAULT_PRIMARY_TEXT_COLOR,
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

		if ( isset( $input['primary_color'] ) ) {
			$sanitized['primary_color'] = self::sanitize_hex_color_with_fallback( (string) $input['primary_color'], self::DEFAULT_PRIMARY_COLOR );
		}

		if ( isset( $input['primary_text_color'] ) ) {
			$sanitized['primary_text_color'] = self::sanitize_hex_color_with_fallback( (string) $input['primary_text_color'], self::DEFAULT_PRIMARY_TEXT_COLOR );
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
				'primary_color'          => self::DEFAULT_PRIMARY_COLOR,
				'primary_text_color'     => self::DEFAULT_PRIMARY_TEXT_COLOR,
			]
		);
	}

	/**
	 * Get inquiry page ID.
	 *
	 * @return int
	 */
	public static function get_inquiry_page_id(): int {
		$options = self::get_options();

		return absint( $options['inquiry_page_id'] );
	}

	/**
	 * Get inquiry page URL.
	 *
	 * @return string
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
	 *
	 * @return string
	 */
	public static function get_inquiry_field_selector(): string {
		$options = self::get_options();

		return self::sanitize_inquiry_field_selector( (string) $options['inquiry_field_selector'] );
	}

	/**
	 * Get configured primary color.
	 *
	 * @return string
	 */
	public static function get_primary_color(): string {
		$options = self::get_options();

		return self::sanitize_hex_color_with_fallback( (string) $options['primary_color'], self::DEFAULT_PRIMARY_COLOR );
	}

	/**
	 * Get configured primary text color.
	 *
	 * @return string
	 */
	public static function get_primary_text_color(): string {
		$options = self::get_options();

		return self::sanitize_hex_color_with_fallback( (string) $options['primary_text_color'], self::DEFAULT_PRIMARY_TEXT_COLOR );
	}

	/**
	 * Sanitize CSS selector setting.
	 *
	 * @param string $selector Raw selector.
	 * @return string
	 */
	private static function sanitize_inquiry_field_selector( string $selector ): string {
		$selector = trim( wp_strip_all_tags( $selector ) );

		if ( '' === $selector ) {
			return self::DEFAULT_INQUIRY_FIELD_SELECTOR;
		}

		return sanitize_text_field( $selector );
	}

	/**
	 * Sanitize hex colors with fallback.
	 *
	 * @param string $color Raw color.
	 * @param string $fallback Fallback color.
	 * @return string
	 */
	private static function sanitize_hex_color_with_fallback( string $color, string $fallback ): string {
		$color = sanitize_hex_color( trim( $color ) );

		if ( null === $color ) {
			return $fallback;
		}

		return $color;
	}
}
