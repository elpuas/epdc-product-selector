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
		if ( ! canUseStorage() ) {
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
			return;
		}

		let retryAttempts = 0;
		const retryTimer = window.setInterval( function () {
			retryAttempts += 1;

			// Keep integration form-agnostic by relying on the configured selector only.
			const targetField = document.querySelector( FORM_FIELD_SELECTOR );

			if ( ! targetField ) {
				if ( retryAttempts >= MAX_FIELD_RETRY_ATTEMPTS ) {
					window.clearInterval( retryTimer );
				}

				return;
			}

			targetField.value = payload;

			try {
				targetField.dispatchEvent( new Event( 'input', { bubbles: true } ) );
			} catch ( error ) {
				// Ignore event dispatch failures and continue cleanup.
			}

			try {
				targetField.dispatchEvent( new Event( 'change', { bubbles: true } ) );
			} catch ( error ) {
				// Ignore event dispatch failures and continue cleanup.
			}

			try {
				window.localStorage.removeItem( STORAGE_KEY );
			} catch ( error ) {
				// Ignore cleanup failures in restricted browser contexts.
			}

			window.dispatchEvent( new CustomEvent( INQUIRY_TRANSFER_EVENT ) );
			window.clearInterval( retryTimer );
		}, FIELD_RETRY_INTERVAL_MS );

		// Extra guard in case of unusual timer behavior.
		window.setTimeout( function () {
			window.clearInterval( retryTimer );
		}, MAX_FIELD_RETRY_ATTEMPTS * FIELD_RETRY_INTERVAL_MS + 50 );
	} );
} )();
