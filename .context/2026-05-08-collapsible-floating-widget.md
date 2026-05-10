# Collapsible Floating Widget

## Branch Name
`feature/collapsible-floating-widget`

## Task Objective
Implement collapsible/minimizable behavior for the EPDC Product Selector floating inquiry widget using lightweight, reactive WordPress Interactivity API state/actions while preserving existing widget functionality.

## Files Modified
- `assets/js/store.js`
- `includes/class-epdc-widget-registrar.php`
- `assets/css/frontend.css`

## Implementation Summary
- Added runtime-only widget UI state to the Interactivity store:
	- `isOpen`
	- derived visibility getters: `showPanel`, `showEmptyState`
- Added store actions:
	- `toggleWidget`
	- `openWidget`
	- `closeWidget`
- Updated widget header behavior:
	- full header toggle button now triggers `actions.toggleWidget`
	- `aria-expanded` now reflects `state.isOpen`
- Updated widget visibility directives:
	- empty message shown only when expanded and there are no selected items (`state.showEmptyState`)
	- full panel shown only when expanded and items exist (`state.showPanel`)
- Updated add-item flow:
	- adding a new product now auto-expands widget via `actions.openWidget()`
- Kept `isOpen` runtime-only:
	- no storage read/write path includes `isOpen`
- Removed unused disabled-toggle CSS rule after removing header disabled behavior.

## Widget Interaction Summary
- Widget is always visible.
- Collapsed state shows header (title + count).
- Clicking the full header toggles open/closed.
- Expanded state shows selected items list, remove actions, clear button, and inquiry CTA.
- New item additions automatically open the widget.

## State Additions
- `state.isOpen` (boolean, non-persistent)
- `state.showPanel` (derived)
- `state.showEmptyState` (derived)
- `actions.toggleWidget()`
- `actions.openWidget()`
- `actions.closeWidget()`

## Validations Performed
- JavaScript syntax validation:
	- `node --check assets/js/store.js`
- PHP syntax validation:
	- `php -l includes/class-epdc-widget-registrar.php`
- Interactivity directive validation:
	- verified new directives map to existing store state/actions with `rg` in store + widget registrar
- Widget interaction and runtime state validation:
	- verified add-item flow calls `openWidget()` on successful add
	- verified panel/empty visibility are driven by reactive derived state (`showPanel`, `showEmptyState`)
	- verified localStorage logic remains scoped to `selectedItems` only (no `isOpen` persistence)

## Commit Hash
`d32736d`
