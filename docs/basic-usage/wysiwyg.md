---
title: WYSIWYG
sidebar_position: 10
---

# WYSIWYG

`<x-forms::wysiwyg>` is a textarea that turns into a [TinyMCE](https://www.tiny.cloud) rich text editor. It submits HTML.

```blade
<x-forms::wysiwyg name="body" label="ލިޔުން" />

{{-- the same --}}
<x-forms::textarea name="body" label="ލިޔުން" wysiwyg />
```

## Setting up TinyMCE

TinyMCE isn't bundled with the package, because of its size and licence. Your app hosts it:

1. Install it and copy it to `public/`, for example to `public/vendors/tinymce`:

    ```bash
    npm install tinymce@^7
    cp -r node_modules/tinymce public/vendors/tinymce
    ```

2. Render the `scripts` stack in your layout, before `</body>`. The component pushes TinyMCE's `<script>` tag to it once per page:

    ```blade
        @stack('scripts')
    </body>
    ```

The script is loaded from `asset('vendors/tinymce/tinymce.min.js')`. To load it from somewhere else, such as a CDN, set `TINYMCE_URL` (the `forms.wysiwyg.tinymce_url` config):

```dotenv
TINYMCE_URL=https://cdn.example.com/tinymce/7/tinymce.min.js
```

The stack's name is the `scripts_stack` config (`scripts` by default). The package's own script then starts the editor on every `textarea.wysiwyg`. Without TinyMCE on the page the field stays a plain textarea. See [Assets](../advanced-usage/assets.md#third-party-scripts).

## The editor

The editor has no menu bar and a toolbar with: undo and redo, styles, bold and italic, bulleted and numbered lists, alignment, links, left-to-right and right-to-left direction, indentation, and the HTML source.

It opens right to left when the textarea is RTL (for example with `thaana`) or the page is:

```blade
<x-forms::wysiwyg name="body_dv" label="ލިޔުން" thaana />
```

## Showing the HTML

To show the saved HTML, use [`<x-forms::text-entry wysiwyg>`](./text-entry.md#html-content), which outputs it unescaped. Sanitize HTML that comes from users before you save it.

```blade
<x-forms::text-entry name="body" wysiwyg />
```

## Attributes

`wysiwyg` takes the attributes of [`textarea`](./inputs-and-textarea.md#textarea), except `wysiwyg`, which is always on.

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | required | Field name. |
| `label` | `string` | from `name` | Label text. |
| `rows` | `int` | `3` | Height before the editor loads. |
| `model` | `mixed` | bound model | Model to read the value from. `false` turns binding off. |
| `default` | `mixed` | `null` | Value when there is no old input and no model value. |
| `value` | `mixed` | `null` | Content. Replaces the model value, `default` and old input. |
| `placeholder` | `string` | `''` | Placeholder text. |
| `show-placeholder` | `bool` | `false` | Uses the label as the placeholder. |
| `required` | `bool` | `false` | Adds `required` and the required marker. |
| `show-label` | `bool` | `true` | `false` removes the label and field wrapper. |
| `show-errors` | `bool` | `true` | Shows errors. |
| `inline` | `bool` | `false` | Label beside the editor. |
| `inline-label-class` | `string` | config | Classes for the label column. |
| `inline-input-class` | `string` | config | Classes for the control column. |
| `floating` | `bool` | `false` | Floating label (`bootstrap-6` only). |
| `form-group-class` | `string` | `''` | Classes on the field wrapper. |
| `thaana` | `bool` | `false` | Right-to-left Dhivehi field. |
| `show-js-errors` | `bool` | `false` | Adds an empty error list for JavaScript validation. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Slot: `help`.

## React

```jsx
import { Wysiwyg } from "@javaabu/forms"

<Wysiwyg name="body" label="ލިޔުން" />
```

See [Parity](../parity.md).
