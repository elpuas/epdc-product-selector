'use strict';

( function () {
	const config = window.EPDCProductSelectorConfig || {};
	const FORM_FIELD_SELECTOR =
		'string' === typeof config.fieldSelector && config.fieldSelector.trim()
			? config.fieldSelector.trim()
			: '.epdc-product-selection-field';

	document.addEventListener( 'DOMContentLoaded', function () {
		document.querySelectorAll( FORM_FIELD_SELECTOR );
	} );
} )();
