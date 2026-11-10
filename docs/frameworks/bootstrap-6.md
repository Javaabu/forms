---
title: Bootstrap 6
sidebar_position: 2
---

# Bootstrap 6

The `bootstrap-6` framework outputs [Bootstrap 6](https://getbootstrap.com) markup. It targets **Bootstrap 6.0.0-alpha.1**, the only v6 release so far, and is updated as later pre-releases change markup.

```php
// config/forms.php
'framework' => 'bootstrap-6',
```

Or for one component: `<x-forms::text name="title" framework="bootstrap-6" />`.

## Including the styles

Install Bootstrap 6 and import it as you normally would:

```bash
npm install bootstrap@6.0.0-alpha.1
```

```scss
@use "bootstrap/scss/bootstrap";
```

Components that need JavaScript (dialogs, menus, tabs, dismissible alerts) use Bootstrap's own data attributes (`data-bs-toggle="dialog"`, `data-bs-dismiss="alert"`), so load Bootstrap's JavaScript bundle too.

## Markup

| Component | Markup |
| --- | --- |
| Fields | `.form-field` with `.form-label`, the control, `small.form-text` and `.invalid-feedback` |
| Select | `select.form-control` |
| Checkbox / radio | `input.check` / `input.radio` in a `.form-field` |
| Buttons | `btn-solid`, `btn-outline`, `btn-subtle` or `btn-link`, plus a `.theme-*` class |
| Status badge | `.badge.theme-*` |
| Alert | `.alert.theme-*`, with a `.btn-close` when dismissible |
| Modal | `<dialog class="dialog dialog-lg">` |
| Accordion | `<details class="accordion-item">` |
| Inline fields | `sm:col-3 lg:col-2` label, `sm:col-9 lg:col-10` control |

### Colours

`color` and `type` attributes keep the Bootstrap 5 names; the framework maps them to Bootstrap 6 classes:

| `color` | Classes |
| --- | --- |
| `primary`, `secondary`, `success`, `danger`, `warning`, `info` | `btn-solid theme-{color}` |
| `outline-{color}` | `btn-outline theme-{color}` |
| `light` | `btn-subtle theme-secondary` |
| `dark` | `btn-solid theme-inverse` |
| `link` | `btn-link` |

The mapping lives in `Javaabu\Forms\Frameworks\Bootstrap6`. To change it, extend the class and register it under the same name in a service provider:

```php
use Javaabu\Forms\Frameworks\Frameworks;

Frameworks::register('bootstrap-6', MyBootstrap6::class);
```
