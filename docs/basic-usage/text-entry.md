---
title: Text entries and infolists
sidebar_position: 21
---

# Text entries and infolists

Text entries show a record's values on a details page: a label and a formatted value, read from the bound model like form fields. `<x-forms::infolist>` groups them in a card.

## Showing a record

```blade
<x-forms::infolist :title="__('Application')" :model="$application">
    <x-forms::text-entry name="name" label="ނަން" />
    <x-forms::text-entry name="email" />
    <x-forms::text-entry name="status" />
    <x-forms::boolean-entry name="is_verified" :label="__('Verified')" />
</x-forms::infolist>
```

`infolist` is a [card](./card.md) that binds `model` for the entries inside it. Outside an infolist, bind with `@model` or pass `model` to each entry:

```blade
@model($application)
    <x-forms::text-entry name="name" label="ނަން" />
@endmodel

<x-forms::text-entry name="name" :model="$application" />
```

## How values are shown

`text-entry` picks the first that applies:

| Value | Shown as |
| --- | --- |
| The slot | The slot, as you wrote it. |
| A model with an `admin_link` accessor | Its `admin_link` (HTML). A collection of them is joined with commas. |
| A backed enum with `getColor()` | A [status badge](./status.md) with the enum's label. |
| A backed enum with `getLabel()` | The label. |
| Anything, with `multiline` | Text with line breaks kept. |
| An array | A bulleted list. |
| HTML, with `wysiwyg` | The HTML, unescaped. |
| Empty (`null`, `''`, `[]`) | "-" (the `blank` string). `0` is shown as `0`. |
| Anything else | The escaped value. |

```blade
<x-forms::text-entry name="address" label="އެޑްރެސް" multiline />

<x-forms::text-entry :label="__('Website')">
    <a href="{{ $application->website }}">{{ $application->website }}</a>
</x-forms::text-entry>

<x-forms::text-entry :label="__('Tags')" :value="$application->tags->pluck('name')->all()" />
```

`value` replaces the bound attribute. Without `name` or `value`, the entry shows "-".

### HTML content

`wysiwyg` outputs the value as HTML, for content saved from a [WYSIWYG](./wysiwyg.md) field. Only use it for HTML you trust or have sanitized.

```blade
<x-forms::text-entry name="body" wysiwyg />
```

## Yes and no

`text-entry` doesn't translate booleans. Use `<x-forms::boolean-entry>`, which shows "Yes" or "No" (translated), or "-" for `null`:

```blade
<x-forms::boolean-entry name="is_verified" label="ވެރިފައިކޮށްފައި" />
```

## Inline layout

`inline` puts the label beside the value:

```blade
<x-forms::text-entry name="name" label="ނަން" inline />
```

In `bootstrap-6` the columns come from `frameworks.bootstrap-6.inline_entry_label_class` (`sm:col-6 md:col-4`) and `inline_entry_class` (`sm:col-6 md:col-8`), or `inline-entry-label-class` and `inline-entry-class` on the entry. `onu` uses Onu's inline description list.

`infolist` has no layout option. Set `inline` on each entry.

## Formatting a value anywhere

`<x-forms::formatted-value>` outputs a value with the same rules as a [table cell](./tables-and-listings.md#cells), with no label or wrapper, for use in your own markup:

```blade
<p>{{ __('Status') }}: <x-forms::formatted-value :value="$application->status" /></p>

@model($application)
    <x-forms::formatted-value name="islands" />
@endmodel
```

It shows admin links, status badges, enum labels, "Yes"/"No" for booleans, arrays joined with commas, and "-" for empty values. `multiline` keeps line breaks.

## Rendered HTML

```html
<!-- onu (classes shortened) -->
<dl class="…" data-slot="description-list" data-layout="stacked">
    <div class="…" data-slot="description-list-item">
        <dt class="…" data-slot="description-list-label">ނަން</dt>
        <dd class="…" data-slot="description-list-value"><div class="min-w-0 flex-1">އަޙްމަދު</div></dd>
    </div>
</dl>

<!-- bootstrap-6 -->
<dl class="mb-1">
    <dt>ނަން</dt>
    <dd>އަޙްމަދު</dd>
</dl>
```

## Attributes

### `text-entry`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | `''` | Bound attribute to show. |
| `label` | `string` | from `name` | Label. |
| `value` | `mixed` | `null` | Value to show instead of the bound attribute. |
| `model` | `mixed` | bound model | Model to read from. |
| `show-label` | `bool` | `true` | Shows the label. |
| `inline` | `bool` | `false` | Label beside the value. |
| `multiline` | `bool` | `false` | Keeps line breaks. |
| `wysiwyg` | `bool` | `false` | Outputs the value as HTML. |
| `inline-entry-label-class` | `string` | config | Classes for the label column when `inline`. |
| `inline-entry-class` | `string` | config | Classes for the value column when `inline`. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Other attributes go on the `<dl>`. Slot: the value.

### `boolean-entry`

The attributes of `text-entry` except `multiline` and `wysiwyg`.

### `infolist`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `title` | `string` | `''` | Card title. |
| `model` | `mixed` | bound model | Model the entries read from. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Slots: those of [`card`](./card.md#attributes).

### `formatted-value`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | `''` | Bound attribute to show. |
| `value` | `mixed` | `null` | Value to show instead. |
| `model` | `mixed` | bound model | Model to read from. |
| `multiline` | `bool` | `false` | Keeps line breaks. |
| `framework` | `string` | config | `onu` or `bootstrap-6`, for status badges. |

## React

```jsx
import { Infolist, TextEntry, BooleanEntry, FormattedValue } from "@javaabu/forms"

<Infolist title="Application" model={application}>
  <TextEntry name="name" label="ނަން" />
  <BooleanEntry name="is_verified" />
</Infolist>

<FormattedValue value={application.status} />
```

React's `Infolist` has a `layout` prop that sets every entry; in Blade, set `inline` on each entry. See [Parity](../parity.md).
