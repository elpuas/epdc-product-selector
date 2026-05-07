<?php
/**
 * Render callback for EPDC Product Selector block.
 *
 * @package EPDC_Product_Selector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$button_label = isset( $attributes['buttonLabel'] ) && is_string( $attributes['buttonLabel'] ) && '' !== trim( $attributes['buttonLabel'] )
	? $attributes['buttonLabel']
	: __( 'Agregar a Cotización', 'epdc-product-selector' );

$wrapper_attributes = get_block_wrapper_attributes(
	[
		'class' => 'epdc-product-selector epdc-product-selector--dynamic',
	]
);
?>
<div <?php echo wp_kses_data( $wrapper_attributes ); ?> data-wp-interactive="epdc/productSelector">
	<button type="button" class="epdc-product-selector__button" data-wp-on--click="actions.addItemFromCard">
		<?php echo esc_html( $button_label ); ?>
	</button>
</div>
