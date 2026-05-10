# EPDC Product Selector

EPDC Product Selector is a standalone WordPress plugin for catalog-based lead capture.

It lets visitors select products while browsing, keeps the selection synchronized across pages, and transfers that selection into an inquiry form flow.

This plugin is not a checkout or ecommerce cart.

## Features

- Dynamic `epdc/product-selector` block rendered server-side.
- Shared Interactivity API store for product selection state.
- Duplicate prevention and item removal/clear actions.
- `localStorage` persistence across navigation.
- Floating inquiry widget auto-injected in the frontend footer.
- Inquiry redirect flow from widget CTA to configured inquiry page.
- Inquiry form autofill from stored selection.
- Settings page for inquiry page, form field selector, and shared UI colors.

## Installation

1. Copy `epdc-product-selector` into `wp-content/plugins/`.
2. Activate **EPDC Product Selector** in WordPress admin.
3. Go to `Settings > EPDC Product Selector` and configure:
- Inquiry Page
- Form Field Selector
- Primary Color
- Primary Text Color

## Block Usage

1. Edit the target page/template where product cards are rendered.
2. Insert **EPDC Product Selector** (`epdc/product-selector`) inside each card or product item layout.
3. Optionally customize the block button label in the inspector.

The block output is dynamic (`render.php`) and wires the button to the global Interactivity store.

## Inquiry Flow

1. Visitor clicks product selector buttons from product/category views.
2. Selected products are stored in the Interactivity store and persisted in `localStorage`.
3. Floating widget shows count, selected items, and clear/remove controls.
4. Visitor clicks **Solicitar Cotización** in the widget.
5. Visitor is redirected to the configured inquiry page.
6. Form integration script auto-populates the configured field selector with the selection payload.
7. Local transfer storage is cleaned after successful autofill synchronization.

## Plugin Settings

Settings are stored in option key `epdc_product_selector_settings`.

Configured fields:

- `inquiry_page_id`: target page used by widget redirect CTA.
- `inquiry_field_selector`: CSS selector for inquiry form field autofill.
- `primary_color`: shared primary UI color for selector/button controls.
- `primary_text_color`: text color for controls using the primary color.

## Form Integration Approach

Form autofill is form-plugin agnostic.

The plugin targets a configurable CSS selector and writes a plain text payload like:

```text
Productos de interés:

- Product A
- Product B
```

Any form solution is supported if the target field is selectable in frontend DOM.

## Shared UI Color Settings

Frontend styles consume CSS variables injected from settings:

- `--epdc-primary`
- `--epdc-primary-text`

These tokens style:

- product selector button
- floating widget primary CTA and related controls

## Technical Architecture

Core systems:

- Dynamic Product Selector Block: `blocks/product-selector/*`
- Global Interactivity Store: `assets/js/store.js`
- Floating Inquiry Widget: `includes/class-epdc-widget-registrar.php`
- Inquiry Form Autofill: `assets/js/form.js` + `includes/class-epdc-frontend-config.php`

Main plugin composition:

- Bootstrap: `epdc-product-selector.php`
- Hook orchestration: `includes/class-epdc-plugin.php`
- Hook queue/runner: `includes/class-epdc-plugin-loader.php`
- Asset registration/enqueue: `includes/class-epdc-asset-registrar.php`
- Block registration: `includes/class-epdc-block-registrar.php`
- Settings storage/access: `includes/class-epdc-settings.php`
- Admin settings UI: `includes/class-epdc-settings-page.php`

## Development Notes

- PHP 8+ expected.
- WordPress-native APIs and hooks only.
- Interactivity behavior is implemented with `@wordpress/interactivity`.
- Keep block output dynamic and keep frontend logic store-driven.
- Keep inquiry integration selector-driven to preserve form-plugin portability.
