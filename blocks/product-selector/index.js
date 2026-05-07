( function ( blocks, element, i18n, blockEditor, components ) {
	const el = element.createElement;
	const __ = i18n.__;
	const useBlockProps = blockEditor.useBlockProps;
	const InspectorControls = blockEditor.InspectorControls;
	const PanelBody = components.PanelBody;
	const TextControl = components.TextControl;
	const DEFAULT_BUTTON_LABEL = __( 'Agregar a Cotización', 'epdc-product-selector' );

	blocks.registerBlockType( 'epdc/product-selector', {
		edit: function Edit( props ) {
			const attributes = props.attributes;
			const setAttributes = props.setAttributes;
			const buttonLabel = attributes.buttonLabel || DEFAULT_BUTTON_LABEL;
			const blockProps = useBlockProps( {
				className: 'epdc-product-selector-editor',
			} );

			return el(
				element.Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{
							title: __( 'Button', 'epdc-product-selector' ),
							initialOpen: true,
						},
						el( TextControl, {
							label: __( 'Button label', 'epdc-product-selector' ),
							value: buttonLabel,
							onChange: function onChange( value ) {
								setAttributes( {
									buttonLabel: value || DEFAULT_BUTTON_LABEL,
								} );
							},
						} )
					)
				),
				el(
					'div',
					blockProps,
					el(
						'button',
						{
							type: 'button',
							className: 'epdc-product-selector-button',
							disabled: true,
						},
						buttonLabel
					)
				)
			);
		},
		save: function Save() {
			return null;
		},
	} );
} )(
	window.wp.blocks,
	window.wp.element,
	window.wp.i18n,
	window.wp.blockEditor,
	window.wp.components
);
