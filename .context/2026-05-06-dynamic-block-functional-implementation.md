# Dynamic Block Functional Implementation

- Branch name: `feature/dynamic-block-functional-implementation`
- Commit hash: `b55e9ee`

## Task objective
Implement the existing `blocks/product-selector/` scaffold as a production-valid dynamic block, insertable as `EPDC Product Selector`, and functionally connected to the shared Interactivity API store namespace `epdc/productSelector` using native directives.

## Files modified
- `blocks/product-selector/block.json`
- `blocks/product-selector/index.js`
- `blocks/product-selector/render.php`

## Block implementation summary
- Added a minimal MVP block attribute: `buttonLabel` with default `Agregar a Cotización`.
- Upgraded editor block registration in `index.js` to include:
	- proper `registerBlockType` edit implementation,
	- a lightweight preview button,
	- `InspectorControls` + `TextControl` for editing `buttonLabel`.
- Updated dynamic render in `render.php` to:
	- render production-safe wrapper and button class names,
	- bind interactivity root to `data-wp-interactive="epdc/productSelector"`,
	- bind click handling to `data-wp-on--click="actions.addItemFromCard"`,
	- render sanitized runtime label from block attributes.
- Kept product metadata capture out of the block render and delegated add behavior to store action logic.

## Validations performed
- PHP syntax validation:
	- `php -l blocks/product-selector/render.php`
	- `php -l includes/class-epdc-block-registrar.php`
	- `php -l epdc-product-selector.php`
- JavaScript syntax validation:
	- `node --check blocks/product-selector/index.js`
	- `node --check assets/js/store.js`
- Block/interactivity wiring validation (static verification):
	- Confirmed block registration path via `register_block_type( EPDC_PRODUCT_SELECTOR_BLOCK_PATH . 'product-selector' )`.
	- Confirmed `data-wp-interactive="epdc/productSelector"` matches store namespace `NAMESPACE = 'epdc/productSelector'`.
	- Confirmed click directive calls `actions.addItemFromCard`.
- WP-CLI validation:
	- Not executed because `wp` is unavailable in this environment (`command not found`).
