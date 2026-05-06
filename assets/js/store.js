import { store } from '@wordpress/interactivity';

const NAMESPACE = 'epdc/productSelector';
const STORAGE_KEY = 'epdc_product_selector_items';

const normalizeItem = ( item ) => {
	if ( ! item || 'object' !== typeof item ) {
		return null;
	}

	const id = Number.parseInt( item.id, 10 );

	if ( ! Number.isInteger( id ) || id <= 0 ) {
		return null;
	}

	return {
		id,
		name: item.name ? String( item.name ) : '',
		sku: item.sku ? String( item.sku ) : '',
		url: item.url ? String( item.url ) : '',
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

const { state, actions } = store( NAMESPACE, {
	state: {
		selectedItems: [],
		isHydrated: false,
		get itemCount() {
			return state.selectedItems.length;
		},
		hasItem( itemId ) {
			const normalizedId = Number.parseInt( itemId, 10 );

			if ( ! Number.isInteger( normalizedId ) || normalizedId <= 0 ) {
				return false;
			}

			return state.selectedItems.some( ( item ) => item.id === normalizedId );
		},
		get inquiryPayload() {
			return state.selectedItems
				.map( ( item ) => {
					const title = item.name || `#${ item.id }`;
					return `${ title } [${ item.id }]`;
				} )
				.join( ', ' );
		},
	},
	actions: {
		addItem( item ) {
			const normalizedItem = normalizeItem( item );

			if ( ! normalizedItem || state.hasItem( normalizedItem.id ) ) {
				return;
			}

			state.selectedItems = [ ...state.selectedItems, normalizedItem ];
			actions.persistToStorage();
		},
		removeItem( itemId ) {
			const normalizedId = Number.parseInt( itemId, 10 );

			if ( ! Number.isInteger( normalizedId ) || normalizedId <= 0 ) {
				return;
			}

			state.selectedItems = state.selectedItems.filter(
				( item ) => item.id !== normalizedId
			);
			actions.persistToStorage();
		},
		clearItems() {
			state.selectedItems = [];
			actions.persistToStorage();
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
