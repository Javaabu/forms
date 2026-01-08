---
title: Input and textarea elements
sidebar_position: 1
---


The `input` and `textarea` components are the workhorses of form creation. They handle labels, values, validation errors, and layout automatically.

## Basic Usage

The minimum requirement is the `name` attribute.

```html
<x-forms::input name="company_name" />
```

## Labels & Layout

You have full control over how labels are rendered.

### Standard Labels

You can provide a label directly or let the value be computed from the name (e.g., `company_name` -> "Company Name").

```html
<!-- Explicit Label -->
<x-forms::input name="company_name" label="Company Name" />

<!-- Translated Label -->
<x-forms::input name="company_name" :label="__('Company Name')" />
```

### Floating & Inline Labels

Support for different form layouts is built-in.

:::info
The column widths for `inline` labels are defined in your `forms.php` config file under `frameworks`.
:::

```html
<!-- Floating Label (Material Style) -->
<x-forms::input name="company_name" label="Company Name" floating />

<!-- Inline Label (Horizontal Form) -->
<x-forms::input name="company_name" label="Company Name" inline />
```

### No Label

If you need the input without the wrapping `form-group` or label:

```html
<x-forms::input name="search" placeholder="Search..." :show-label="false" />
```

## Validation & Required Fields

Validation errors are shown automatically directly below the input if they exist in the `$errors` bag.

### Required Indicator

Adding the `required` attribute automatically appends an asterisk `*` to the label to indicate the field is mandatory.

```html
<x-forms::input name="email" required />
```

You can customize the text (removing the `*` or changing it to `(Required)`) by publishing the translations.

### Hiding Errors

To suppress validation messages for a specific field:

```html
<x-forms::input name="username" :show-errors="false" />
```

## Available Options

| Prop | Type | Default | Description |
|---|---|---|---|
| `name` | `string` | **Required** | The name of the input field. Used for id, name, and error bag lookup. |
| `label` | `string` | `null` | The text for the label. If omitted, a title-cased version of `name` is tried. |
| `value` | `mixed` | `null` | The default value. If a model is bound to the form, that takes precedence. |
| `type` | `string` | `'text'` | The HTML input type (e.g., `text`, `email`, `password`). |
| `placeholder` | `string` | `null` | The placeholder text. |
| `required` | `bool` | `false` | If true, adds `required` attribute and appends `*` to label. |
| `inline` | `bool` | `false` | Renders the label and input side-by-side (horizontal layout). |
| `floating` | `bool` | `false` | Renders a floating label. |
| `show-label` | `bool` | `true` | Set to `false` to render only the input tag. |
| `show-errors` | `bool` | `true` | Set to `false` to hide validation errors. |
| `help` | `string` | `null` | Helper text to display below the input. |

## Available Components

For convenience, we provide aliases for common input types. These are all wrappers around the core `input` component.

```html
<x-forms::text name="text" />
<x-forms::password name="password" />
<x-forms::number name="number" />
<x-forms::hidden name="hidden" />
<x-forms::email name="email" />
<x-forms::url name="url" />
<x-forms::tel name="tel" />
```

### Special Inputs

Some inputs have extra logic:

*   **`<x-forms::latitude />`**: A number input restricted to `-90` to `90`.
*   **`<x-forms::longitude />`**: A number input restricted to `-180` to `180`.

```html
<x-forms::latitude name="lat" step="0.000001" />
<x-forms::longitude name="lng" step="0.000001" />
```
