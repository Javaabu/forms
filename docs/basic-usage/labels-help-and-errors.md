---
title: Labels, help and errors
sidebar_position: 4
---

# Labels, help and errors

Field components build their markup from smaller components: `form-group`, `label`, `label-required`, `input-help` and `errors`. Use them directly to wrap a control the package doesn't have, or to place labels and errors yourself.

## Wrapping your own control

`<x-forms::form-group>` renders the field wrapper and label around its slot:

```blade
<x-forms::form-group name="color" label="ކުލަ" required>
    <input type="range" id="color" name="color" min="0" max="10" class="w-full">

    <x-forms::input-help>{{ __('Pick a value from 0 to 10.') }}</x-forms::input-help>
    <x-forms::errors name="color" />
</x-forms::form-group>
```

`name` is used as the label's `for`, so it should match the control's `id`. The label is generated from it when `label` is empty.

- `:wrap="false"` renders only the slot, with no wrapper or label.
- `:show-label="false"` keeps the wrapper but leaves out the label.
- `blank-label` renders an empty `<label>`, to keep a control aligned with labelled fields beside it.
- `inline` and `floating` work as on [inputs](./inputs-and-textarea.md#inline-horizontal-layout).
- `class` and other attributes go on the wrapper.

## Labels

```blade
<x-forms::label for="name" label="ނަން" required />

{{-- HTML in the label --}}
<x-forms::label for="terms">
    {{ __('I agree to the') }} <a href="/terms">{{ __('terms') }}</a>
</x-forms::label>
```

With a slot, the slot replaces the label text, and no required marker is added. Attributes such as `for` and `class` go on the `<label>`. `<x-forms::label>` renders nothing when it has no label, no slot and no `blank-label`.

## Required marker

`<x-forms::label-required>` renders the marker that `required` fields add after their label:

```blade
<span>{{ __('Name') }} <x-forms::label-required /></span>
```

The text comes from the `required_text` string (`*`). Pass `text` to change one marker. To change it everywhere, publish the translations and edit `required_text`:

```bash
php artisan vendor:publish --tag=forms-translations
```

```php
// lang/vendor/forms/en/strings.php
'required_text' => '(required)',
```

The marker has `aria-hidden="true"`; the control's `required` attribute is what assistive technology announces.

## Help text

```blade
<x-forms::input-help>{{ __('Use the name on your ID card.') }}</x-forms::input-help>
```

Renders a `<p data-slot="help-text">` in `onu` and a `<small class="form-text">` in `bootstrap-6`. Field components render it for you from their `help` slot.

## Errors

`<x-forms::errors>` shows the validation errors for a field name. It renders nothing when there are none.

```blade
<x-forms::errors name="email" />

{{-- every message, not only the first --}}
<x-forms::errors name="password" :first-only="false" />

{{-- from a named error bag --}}
<x-forms::errors name="email" bag="login" />
```

- Bracket names are read with dots: `address[city]` shows the errors for `address.city`.
- When a name has no errors of its own, the errors for `name.*` are shown, so `tags[]` shows the errors of each tag.
- Without a session (in mail, queued jobs or console commands) there are no errors and nothing renders.

Field components show the first error under the control. To show every error for a field, turn off the field's errors and add your own:

```blade
<x-forms::password name="password" :show-errors="false" />
<x-forms::errors name="password" :first-only="false" />
```

`:show-errors="false"` also stops the control being marked invalid.

## Error summary

`<x-forms::error-summary>` lists every error in a bag, each linking to its field. [`<x-forms::form summary>`](./forms.md#showing-an-error-summary) renders one at the top of the form; use the component directly to place it yourself or to add field names in front of the messages:

```blade
<x-forms::error-summary
    :title="__('Please check the form')"
    :labels="[
        'name' => 'ނަން',
        'address.city' => 'ރަށް',
    ]"
/>
```

```html
<!-- one item -->
<li><a href="#address-city">ރަށް: ރަށް ޚިޔާރުކުރައްވާ.</a></li>
```

Links use the field ids the components generate: `address.city` links to `#address-city`, and `tags.0` links to `#tags`. The summary has `role="alert"`, `tabindex="-1"` and `data-forms-summary`, and the form's [focus on error](./forms.md#focusing-the-first-error) moves focus to it.

## Errors from JavaScript validation

`show-js-errors` on a field, or `<x-forms::js-errors>`, renders an empty list for errors that `@javaabu/js-utilities`' AJAX validation fills in:

```blade
<x-forms::text name="first_name" show-js-errors />

<x-forms::js-errors name="first_name" />
```

```html
<ul class="invalid-feedback first-name-error"></ul>
```

The class is the name passed through `Str::slug()` plus `-error`. React shows these errors itself and has no equivalent.

## Attributes

### `form-group`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | `''` | Id of the control. Used as the label's `for` and to generate the label. |
| `label` | `string` | from `name` | Label text. |
| `required` | `bool` | `false` | Adds the required marker to the label. |
| `inline` | `bool` | `false` | Label beside the control. |
| `floating` | `bool` | `false` | Floating label (`bootstrap-6` only). |
| `wrap` | `bool` | `true` | `false` renders only the slot. |
| `show-label` | `bool` | `true` | `false` leaves out the label. |
| `blank-label` | `bool` | `false` | Renders an empty label. |
| `inline-label-class` | `string` | config | Classes for the label column. |
| `inline-input-class` | `string` | config | Classes for the control column. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Slot: the control.

### `label`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `label` | `string` | `''` | Label text. The slot replaces it. |
| `required` | `bool` | `false` | Adds the required marker (not with a slot). |
| `inline` | `bool` | `false` | Uses the inline label classes. |
| `floating` | `bool` | `false` | Floating label: no `form-label` class (`bootstrap-6`). |
| `inline-label-class` | `string` | config | Classes for an inline label. |
| `blank-label` | `bool` | `false` | Renders an empty label. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

### `label-required`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `text` | `string` | `required_text` string | Marker text. An empty string renders nothing. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

### `input-help`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Slot: the help text.

### `errors`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | `''` | Field name. Brackets are read as dots. |
| `bag` | `string` | `'default'` | Error bag. |
| `first-only` | `bool` | `true` | Shows only the first message. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

### `error-summary`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `title` | `string` | `error_summary_title` string | Heading. |
| `bag` | `string` | `'default'` | Error bag. |
| `labels` | `array` | `[]` | Error key → label shown before each message. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

### `js-errors`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | `''` | Field name. Gives the `{name}-error` class. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Slot: optional initial `<li>` items.

## React

```jsx
import { FormGroup, Label, InputHelp, Errors, ErrorSummary } from "@javaabu/forms"

<FormGroup name="color" label="ކުލަ" required>
  <input type="range" id="color" name="color" />
  <InputHelp>Pick a value from 0 to 10.</InputHelp>
  <Errors name="color" firstOnly={false} />
</FormGroup>

<ErrorSummary title="Please check the form" />
```

`js-errors` is Blade only. See [Parity](../parity.md).
