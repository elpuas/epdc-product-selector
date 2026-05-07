# Floating Inquiry Widget Task Log

- Date: 2026-05-07
- Branch: feature/floating-inquiry-widget
- Commit hash: a1930a1

## Task objective
Implement a global frontend floating inquiry widget for EPDC Product Selector, automatically rendered and synchronized with the shared Interactivity store namespace `epdc/productSelector`, including item count, selected names, item removal, clear all, and inquiry CTA placeholder.

## Files modified
- assets/css/frontend.css
- assets/js/store.js
- includes/class-epdc-asset-registrar.php
- includes/class-epdc-widget-registrar.php

## Widget architecture summary
- Replaced footer mount-point output with a full server-rendered floating widget in `EPDC_Widget_Registrar::render_widget()`.
- Widget is injected globally via `wp_footer` and does not require block insertion.
- Markup is rooted with `data-wp-interactive="epdc/productSelector"` and processed through `wp_interactivity_process_directives()` when available.
- Extended the existing Interactivity store with widget UI state (`isExpanded`) and UI actions (`toggleWidget`, `removeItemFromEvent`, `openInquiryPlaceholder`) while preserving existing card capture and storage behavior.
- Ensured frontend style handle is globally enqueued to support widget rendering on all frontend pages.

## Directives implemented
- `data-wp-text`
	- `state.itemCount`
	- `context.item.name`
- `data-wp-on--click`
	- `actions.toggleWidget`
	- `actions.removeItemFromEvent`
	- `actions.clearItems`
	- `actions.openInquiryPlaceholder`
- `data-wp-bind`
	- `data-wp-bind--aria-expanded`
	- `data-wp-bind--disabled`
	- `data-wp-bind--hidden`
	- `data-wp-bind--data-item-id`
- `data-wp-each`
	- `state.selectedItems`

## Validations performed
- PHP syntax validation:
	- `php -l includes/class-epdc-widget-registrar.php`
	- `php -l includes/class-epdc-asset-registrar.php`
	- `php -l includes/class-epdc-plugin.php`
- JavaScript syntax validation:
	- `node --check assets/js/store.js`
- Interactivity directive validation:
	- Verified widget and block directive presence with `rg` for `data-wp-*` directives.
- Frontend asset consistency validation:
	- Verified registration/enqueue handle consistency with `rg` across includes/blocks.
