---
title: Translations, Dhivehi and RTL
sidebar_position: 5
---

# Translations, Dhivehi and RTL

## Strings

Every text the components show is in `lang/{en,dv}/strings.php`, under the `forms::strings` namespace: placeholders like `Nothing Selected`, button texts like `Filter` and `Clear`, file input texts, the error summary heading, pagination, and the JavaScript messages (`Loading...`, upload errors). The keys are the same as the locales of `@javaabu/forms` (React), so a translation can be copied between them.

To change a text, publish the translations and edit your copy:

```bash
php artisan vendor:publish --tag=forms-translations
```

```php
// lang/vendor/forms/dv/strings.php
return [
    'filter' => 'ހޯދާ',
    // ...
];
```

Labels generated from field names (`first_name` → `First Name`) go through `__()`, so add them to your app's JSON translations for Dhivehi: `"First Name": "ފުރަތަމަ ނަން"`.

The JavaScript gets the English and Dhivehi strings bundled, and uses the language of the page (`<html lang="dv">`). Strings you load into [`@javaabu/i18n`](https://github.com/Javaabu/i18n) (for example with `window.Lang`) under `forms::strings` take precedence.

## Right-to-left pages

Set the direction on the page:

```blade
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'dv' ? 'rtl' : 'ltr' }}">
```

Both frameworks lay out with logical properties (`ms-`/`me-`, `ps-`/`pe-`, `start`/`end`), so labels, icons, input groups, pagination arrows and dropdowns flip without extra CSS.

## Thaana fields

Add `thaana` to a free-text field that holds Dhivehi:

```blade
<x-forms::text name="name_dv" label="ނަން" thaana />
<x-forms::textarea name="description_dv" label="ތަފްޞީލް" thaana />
```

The field gets `dir="rtl" lang="dv"`, the Thaana font from Onu's styles, and the Thaana keyboard: typing on a Latin keyboard enters Thaana (the phonetic layout), as in Onu's React inputs.

## Dhivehi translations for review

The Dhivehi lines were written by an AI assistant and should be checked by a Dhivehi speaker before release. Lines shared with `@javaabu/forms` use the same text in both packages. These are the ones most worth a second look:

| Key | English | Dhivehi |
| --- | --- | --- |
| `pagination_showing` | Showing :count from total :total entries | ޖުމްލަ :total އިން :count ދައްކަނީ |
| `per_page` | Per page | ކޮންމެ ޞަފްޙާއެއްގައި |
| `export_title` | Export to XLSX | XLSX އަށް އެކްސްޕޯޓްކުރޭ |
| `export_options` | More export options | އިތުރު އެކްސްޕޯޓް އޮޕްޝަންތައް |
| `sections` | Sections | ސެކްޝަންތައް |
| `select_row` | Select :name | :name ޚިޔާރުކުރޭ |
| `no_items_title` | It's a bit lonely here. | މިތާ އަދި އެއްވެސް އެއްޗެއް ނެތް. |
| `no_items_message` | Let's create some new :model_type. | އައު :model_type ހަދާލަމާ. |
| `bulk_action` | Bulk Action | އެއްފަހަރާ ކުރާ ކަންކަން |
| `error_summary_title` | Please correct the errors below. | ތިރީގައިވާ ގޯސްތައް ރަނގަޅުކުރައްވާ. |
| `no_results` | No results found | އެއްވެސް ނަތީޖާއެއް ނުފެނުނު |
| `file_type_not_allowed` | Only :accept files are allowed. | ހަމައެކަނި :accept ފައިލް. |

Dhivehi has no plural forms in Laravel, so `trans_choice()` lines have a single Dhivehi form.
