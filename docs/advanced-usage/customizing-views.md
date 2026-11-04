---
title: Customizing views
sidebar_position: 3
---

# Customizing views

Each component renders `forms::{framework}.{view}`, for example `forms::onu.input`. When a framework has no view of its own, the shared `forms::common.{view}` is used (forms, table headings, per-page and so on).

## Publishing one view

```bash
php artisan forms:publish-view
```

Pick a file from the list, and it's copied to `resources/views/vendor/forms/…`. Laravel uses your copy instead of the package's. To copy everything:

```bash
php artisan vendor:publish --tag=forms-views
```

Only publish what you change: published views don't get the package's fixes and markup updates.

## Finding what changed after an update

```bash
php artisan forms:diff-views
```

It lists published views that are identical to the package's (safe to delete, so you get updates again) and the ones you've changed, so you can bring them up to date after upgrading.

## Data available in a view

A component's public properties and methods are available in its view: for an input, `$name`, `$label`, `$value`, `$required`, `$hasError($name)`, `$id()` and so on. Every view also has:

| Variable | What |
| --- | --- |
| `$framework` | The framework being rendered (`onu`, `bootstrap-6`) |
| `$frameworkClasses()` | The framework's class map (see [Custom frameworks](./custom-frameworks.md)). For Onu, `$frameworkClasses()->classes('input.input')` gives the classes Onu's input renders. |
| `$attributes` | The other attributes passed to the component |
| `$groupClass()`, `$thaanaAttributes()`, `$shouldAutoResize()`, `$decimalPlaces()` | The shared field options (`form-group-class`, `thaana`, `auto-resize`, `decimals`) |

## Classes and icons without publishing

Many changes need no published view:

- Add classes with `class="…"` (the control) and `form-group-class="…"` (the wrapper).
- Change inline layouts in `frameworks.{name}.inline_*` [config](./configuration.md).
- Change icons in the `icons` config. See [Icons](../basic-usage/icons.md).
- Change texts in the [translations](./translations-and-rtl.md).
