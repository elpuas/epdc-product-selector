'use strict';

( function () {
	const config = window.EPDCProductSelectorConfig || {};
	const STORAGE_KEY = 'epdc_product_selector_items';
	const INQUIRY_TRANSFER_EVENT = 'epdcProductSelector:inquiryTransferComplete';
	const MAX_FIELD_RETRY_ATTEMPTS = 20;
	const FIELD_RETRY_INTERVAL_MS = 200;
	const FORM_FIELD_SELECTOR =
		'string' === typeof config.fieldSelector && config.fieldSelector.trim()
			? config.fieldSelector.trim()
			: '.epdc-product-selection-field';

	const canUseStorage = () => {
		try {
			return 'undefined' !== typeof window && !! window.localStorage;
		} catch ( error ) {
			return false;
		}
	};

	document.addEventListener( 'DOMContentLoaded', function () {
		console.log( '[EPDC] inquiry autofill script start' );
		console.log( '[EPDC] inquiry autofill selector:', FORM_FIELD_SELECTOR );

		if ( ! canUseStorage() ) {
			console.log( '[EPDC] localStorage unavailable, aborting autofill' );
			return;
		}

		let storedValue = null;
		let storedItems = [];

		try {
			storedValue = window.localStorage.getItem( STORAGE_KEY );

			if ( storedValue ) {
				const parsedValue = JSON.parse( storedValue );
				storedItems = Array.isArray( parsedValue ) ? parsedValue : [];
			}
		} catch ( error ) {
			console.log( '[EPDC] localStorage read failed, aborting autofill' );
			return;
		}

		const payload = storedItems.length
			? storedItems
					.map( ( item ) => '- ' + String( item?.name || '' ).trim() )
					.filter( ( line ) => '- ' !== line )
					.join( '\n' )
					.replace( /^/, 'Productos de interés:\n\n' )
			: '';

		if ( ! payload ) {
			console.log( '[EPDC] no inquiry payload found, skipping autofill' );
			return;
		}

		let retryAttempts = 0;
		let autofillCompleted = false;
		const retryTimer = window.setInterval( function () {
			retryAttempts += 1;
			console.log(
				'[EPDC] field detection attempt',
				retryAttempts,
				'of',
				MAX_FIELD_RETRY_ATTEMPTS
			);

			// Keep integration form-agnostic by relying on the configured selector only.
			const targetField = document.querySelector( FORM_FIELD_SELECTOR );

			if ( ! targetField ) {
				if ( retryAttempts >= MAX_FIELD_RETRY_ATTEMPTS ) {
					window.clearInterval( retryTimer );
					console.log( '[EPDC] retry bailout: field not found' );
				}

				return;
			}

			console.log( '[EPDC] field detected, injecting payload' );
			targetField.value = payload;
			console.log( '[EPDC] payload injection complete' );

			try {
				targetField.dispatchEvent( new Event( 'input', { bubbles: true } ) );
				console.log( '[EPDC] dispatched input event' );
			} catch ( error ) {
				// Ignore event dispatch failures and continue cleanup.
			}

			try {
				targetField.dispatchEvent( new Event( 'change', { bubbles: true } ) );
				console.log( '[EPDC] dispatched change event' );
			} catch ( error ) {
				// Ignore event dispatch failures and continue cleanup.
			}

			try {
				window.localStorage.removeItem( STORAGE_KEY );
				console.log( '[EPDC] cleanup executed: storage entry removed' );
			} catch ( error ) {
				// Ignore cleanup failures in restricted browser contexts.
			}

			window.dispatchEvent( new CustomEvent( INQUIRY_TRANSFER_EVENT ) );
			autofillCompleted = true;
			window.clearInterval( retryTimer );
			console.log( '[EPDC] retry cleanup executed after successful injection' );
		}, FIELD_RETRY_INTERVAL_MS );

		// Extra guard in case of unusual timer behavior.
		window.setTimeout( function () {
			if ( ! autofillCompleted ) {
				window.clearInterval( retryTimer );
				console.log( '[EPDC] safety timeout cleanup executed' );
			}
		}, MAX_FIELD_RETRY_ATTEMPTS * FIELD_RETRY_INTERVAL_MS + 50 );
	} );
} )();
