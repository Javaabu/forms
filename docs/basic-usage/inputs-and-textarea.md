---
title: Inputs and textarea
sidebar_position: 3
---

# Inputs and textarea

Each input component renders a complete field: the wrapper, the label, the control, help text and validation errors. Only `name` is required.

```blade
<x-forms::text name="company_name" />
```

The label is generated from the name (`company_name` → "Company Name") and passed through `trans()`, so you can translate it in your JSON translations. The id is generated from the name too (`address[city]` → `address-city`).

## Input types

Use the component for the type you need:

```blade
<x-forms::text name="name" label="ނަން" />
<x-forms::email name="email" />
<x-forms::password name="password" />
<x-forms::number name="quantity" />
<x-forms::tel name="phone" label="ފޯނު ނަންބަރު" />
<x-forms::url name="website" />
<x-forms::hidden name="redirect_to" :default="url()->previous()" />
```

For any other HTML input type, use `<x-forms::input>` with `type`:

```blade
<x-forms::input type="color" name="brand_color" />
<x-forms::input type="search" name="q" />
```

A `color` input with no value starts at `#000000`.

- `password` inputs are never filled from the model or old input.
- `hidden` inputs render only the `<input>`, with no wrapper, label or errors.

## Labels

```blade
{{-- Plain text --}}
<x-forms::text name="name" label="ނަން" />

{{-- Translated --}}
<x-forms::text name="name" :label="__('Full name')" />

{{-- No label and no wrapper: just the control, help and errors --}}
<x-forms::text name="search" :show-label="false" placeholder="ހޯދާ…" />
```

`:show-label="false"` removes the field wrapper along with the label, which is useful in table filters and inline forms. To build a field from parts instead, see [Labels, help and errors](./labels-help-and-errors.md).

## Required fields

`required` adds the HTML `required` attribute and a `*` after the label:

```blade
<x-forms::email name="email" required />
```

