'use strict';

( function () {
	const config = window.EPDCProductSelectorConfig || {};
	const STORAGE_KEY = 'epdc_product_selector_items';
	const FORM_FIELD_SELECTOR =
		'string' === typeof config.fieldSelector && config.fieldSelector.trim()
			? config.fieldSelector.trim()
			: '.epdc-product-selection-field';
	const FALLBACK_FIELD_SELECTOR = 'textarea[name="textarea-2"]';

	console.log( '[EPDC Form Debug] Inquiry autofill script loaded.' );
	console.log( '[EPDC Form Debug] Current URL:', window.location.href );

	const canUseStorage = () => {
		try {
			return 'undefined' !== typeof window && !! window.localStorage;
		} catch ( error ) {
			console.log( '[EPDC Form Debug] localStorage unavailable:', error );
			return false;
		}
	};

	document.addEventListener( 'DOMContentLoaded', function () {
		console.log( '[EPDC Form Debug] DOMContentLoaded fired.' );
		console.log( '[EPDC Form Debug] Configured field selector:', FORM_FIELD_SELECTOR );

		if ( ! canUseStorage() ) {
			console.log( '[EPDC Form Debug] Aborting: localStorage cannot be used.' );
			return;
		}

		console.log( '[EPDC Form Debug] Retrieving products from localStorage key:', STORAGE_KEY );

		let storedValue = null;
		let storedItems = [];

		try {
			storedValue = window.localStorage.getItem( STORAGE_KEY );
			console.log( '[EPDC Form Debug] Raw localStorage value:', storedValue );

			if ( storedValue ) {
				const parsedValue = JSON.parse( storedValue );
				storedItems = Array.isArray( parsedValue ) ? parsedValue : [];
			}
		} catch ( error ) {
			console.log( '[EPDC Form Debug] Failed reading/parsing storage payload:', error );
			return;
		}

		console.log( '[EPDC Form Debug] Retrieved product payload:', storedItems );

		const payload = storedItems.length
			? storedItems
					.map( ( item ) => '- ' + String( item?.name || '' ).trim() )
					.filter( ( line ) => '- ' !== line )
					.join( '\n' )
					.replace( /^/, 'Productos de interés:\n\n' )
			: '';

		console.log( '[EPDC Form Debug] Prepared injection payload:', payload );

		if ( ! payload ) {
			console.log( '[EPDC Form Debug] Aborting: payload is empty.' );
			return;
		}

		const configuredField = document.querySelector( FORM_FIELD_SELECTOR );
		console.log( '[EPDC Form Debug] querySelector(configured) result:', configuredField );

		const targetField = configuredField || document.querySelector( FALLBACK_FIELD_SELECTOR );
		const fallbackFound = ! configuredField && !! targetField;

		console.log(
			'[EPDC Form Debug] Target field textarea[name="textarea-2"] found:',
			!! document.querySelector( FALLBACK_FIELD_SELECTOR )
		);
		console.log( '[EPDC Form Debug] Using fallback selector:', fallbackFound );

		if ( ! targetField ) {
			console.log( '[EPDC Form Debug] Aborting: no target field found for injection.' );
			return;
		}

		targetField.value = payload;
		console.log( '[EPDC Form Debug] Field injection successful.' );

		try {
			targetField.dispatchEvent( new Event( 'input', { bubbles: true } ) );
			console.log( '[EPDC Form Debug] input event dispatched successfully.' );
		} catch ( error ) {
			console.log( '[EPDC Form Debug] input event dispatch failed:', error );
		}

		try {
			targetField.dispatchEvent( new Event( 'change', { bubbles: true } ) );
			console.log( '[EPDC Form Debug] change event dispatched successfully.' );
		} catch ( error ) {
			console.log( '[EPDC Form Debug] change event dispatch failed:', error );
		}

		try {
			window.localStorage.removeItem( STORAGE_KEY );
			console.log( '[EPDC Form Debug] Cleanup executed: localStorage key removed.' );
		} catch ( error ) {
			console.log( '[EPDC Form Debug] Cleanup failed:', error );
		}
	} );
} )();
