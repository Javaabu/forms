---
title: Configuration
sidebar_position: 1
---

# Configuration

Everything has a default, so the package works without publishing the config. To change something, publish `config/forms.php`:

```bash
php artisan vendor:publish --tag=forms-config
```

| Key | Default | What it does |
| --- | --- | --- |
| `framework` | `env('FORMS_FRAMEWORK', 'onu')` | The framework components render for: `onu` or `bootstrap-6`. Any component can override it with `framework="…"`. |
| `use_eloquent_date_casting` | `false` | When `true`, date inputs format bound model dates with the model's own date casts instead of the input's format. |
| `defaults.per_page` | `null` (20) | The selected amount of `<x-forms::per-page>` when the request has no `per_page`. `null` reads `get_setting('per_page')` from javaabu/settings when installed, then falls back to 20. |
| `defaults.default_lat`, `defaults.default_lng` | `null` (Malé) | The map centre of `<x-forms::map-input>`. `null` reads `get_setting()`, then falls back to Malé (4.1755, 73.5093). |
| `defaults.max_upload_file_size` | `null` (10240 KB) | The file size limit (in KB) of `file` and `image` inputs without `max-size`, when javaabu/settings isn't installed. |
| `icons.*` | Lucide names | The icon each component uses. See [Icons](../basic-usage/icons.md). |
| `frameworks.{name}.inline_label_class` | Bootstrap 6: `sm:col-3 lg:col-2 col-form-label`; Onu: `''` | Classes for the label of `inline` fields. |
| `frameworks.{name}.inline_input_class` | Bootstrap 6: `sm:col-9 lg:col-10`; Onu: `''` | Classes for the control column of `inline` fields. |
| `frameworks.{name}.inline_entry_label_class`, `inline_entry_class` | Bootstrap 6: `sm:col-6 md:col-4`, `sm:col-6 md:col-8` | The same for `inline` text entries. |
| `frameworks.{name}.date_icon_wrapper_class`, `date_clear_btn_class` | `''` | Extra classes for the date icon and clear button. |
| `frameworks.{name}.icons.*` | — | Icons for one framework only, over `icons.*`. |
| `assets.enabled` | `env('FORMS_ASSETS', true)` | Load the components' JavaScript and CSS through javaabu/manifest. Turn off to load your own. |
| `assets.styles` | `env('FORMS_STYLES', true)` | Load the prebuilt Onu stylesheet on pages with `onu` components. Turn off when your Tailwind build imports `resources/css/onu.css`. |
| `scripts_stack` | `scripts` | The stack the Google Maps and TinyMCE scripts are pushed to. |
| `wysiwyg.tinymce_url` | `env('TINYMCE_URL')` | Where TinyMCE is loaded from. Defaults to `asset('vendors/tinymce/tinymce.min.js')`. |
| `map_api_key` | `env('MAP_API_KEY')` | Google Maps API key for `<x-forms::map-input>`. |

Framework settings are merged with the package defaults key by key, so a published config only needs the keys you change:

```php
'frameworks' => [
    'bootstrap-6' => [
        'inline_label_class' => 'md:col-4 col-form-label',
        'inline_input_class' => 'md:col-8',
    ],
],
```

## Switching framework per request

The `forms` middleware sets the framework for a route or group, for example an admin area on Bootstrap 6 while the rest of the app uses Onu:

```php
Route::middleware('forms:bootstrap-6')->group(function () {
    // ...
});
```
