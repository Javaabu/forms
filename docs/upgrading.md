---
title: Upgrading from v1
sidebar_position: 1.5
---

# Upgrading from v1 to v2

v2 keeps every component name and attribute from v1, so most Blade templates keep working unchanged. What changes is the CSS framework the components render for, a few config keys, and how icons and scripts are loaded.

## Requirements

- PHP 8.4 or newer.
- Laravel 12 or 13.
- `javaabu/settings` is no longer required. See [Defaults](#defaults-no-longer-need-javaabusettings).

```bash
composer require javaabu/forms:^2.0
```

## Frameworks

**`bootstrap-5` and `material-admin-26` are removed.** v2 renders for:

| Framework     | What it is                                                                                 |
| ------------- | ------------------------------------------------------------------------------------------ |
| `onu`         | Tailwind CSS with the tokens and classes of [`@javaabu/onu`](https://github.com/Javaabu/onu). The default. |
| `bootstrap-6` | Bootstrap 6 (targets `6.0.0-alpha.1`).                                                     |

Set the framework in `config/forms.php` (or with `FORMS_FRAMEWORK` in `.env`):

```php
'framework' => env('FORMS_FRAMEWORK', 'onu'),
```

If your app stays on Bootstrap 5 or Material Admin for now, stay on `javaabu/forms` 1.x (`^1.71`).

### Moving from `bootstrap-5` to `bootstrap-6`

Your templates don't change; the HTML the components output does. If you wrote CSS or JS against the old markup, update it:

| v1 (`bootstrap-5`)                                | v2 (`bootstrap-6`)                                                                   |
| ------------------------------------------------- | ------------------------------------------------------------------------------------ |
| `.form-select`                                    | `.form-control` on the `<select>`                                                    |
| `.form-check` > `.form-check-input` + `.form-check-label` | `.form-field` > `input.check` / `input.radio` + `label.check-label` / `label.radio-label` |
| `.form-text` `<div>`                              | `.form-text` `<small>`                                                               |
| `.btn.btn-primary`, `.btn.btn-outline-danger`     | `.btn-solid.theme-primary`, `.btn-outline.theme-danger`                              |
| `.badge.text-bg-success` (status)                 | `.badge.theme-success`                                                               |
| `.alert.alert-danger.alert-dismissible`           | `.alert.theme-danger` with a `.btn-close` inside                                     |
| Modal: `.modal` > `.modal-dialog` > `.modal-content` | `<dialog class="dialog dialog-lg">` with `.dialog-header`, `.dialog-body`, `.dialog-footer`; open it with `data-bs-toggle="dialog"` |
| Accordion: `.accordion-button` + `.accordion-collapse` | `<details class="accordion-item">` > `<summary class="accordion-header">` + `.accordion-body` |
| `col-sm-3 col-lg-2` (inline fields)              | `sm:col-3 lg:col-2`                                                                   |
| Export dropdown (`.dropdown-menu`)                | Bootstrap 6 menu (`data-bs-toggle="menu"`, `.menu`, `.menu-item`)                    |

Every component also gets the field markup Bootstrap 6 expects: each field is wrapped in a `.form-field`, and invalid controls get `aria-invalid="true"` as well as `.is-invalid`.

`<x-forms::modal>` takes a new `size` attribute (`sm`, `lg`, `xl`, `fullscreen`; default `lg`). The v1 `modal-size-class` still works: `modal-xl` becomes `dialog-xl`.

## Config

Publish the new config and compare it with yours:

```bash
php artisan vendor:publish --tag=forms-config --force
```

- `framework` defaults to `onu`.
- Framework settings use snake_case keys: `inline-label-class` → `inline_label_class`, `inline-input-class` → `inline_input_class`, `inline-entry-label-class` → `inline_entry_label_class`, `inline-entry-class` → `inline_entry_class`, `date-clear-btn-class` → `date_clear_btn_class`, `date-icon-wrapper-class` → `date_icon_wrapper_class`.
- The `frameworks.*.icon-prefix` and `frameworks.*.*-icon` keys are replaced by one `icons` array. See [Icons](#icons).
- New `defaults` array: `per_page`, `default_lat`, `default_lng`.

## Icons

v1 output icon-font classes (Font Awesome or Material Design Iconic Font) and needed the font on the page. v2 renders [Lucide](https://lucide.dev) icons as inline SVG, so no icon font is needed. The `icons` config maps each place an icon appears to an icon:

```php
'icons' => [
    'date' => 'calendar',
    'clear' => 'x',
    'upload' => 'upload',
    // ...
],
```

To keep using an icon font, set a value to its CSS classes; anything that isn't a bundled icon name renders as `<i class="…">`:

```php
'icons' => [
    'date' => 'fa-regular fa-calendar',
],
```

Icon attributes on components (`icon="…"` on `<x-forms::alert>`, `<x-forms::date>`, `<x-forms::no-items>`, nav tab items, …) accept either form too. You can also use the icon component on its own: `<x-forms::icon name="calendar" />`.

## Defaults no longer need javaabu/settings

`<x-forms::per-page>` and `<x-forms::map-input>` used `get_setting('per_page')`, `get_setting('default_lat')` and `get_setting('default_lng')`. v2 reads `forms.defaults.*` first, then `get_setting()` when javaabu/settings is installed, then falls back to 20 per page and Malé for the map centre. If you use javaabu/settings, nothing changes.

## Translations

Strings that were hard-coded English in v1 are now in `lang/{en,dv}/strings.php` under the `forms::` namespace: `Clear`, `Filter`, `Export`, `Apply`, `Bulk Action`, `Select All`, `Create New`, and the pagination summary. If you translated them through your app's JSON translations (`__('Filter')`), move those translations to `lang/vendor/forms/{locale}/strings.php`:

```bash
php artisan vendor:publish --tag=forms-translations
```

## Bug fixes you might notice

- Components no longer throw when a view renders without a session (mail, queued jobs, console). There are simply no validation errors to show.
- `<x-forms::modal>` without a `footer` slot no longer throws.
- `<textarea>` no longer gets an invalid `type` attribute.
