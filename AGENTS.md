# AGENTS.md

## Project Identity

This repository contains the standalone WordPress plugin `epdc-product-selector`.

The plugin provides a reusable product inquiry selection system for catalog-based WordPress websites.

Visitors can:

- select products from category or product pages,
- persist those selections across navigation,
- review selections inside a floating inquiry widget,
- and submit those selections through a standard inquiry form.

This plugin is not an ecommerce checkout system.

This is a dynamic product lead capture and inquiry assistance plugin.

All development decisions must preserve reusability, portability, and WordPress-native architecture.

---

## Mandatory Skill Resolution

Before implementing any task, always consult the relevant local skill documentation inside `.codex/skills/`.

Use these routing rules:

- General plugin bootstrap, file organization, hooks, activation patterns:
	see `.codex/skills/wp-plugin-development`

- Dynamic block registration, block.json structure, render callbacks, editor integration:
	see `.codex/skills/wp-block-development`

- Frontend state management, stores, directives, context, actions:
	see `.codex/skills/wp-interactivity-api`

- REST endpoints, route registration, permissions, async handlers:
	see `.codex/skills/wp-rest-api`

- WP CLI verification, debug inspection, validation commands:
	see `.codex/skills/wp-wpcli-and-ops`

- Static analysis and strict PHP validation:
	see `.codex/skills/wp-phpstan`

- WordPress coding standards and official architecture patterns:
	see `.codex/skills/wpds`

Never skip skill consultation when a task touches one of these domains.

Do not invent architecture that contradicts these local skills.

---

## Core Product Architecture

This plugin must be built around four isolated systems:

### 1. Dynamic Product Selector Block

A reusable dynamic block inserted inside product cards, category layouts, or manual pages.

This block outputs a product selection trigger and exposes structured product metadata to the frontend interaction layer.

The block must remain presentation-light and data-focused.

---

### 2. Global Interactivity State Engine

A centralized Interactivity API store must manage:

- selected products
- add/remove actions
- duplicate prevention
- localStorage persistence
- selection counts
- inquiry payload formatting

Do not use ad hoc DOM listeners when state directives can handle the behavior.

---

### 3. Floating Inquiry Widget

A globally injected floating widget must render on the frontend and stay synchronized with the Interactivity store.

This widget must:

- display current selected products
- allow removal
- allow clear selection
- redirect user to inquiry page

The widget must not require manual block insertion.

---

### 4. Inquiry Form Autofill Integration

A lightweight frontend integration layer must detect a designated inquiry form field and populate it automatically using the current stored product selection.

The implementation must remain form-plugin agnostic.

Do not hardcode Gravity Forms, Forminator, Ninja Forms, or Contact Form 7 specific logic unless abstraction is necessary.

---

## Development Directives

- Use PHP 8+.
- Use modular OOP classes.
- Use WordPress native hooks and APIs.
- Use dynamic rendering, not static saved markup.
- Use the Interactivity API for shared frontend state.
- Keep JavaScript framework usage minimal.
- Do not introduce unnecessary third party packages.
- Do not hardcode client-specific content.
- All user-facing strings must be translatable.
- Every class must have a single responsibility.

Avoid procedural file sprawl.

Avoid oversized utility abstractions.

Avoid premature settings pages unless the task explicitly requires them.

---

## Coding Standards

### PHP

- Follow WordPress Coding Standards.
- Use short array syntax `[]`.
- Use explicit escaping and sanitization.
- Keep hooks registered inside dedicated classes.

### JavaScript

- Use ES6+.
- Use `const` and `let`, never `var`.
- Keep functions small and declarative.
- Prefer store actions over manual imperative DOM mutation when possible.

### General

- Use tabs, not spaces.
- Use single quotes.
- Keep comments concise and in English.
- Do not write dead scaffolding.

---

## Required Task Workflow

For every requested implementation:

1. Read this AGENTS.md.
2. Read all relevant `.codex/skills/` documentation.
3. Inspect existing repository code before adding files.
4. Create a new local feature branch from `main` before starting implementation.
5. Implement only the scoped task.
6. Keep changes production-safe and minimal.
7. Create one local commit at task completion with a concise descriptive commit message.
8. After task completion, write a task log under:

`.context/YYYY-MM-DD-task-name.md`

Each task log must include:

- task objective
- files created or modified
- implementation summary
- validation performed

9. Do not push branches to remote.
10. Do not merge into `main`.

---

## Validation Workflow

Before considering a task complete, always validate with the appropriate available methods:

- PHP linting
- WordPress syntax verification
- WP CLI inspection when relevant
- block registration verification
- Interactivity directive verification
- frontend runtime inspection

Never mark tasks complete without validation notes in the task log.

---

## Current MVP Goal

Build Version 1 of EPDC Product Selector with:

- dynamic product selector block
- shared Interactivity API product store
- localStorage persistence
- floating inquiry widget
- inquiry form field auto population

Do not build future enhancements unless explicitly requested.

Future enhancements such as analytics, REST persistence, admin settings, or WhatsApp inquiry flow are outside current scope.