The marker comes from the `required_text` string. See [Labels, help and errors](./labels-help-and-errors.md#required-marker) to change it.

## Placeholders

```blade
<x-forms::text name="name" placeholder="ނަން ލިޔުއްވާ" />

{{-- Use the label as the placeholder --}}
<x-forms::text name="name" label="ނަން" show-placeholder />
```

## Help text

Put help text in the `help` slot. It renders below the control:

```blade
<x-forms::text name="username">
    <x-slot:help>
        {{ __('Letters and numbers only.') }}
    </x-slot:help>
</x-forms::text>
```

Attributes on the slot go to the help element: `<x-slot:help class="italic">`.

## Text before or after the control

Use the `prepend` and `append` slots on `input` and its aliases:

```blade
<x-forms::number name="price" label="އަގު" decimals="2" step="0.01">
    <x-slot:prepend>MVR</x-slot:prepend>
</x-forms::number>

<x-forms::text name="subdomain">
    <x-slot:append>.example.mv</x-slot:append>
</x-forms::text>
```

In `onu`, the slot content is wrapped in Onu's input group addon, so plain text is enough. In `bootstrap-6`, the slot is placed inside `.input-group` as it is, so wrap text in `.input-group-text` yourself:

```blade
<x-forms::number name="price" framework="bootstrap-6">
    <x-slot:prepend><span class="input-group-text">MVR</span></x-slot:prepend>
</x-forms::number>
```

## Inline (horizontal) layout

`inline` puts the label beside the control:

```blade
<x-forms::text name="name" label="ނަން" inline />
```

- `onu` uses Onu's inline field layout, which places the label beside the control when the field is wide enough and above it when it isn't. The label width comes from Onu's `--onu-label-width` variable.
- `bootstrap-6` uses a grid row. The column classes come from `frameworks.bootstrap-6.inline_label_class` (`sm:col-3 lg:col-2 col-form-label`) and `inline_input_class` (`sm:col-9 lg:col-10`) in `config/forms.php`.

Override the classes for one field with `inline-label-class` and `inline-input-class`. In `onu` they're added to the label and control wrappers:

```blade
<x-forms::text name="name" inline inline-label-class="sm:col-4" inline-input-class="sm:col-8" framework="bootstrap-6" />
```

## Floating labels

`floating` renders a Bootstrap floating label in `bootstrap-6`. Onu has no floating labels, so in `onu` the label stays above the control.

```blade
<x-forms::email name="email" floating framework="bootstrap-6" />
```

## Dhivehi (Thaana) fields

Add `thaana` to a free-text field that holds Dhivehi. The field gets `dir="rtl" lang="dv"` and the Thaana keyboard: typing on a Latin keyboard enters Thaana letters (the phonetic layout, like Onu's React inputs). Alt+Shift+T turns the keyboard off and on.

```blade
<x-forms::text name="name_dv" label="ނަން" thaana />
<x-forms::textarea name="address_dv" label="އެޑްރެސް" thaana />
```

To use another keyboard layout, add `data-thaana-keymap="phonetic-hh"` or `data-thaana-keymap="typewriter"`. Labels and values in Thaana need no option; only the typing does. See [Translations, Dhivehi and RTL](../advanced-usage/translations-and-rtl.md).

## Numbers

`decimals` rounds a number to that many decimal places when the field changes or loses focus. Use it with a matching `step`:

```blade
<x-forms::number name="amount" label="އަދަދު" decimals="2" step="0.01" min="0" />
```

`latitude` and `longitude` are number inputs with `step="0.000001"` and the valid range (`-90` to `90`, `-180` to `180`):

```blade
<x-forms::latitude name="lat" />
<x-forms::longitude name="lng" />
```

For a map picker, see [Map input](./map-input.md).

## Textarea

```blade
<x-forms::textarea name="description" label="ތަފްޞީލް" :rows="5" thaana />
```

- `rows` sets the height (default `3`).
- `auto-resize` makes the textarea grow and shrink with its content.
- `value` sets the content directly, ignoring the model, `default` and old input.
- `wysiwyg` turns it into a rich text editor. See [WYSIWYG](./wysiwyg.md).

```blade
<x-forms::textarea name="notes" auto-resize />
```

## Classes on the wrapper

`form-group-class` adds classes to the field's wrapper, for example to place it in a grid:

```blade
<div class="grid grid-cols-2 gap-4">
    <x-forms::text name="first_name" />
    <x-forms::text name="last_name" />
    <x-forms::textarea name="address" form-group-class="col-span-2" />
</div>
```

Any other attribute, such as `id`, `class`, `maxlength`, `autocomplete`, `disabled`, `readonly` or `data-*`, goes on the control itself:

```blade
<x-forms::text name="national_id" id="nid" maxlength="7" autocomplete="off" />
```

## Errors

A field shows the first validation error for its name and marks the control invalid (`aria-invalid="true"` and `.is-invalid`). For array fields (`tags[]`), errors for `tags.*` are shown too. Turn this off with `:show-errors="false"`. See [Labels, help and errors](./labels-help-and-errors.md).

## Rendered HTML

For writing your own CSS, this is what `<x-forms::text name="title" label="ސުރުހީ" required>` with help text and an error renders. Onu's long Tailwind class lists are shortened to `…`.

`onu`:

```html
<div class="… mb-4" data-slot="form-field" data-label-layout="stacked">
    <div class="gap-2 grid">
        <div class="…">
            <label class="…" for="title" data-slot="label">
                ސުރުހީ <span class="required text-destructive" data-slot="required-marker" aria-hidden="true">*</span>
            </label>
        </div>
        <div class="min-w-0 gap-1.5 grid">
            <input class="… is-invalid" required aria-invalid="true" data-slot="input" type="text" value="" name="title" id="title" />
            <p class="text-sm text-muted-foreground" data-slot="help-text">Help</p>
            <div class="invalid-feedback …" data-slot="field-errors" aria-live="polite">
                <p class="gap-1.5 flex items-start"><svg data-icon-name="circle-alert" …></svg> <span>ސުރުހީ ލިޔުއްވާ.</span></p>
            </div>
        </div>
    </div>
</div>
```

`bootstrap-6`:

```html
<div class="form-field mb-4">
    <label class="form-label" for="title">
        ސުރުހީ <span class="required fg-danger" aria-hidden="true">*</span>
    </label>
    <input class="form-control is-invalid" required aria-invalid="true" type="text" value="" name="title" id="title" />
    <small class="form-text">Help</small>
    <div class="invalid-feedback d-block">ސުރުހީ ލިޔުއްވާ.</div>
</div>
```

## Attributes

### `input`, `text`, `email`, `password`, `number`, `url`, `latitude`, `longitude`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | required | Field name. Also gives the id, the bound attribute, the old input key and the error key. |
| `type` | `string` | `'text'` | HTML input type. `input` only; the aliases set it. |
| `label` | `string` | from `name` | Label text. |
| `model` | `mixed` | bound model | Model to read the value from. `false` turns binding off. |
| `default` | `mixed` | `null` | Value used when there is no old input and no model value. |
| `placeholder` | `string` | `''` | Placeholder text. |
| `show-placeholder` | `bool` | `false` | Uses the label as the placeholder when `placeholder` is empty. |
| `required` | `bool` | `false` | Adds `required` and the required marker. |
| `show-label` | `bool` | `true` | `false` removes the label and the field wrapper. |
| `show-errors` | `bool` | `true` | Shows validation errors and marks the control invalid. |
| `inline` | `bool` | `false` | Label beside the control. |
| `inline-label-class` | `string` | config | Classes for the label column in an inline field. |
| `inline-input-class` | `string` | config | Classes for the control column in an inline field. |
| `floating` | `bool` | `false` | Floating label (`bootstrap-6` only). |
| `show-js-errors` | `bool` | `false` | Adds an empty error list for JavaScript validation. See [`js-errors`](./labels-help-and-errors.md#errors-from-javascript-validation). |
| `form-group-class` | `string` | `''` | Classes on the field wrapper. |
| `thaana` | `bool` | `false` | Right-to-left Dhivehi field with the Thaana keyboard. |
| `decimals` | `int` | `null` | Rounds the number to this many decimals (number inputs). |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

`tel` takes the same attributes except `placeholder` and `show-placeholder` (a `placeholder` attribute still reaches the control as plain HTML). `hidden` takes `name`, `label`, `model`, `default`, `show-errors`, `show-label`, `required`, `inline`, `floating`, `show-js-errors` and `framework`.

Slots: `help`, `prepend`, `append`.

### `textarea`

The attributes of `text` (except `type` and `decimals`), and:

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `rows` | `int` | `3` | Number of rows. |
| `value` | `mixed` | `null` | Content of the textarea. Replaces the model value, `default` and old input. |
| `auto-resize` | `bool` | `false` | Grows and shrinks with the content. |
| `wysiwyg` | `bool` | `false` | Rich text editor. See [WYSIWYG](./wysiwyg.md). |

Slot: `help`.

## React

```jsx
import { Text, Number, Textarea } from "@javaabu/forms"

<Text name="name_dv" label="ނަން" thaana required />
<Number name="amount" decimals={2} step="0.01" />
<Textarea name="notes" autoResize rows={5} />
```

The `help`, `prepend` and `append` slots are props of the same name. `floating` and `show-js-errors` are Blade only. See [Parity](../parity.md).
