import { store } from '@wordpress/interactivity';

const NAMESPACE = 'epdc/productSelector';
const STORAGE_KEY = 'epdc_product_selector_items';
const INQUIRY_TRANSFER_EVENT = 'epdcProductSelector:inquiryTransferComplete';
const EPDC_CONFIG =
	'undefined' !== typeof window && window.EPDCProductSelectorConfig
		? window.EPDCProductSelectorConfig
		: {};
const CARD_HEADING_SELECTOR = 'h1, h2, h3, h4, h5, h6';
const CARD_CONTAINER_SELECTOR =
	'[data-epdc-product-card], .epdc-product-card, .product, article, li, .wp-block-group';

const slugify = ( value ) =>
	String( value )
		.toLowerCase()
		.trim()
		.replace( /[^a-z0-9\s-]/g, '' )
		.replace( /\s+/g, '-' )
		.replace( /-+/g, '-' );

const normalizeItem = ( item ) => {
	if ( ! item || 'object' !== typeof item ) {
		return null;
	}

	const name = item.name ? String( item.name ).trim() : '';
	const id = item.id ? slugify( item.id ) : slugify( name );

	if ( ! name || ! id ) {
		return null;
	}

	return {
		id,
		name,
	};
};

const canUseStorage = () => {
	try {
		return 'undefined' !== typeof window && !! window.localStorage;
	} catch ( error ) {
		return false;
	}
};

const readStorageItems = () => {
	if ( ! canUseStorage() ) {
		return [];
	}

	try {
		const storedValue = window.localStorage.getItem( STORAGE_KEY );

		if ( ! storedValue ) {
			return [];
		}

		const parsedItems = JSON.parse( storedValue );

		if ( ! Array.isArray( parsedItems ) ) {
			return [];
		}

		return parsedItems
			.map( normalizeItem )
			.filter( ( item ) => null !== item );
	} catch ( error ) {
		return [];
	}
};

const writeStorageItems = ( items ) => {
	if ( ! canUseStorage() ) {
		return;
	}

	try {
		window.localStorage.setItem( STORAGE_KEY, JSON.stringify( items ) );
	} catch ( error ) {
		// Ignore write failures (quota, privacy mode, etc).
	}
};

const findClosestCardHeading = ( sourceElement ) => {
	if ( ! sourceElement || 'function' !== typeof sourceElement.closest ) {
		return '';
	}

	const cardContainer = sourceElement.closest( CARD_CONTAINER_SELECTOR );
	const headingElement = cardContainer
		? cardContainer.querySelector( CARD_HEADING_SELECTOR )
		: null;

	if ( ! headingElement ) {
		return '';
	}

	return headingElement.textContent ? headingElement.textContent.trim() : '';
};

const { state, actions } = store( NAMESPACE, {
	state: {
		selectedItems: [],
		isHydrated: false,
		isOpen: false,
		get hasItems() {
			return state.selectedItems.length > 0;
		},
		get showPanel() {
			return state.isOpen && state.hasItems;
		},
		get showEmptyState() {
			return state.isOpen && ! state.hasItems;
		},
		get itemCount() {
			return state.selectedItems.length;
		},
		hasItem( itemId ) {
			const normalizedId = slugify( itemId );

			if ( ! normalizedId ) {
				return false;
			}

			return state.selectedItems.some( ( item ) => item.id === normalizedId );
		},
		get inquiryPayload() {
			if ( 0 === state.selectedItems.length ) {
				return '';
			}

			return state.selectedItems
				.map( ( item ) => `- ${ item.name }` )
				.join( '\n' )
				.replace( /^/, 'Productos de interés:\n\n' );
		},
	},
	actions: {
		addItemFromCard( event ) {
			const sourceElement = event?.currentTarget || event?.target || null;
			const headingText = findClosestCardHeading( sourceElement );
			const normalizedItem = normalizeItem( { name: headingText } );

			if ( ! normalizedItem || state.hasItem( normalizedItem.id ) ) {
				return;
			}

			state.selectedItems = [ ...state.selectedItems, normalizedItem ];
			actions.openWidget();
			actions.persistToStorage();
		},
		toggleWidget() {
			state.isOpen = ! state.isOpen;
		},
		openWidget() {
			state.isOpen = true;
		},
		closeWidget() {
			state.isOpen = false;
		},
		removeItem( itemId ) {
			const normalizedId = slugify( itemId );

			if ( ! normalizedId ) {
				return;
			}

			state.selectedItems = state.selectedItems.filter(
				( item ) => item.id !== normalizedId
			);
			actions.persistToStorage();
		},
		removeItemFromEvent( event ) {
			const itemId = event?.currentTarget?.dataset?.itemId || '';
			actions.removeItem( itemId );
		},
		clearItems() {
			state.selectedItems = [];
			actions.persistToStorage();
		},
		openInquiryPlaceholder() {
			if ( 0 === state.itemCount ) {
				return;
			}

			const inquiryUrl =
				'string' === typeof EPDC_CONFIG.inquiryUrl
					? EPDC_CONFIG.inquiryUrl.trim()
					: '';

			if ( inquiryUrl ) {
				window.location.href = inquiryUrl;
			}
		},
		hydrateFromStorage() {
			if ( state.isHydrated ) {
				return;
			}

			state.selectedItems = readStorageItems();
			state.isHydrated = true;
		},
		persistToStorage() {
			writeStorageItems( state.selectedItems );
		},
	},
} );

actions.hydrateFromStorage();

if ( 'undefined' !== typeof window ) {
	window.addEventListener( INQUIRY_TRANSFER_EVENT, () => {
		if ( 0 === state.selectedItems.length ) {
			return;
		}

		actions.clearItems();
	} );
}
