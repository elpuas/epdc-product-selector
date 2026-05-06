<?php
/**
 * Render callback for EPDC Product Selector block.
 *
 * @package EPDC_Product_Selector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wrapper_attributes = get_block_wrapper_attributes(
	[
		'class' => 'epdc-product-selector-block',
	]
);
?>
<div <?php echo wp_kses_data( $wrapper_attributes ); ?> data-wp-interactive="epdc-product-selector">
	<button type="button" class="epdc-product-selector-trigger">
		<?php esc_html_e( 'Select product (coming soon)', 'epdc-product-selector' ); ?>
	</button>
</div>
