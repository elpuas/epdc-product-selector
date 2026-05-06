# DOM-Driven Product Capture Revision Task Log

- Date: 2026-05-06
- Branch name: feature/interactivity-store-engine
- Task objective: Revise the Interactivity shared store to a minimal DOM-driven product capture model based on product card heading text.

## Files modified
- assets/js/store.js

## Revision summary
- Refactored store item model to only store:
	- `id`: sanitized slug from heading text
	- `name`: heading text
- Replaced metadata-style add action with `addItemFromCard`.
- Implemented DOM-driven heading capture helper for the nearest product card container, scanning `h1` through `h6`.
- Removed support for additional metadata fields (SKU/URL and any generalized metadata payload assumptions).
- Preserved required state behavior:
	- duplicate prevention
	- localStorage persistence (`epdc_product_selector_items`)
	- hydration on frontend load
	- derived `itemCount`
	- derived existence check (`hasItem`)
- Updated formatted inquiry payload output to:
	- `Productos de interés:`
	- bullet list of selected names (`- Product Name`).
- Kept the store architecture Interactivity-API compatible for directive-triggered actions.

## Validations performed
- JavaScript syntax validation:
	- `node --check assets/js/store.js`
- Interactivity structural validation:
	- Verified namespace, minimal item schema, required actions, duplicate prevention, hydration, persistence, and derived helpers in `assets/js/store.js`.
- Asset loading consistency validation:
	- Verified existing module registration and enqueue consistency remains unchanged in `includes/class-epdc-asset-registrar.php`.

## Commit
- Commit hash: (to be populated after commit)
