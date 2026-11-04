---
title: Icons
sidebar_position: 24
---

# Icons

The components draw their icons (the date picker's calendar, the clear button's ×, upload and download icons, …) as inline [Lucide](https://lucide.dev) SVGs, so no icon font is needed. `<x-forms::icon>` renders the same icons in your own markup, and the `icons` config changes which icon each component uses.

## Showing an icon

```blade
<x-forms::icon name="calendar" />

<x-forms::icon name="circle-check" class="size-5 text-success" />
```

```html
<svg class="forms-icon size-5 text-success" aria-hidden="true" focusable="false" data-icon-name="circle-check" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">…</svg>
```

Icons are `1em` square and use the text colour (`currentColor`), so they follow the surrounding font size and colour. They're hidden from screen readers; give icon-only buttons an `aria-label`:

```blade
<x-forms::button type="button" size="icon" color="light" aria-label="{{ __('Delete') }}">
    <x-forms::icon name="trash-2" />
</x-forms::button>
```

In right-to-left pages, flip arrows yourself: `<x-forms::icon name="chevron-right" class="rtl:rotate-180" />`.

## Bundled icons

These Lucide icons are bundled (`resources/icons/icons.php`):

`arrow-down`, `arrow-up`, `arrow-up-down`, `calendar`, `check`, `chevron-down`, `chevron-left`, `chevron-right`, `chevron-up`, `circle-alert`, `circle-check`, `circle-x`, `clock`, `download`, `ellipsis`, `external-link`, `eye`, `file`, `file-text`, `image`, `info`, `loader-circle`, `map-pin`, `pencil`, `plus`, `search`, `trash-2`, `triangle-alert`, `upload`, `x`.

For any other icon, use an icon font (below) or your own SVG.

## How a name is resolved

`name`, and every icon attribute on other components (`icon`, `start-icon`, `clear-icon`, nav tab `icon`, …), is looked up in this order:

1. A bundled icon name renders that SVG.
2. Otherwise it's looked up as a key in the `icons` config: first `frameworks.<framework>.icons.<name>`, then `icons.<name>`. If the value is a bundled name, that SVG renders.
3. Anything else renders as `<i class="{value}" aria-hidden="true"></i>`, for an icon font.

```blade
{{-- the icon configured for "date" (calendar) --}}
<x-forms::icon name="date" />

{{-- an icon font --}}
<x-forms::icon name="fa-solid fa-mosque" />
```

## Changing the components' icons

`config/forms.php` maps each place an icon appears to an icon:

| Key | Default | Used by |
| --- | --- | --- |
| `date` | `calendar` | `date` |
| `datetime` | `calendar` | `datetime` |
| `time` | `clock` | `time` |
| `clear` | `x` | Clear buttons of dates and files |
| `download` | `download` | Link to the current file in `file` |
| `upload` | `upload` | Upload buttons of `file-upload` and `image-upload` |
| `image` | `image` | Empty `image` preview |
| `search` | `search` | `search-form`'s `icon` (the current views don't render it) |
| `no_items` | `file` | `no-items` |
| `create` | `plus` | The Create New button of `no-items` |
| `sort`, `sort_asc`, `sort_desc` | `arrow-up-down`, `arrow-up`, `arrow-down` | Not used by the current views; available as `<x-forms::icon name="sort_asc">` |
| `alert_success`, `alert_danger`, `alert_warning`, `alert_info` | `circle-check`, `circle-x`, `triangle-alert`, `info` | `<x-forms::alert icon="alert_success">` |

Set a value to a bundled name, or to icon font classes:

```php
// config/forms.php
'icons' => [
    'date' => 'calendar',
    'clear' => 'circle-x',
    'no_items' => 'fa-regular fa-folder-open',
],
```

Override an icon for one framework under `frameworks.<name>.icons`:

```php
'frameworks' => [
    'bootstrap-6' => [
        'icons' => [
            'clear' => 'fa-solid fa-xmark',
        ],
    ],
],
```

## Using an icon font

Values that aren't bundled names render as `<i>` tags, so the font's CSS has to be on the page. For Font Awesome:

```bash
npm install @fortawesome/fontawesome-free
```

```css
@import "@fortawesome/fontawesome-free/css/all.css";
```

## Attributes

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | required | Bundled icon, `icons` config key, or icon font classes. |
| `framework` | `string` | config | Framework whose `icons` overrides apply. |

Other attributes (`class`, `hidden`, `data-*`) go on the `<svg>` or `<i>`.

## React

`<x-forms::icon>` is Blade only. React uses Onu's `Icon`. See [Parity](../parity.md).
