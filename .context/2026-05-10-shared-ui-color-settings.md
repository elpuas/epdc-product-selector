# Shared UI Color Settings

## Branch Name

`feature/shared-ui-color-settings`

## Task Objective

Implement shared plugin UI color settings and centralized frontend design tokens so EPDC Product Selector UI controls (floating widget and dynamic selector button) use one global configuration.

## Files Modified

- `includes/class-epdc-settings.php`
- `includes/class-epdc-settings-page.php`
- `includes/class-epdc-asset-registrar.php`
- `assets/css/frontend.css`

## Settings Added

- `primary_color` (default `#d62828`)
- `primary_text_color` (default `#ffffff`)

Both settings are sanitized using `sanitize_hex_color()` with fallback defaults when empty or invalid.

## CSS Variables Implemented

- `--epdc-primary`
- `--epdc-primary-text`

Defaults are defined in frontend CSS and runtime values are injected globally from plugin settings.

## Frontend Style Injection Summary

- Added `EPDC_Asset_Registrar::inject_frontend_design_tokens()` on `wp_enqueue_scripts`.
- Injects:
  - `:root{--epdc-primary:<value>;--epdc-primary-text:<value>;}`
- Uses `wp_add_inline_style( 'epdc-product-selector-frontend', ... )` after the plugin stylesheet is enqueued.

## Implementation Summary

- Extended centralized settings storage with global UI color options and accessors.
- Extended settings page with two new fields (`Primary Color`, `Primary Text Color`).
- Updated frontend stylesheet so:
  - `.epdc-product-selector__button` uses shared tokens.
  - `.epdc-inquiry-widget__cta` uses shared tokens.
- Preserved all existing functional behavior and kept changes lightweight/WordPress-native.

## Validations Performed

- PHP syntax validation:
  - `php -l includes/class-epdc-settings.php`
  - `php -l includes/class-epdc-settings-page.php`
  - `php -l includes/class-epdc-asset-registrar.php`
- Settings sanitization validation:
  - Verified both new settings flow through centralized sanitize callback and hex fallback sanitizer.
- Frontend style injection validation:
  - Verified token injection path via `wp_add_inline_style()` on `epdc-product-selector-frontend`.
- CSS validation:
  - Verified CSS syntax and variable usage in `assets/css/frontend.css`.
- Visual consistency validation:
  - Verified both selector button and widget CTA now consume the same shared tokens.

## Commit Hash

`PENDING`
