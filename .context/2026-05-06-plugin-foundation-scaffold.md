# EPDC Product Selector - Plugin Foundation Scaffold

## Branch Name
feature/plugin-foundation-scaffold

## Commit Hash
4c94455

## Task Objective
Initialize a production-ready standalone WordPress plugin scaffold for EPDC Product Selector with modular architecture, central hook loader, dynamic block scaffold, frontend asset placeholders, and safe plugin bootstrap readiness for future Interactivity API integration.

## Files Created or Modified
- epdc-product-selector.php
- includes/class-epdc-plugin-loader.php
- includes/class-epdc-plugin.php
- includes/class-epdc-asset-registrar.php
- includes/class-epdc-block-registrar.php
- includes/class-epdc-widget-registrar.php
- includes/class-epdc-inquiry-form-integrator.php
- blocks/product-selector/block.json
- blocks/product-selector/render.php
- blocks/product-selector/index.js
- blocks/product-selector/editor.css
- assets/js/store.js
- assets/js/form.js
- assets/css/frontend.css
- .context/2026-05-06-plugin-foundation-scaffold.md

## Implementation Summary
- Added plugin bootstrap with safe ABSPATH guard and core constants: plugin version, plugin path, plugin URL, and block path.
- Implemented a central loader pattern (`EPDC_Plugin_Loader`) to register all actions/filters from isolated classes.
- Added single-responsibility registrars for assets, dynamic block registration, floating widget mount rendering, and inquiry form integration enqueue.
- Added dynamic block scaffold at `blocks/product-selector` with minimal valid `block.json`, dynamic `render.php`, editor placeholder script, and editor style.
- Added frontend asset scaffolds for future Interactivity store and inquiry-form autofill integration.
- Kept implementation architecture-only with no product selection business logic, no REST routes, and no admin settings pages.

## Validation Performed
- PHP syntax validation: `php -l` passed for all PHP files.
- Class loading validation: verified all required included class files exist and are resolvable from bootstrap includes.
- Plugin bootstrap validation: verified main plugin file parses successfully and block metadata JSON is valid (`jq`).
