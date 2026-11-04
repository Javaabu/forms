# Changelog

All notable changes are documented in this file. See [docs/upgrading.md](docs/upgrading.md) for moving from v1.

## 2.0.0 - Unreleased

### Added

- `onu` framework (the new default): the markup, `data-slot`s and Tailwind classes of `@javaabu/onu`, generated from Onu's own components (`resources/onu/classes.php`), plus `resources/css/onu.css` for Tailwind apps and a prebuilt stylesheet in `dist/`.
- `bootstrap-6` framework (Bootstrap 6.0.0-alpha.1).
- JavaScript and CSS shipped through javaabu/manifest and loaded only on pages that need them: core behaviours, Tom Select selects, flatpickr dates, file inputs, TinyMCE setup. No jQuery or js-utilities.
- Components: `error-summary`, `pagination`, `formatted-value`, `icon`.
- Attributes on every field: `form-group-class`, `thaana`. Also `auto-resize` (textarea), `decimals` (number), button `size`/`start-icon`/`end-icon`/`loading`, link button `disabled`, select2 `clearable`/`min-chars`/`parent`, modal `size`/`description`, errors `first-only`, file `multiple`, accordion item `disabled`, per-page `label`/`show-label`/`per-page`, and form `summary`/`summary-title`/`focus-on-error`/`error-bag`.
- `aria-invalid` on invalid controls.
- Lucide icons as inline SVG, with the `forms.icons` config.
- Dhivehi translations for every string, with RTL-safe layouts.
- `Frameworks::register()` for custom frameworks.
- `forms.defaults`, `forms.assets` and `forms.wysiwyg` config.
- Laravel Boost guideline and skill, `llms.txt`, docs for people and agents.

### Changed

- Requires PHP 8.4 and Laravel 12 or 13.
- Framework config keys are snake_case.
- Hard-coded English texts are now `forms::strings` translations.
- `javaabu/settings` is optional.

### Removed

- The `bootstrap-5` and `material-admin-26` frameworks.

### Fixed

- Components no longer need a session to render (mail, queues, console).
- `<x-forms::modal>` without a footer slot no longer throws.
- Paginator views no longer need component variables.
