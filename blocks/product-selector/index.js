( function ( blocks, element, i18n ) {
	const el = element.createElement;

	blocks.registerBlockType( 'epdc/product-selector', {
		edit: function Edit() {
			return el(
				'p',
				{ className: 'epdc-product-selector-editor-placeholder' },
				i18n.__( 'EPDC Product Selector block scaffold.', 'epdc-product-selector' )
			);
		},
		save: function Save() {
			return null;
		},
	} );
} )( window.wp.blocks, window.wp.element, window.wp.i18n );
