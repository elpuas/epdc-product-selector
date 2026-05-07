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
		$loader->add_action( 'wp_footer', $this, 'render_widget' );
	}

	/**
	 * Render global floating inquiry widget.
	 */
	public function render_widget(): void {
		$toggle_label = esc_html__( 'Seleccionados', 'epdc-product-selector' );
		$empty_label  = esc_html__( 'Sin productos', 'epdc-product-selector' );
		$list_label   = esc_html__( 'Productos seleccionados', 'epdc-product-selector' );
		$clear_label  = esc_html__( 'Limpiar', 'epdc-product-selector' );
		$cta_label    = esc_html__( 'Continuar Cotización', 'epdc-product-selector' );
		$remove_label = esc_html__( 'Quitar', 'epdc-product-selector' );

		$markup = '
		<div id="epdc-product-selector-widget" class="epdc-inquiry-widget" data-wp-interactive="epdc/productSelector">
			<button type="button" class="epdc-inquiry-widget__toggle" data-wp-on--click="actions.toggleWidget" data-wp-bind--aria-expanded="state.isExpanded" data-wp-bind--disabled="!state.itemCount">
				<span class="epdc-inquiry-widget__label">' . $toggle_label . '</span>
				<span class="epdc-inquiry-widget__count" data-wp-text="state.itemCount">0</span>
			</button>
			<div class="epdc-inquiry-widget__empty" data-wp-bind--hidden="state.itemCount">
				' . $empty_label . '
			</div>
			<section class="epdc-inquiry-widget__panel" data-wp-bind--hidden="!state.itemCount || !state.isExpanded">
				<h3 class="epdc-inquiry-widget__title">' . $list_label . '</h3>
				<ul class="epdc-inquiry-widget__list">
					<template data-wp-each="state.selectedItems">
						<li class="epdc-inquiry-widget__item">
							<span class="epdc-inquiry-widget__name" data-wp-text="context.item.name"></span>
							<button type="button" class="epdc-inquiry-widget__remove" data-wp-bind--data-item-id="context.item.id" data-wp-on--click="actions.removeItemFromEvent">' . $remove_label . '</button>
						</li>
					</template>
				</ul>
				<div class="epdc-inquiry-widget__actions">
					<button type="button" class="epdc-inquiry-widget__clear" data-wp-on--click="actions.clearItems">' . $clear_label . '</button>
					<button type="button" class="epdc-inquiry-widget__cta" data-wp-on--click="actions.openInquiryPlaceholder">' . $cta_label . '</button>
				</div>
			</section>
		</div>';

		if ( function_exists( 'wp_interactivity_process_directives' ) ) {
			echo wp_interactivity_process_directives( $markup ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return;
		}

		echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
