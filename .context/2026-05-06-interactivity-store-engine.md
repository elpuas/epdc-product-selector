# Interactivity Store Engine Task Log

- Date: 2026-05-06
- Branch name: feature/interactivity-store-engine
- Task objective: Build the shared frontend Interactivity API state engine for EPDC Product Selector as an isolated, reusable state layer.

## Files modified
- assets/js/store.js
- includes/class-epdc-asset-registrar.php

## Implementation summary
- Replaced the `assets/js/store.js` scaffold with a centralized `@wordpress/interactivity` store using namespace `epdc/productSelector`.
- Implemented production-safe state and helpers:
	- state: `selectedItems`, `isHydrated`
	- derived helpers/selectors: `itemCount`, `hasItem( itemId )`, `inquiryPayload`
- Implemented store actions:
	- `addItem`
	- `removeItem`
	- `clearItems`
	- `hydrateFromStorage`
	- `persistToStorage`
- Added duplicate prevention in `addItem` by checking existing `id` values before append.
- Added safe localStorage integration via `epdc_product_selector_items` with read/write guards and graceful failure handling.
- Added frontend hydration call on module load (`actions.hydrateFromStorage()`) to restore prior selections.
- Updated asset registration to support Interactivity-native script modules:
	- register `epdc-product-selector-store` via `wp_register_script_module()` with `@wordpress/interactivity` dependency when available.
	- enqueue module via `wp_enqueue_script_module()` on frontend, with script fallback for compatibility.

## Validations performed
- JavaScript syntax validation:
	- `node --check assets/js/store.js`
- PHP syntax validation:
	- `php -l includes/class-epdc-asset-registrar.php`
- Interactivity API structural validation:
	- Verified store namespace, required state keys, required actions, duplicate prevention path, hydration call, and derived helpers in `assets/js/store.js`.
- Asset loading consistency validation:
	- Verified frontend registration and enqueue path for the store as a script module in `includes/class-epdc-asset-registrar.php`.

## Commit
- Commit hash: (to be populated after commit)
