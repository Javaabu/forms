---
title: Checkbox and radio
sidebar_position: 5
---

# Checkbox and radio

`<x-forms::checkbox>` and `<x-forms::radio>` render a native checkbox or radio with its label beside it, help text and validation errors. They submit with the form without JavaScript.

## Checkbox

```blade
<x-forms::checkbox name="send_notifications" />

<x-forms::checkbox name="accept_terms" label="ޝަރުތުތަކަށް އެއްބަސްވަން" required />
```

The label is generated from the name when you don't give one. A checked checkbox submits its `value` (`1` by default). An unchecked checkbox submits nothing. If your controller needs a `0`, add a plain hidden input before it:

```blade
<input type="hidden" name="send_notifications" value="0">
<x-forms::checkbox name="send_notifications" />
```

### Starting checked

`default` is the checked state when there is no old input and no model value:

```blade
<x-forms::checkbox name="newsletter" value="yes" :default="true" />
```

Use `:default="true"`, not `default="true"`: the string `"false"` is truthy.

### Label with HTML

The default slot replaces the label:

```blade
<x-forms::checkbox name="accept_terms" required>
    {{ __('I agree to the') }} <a href="/terms">{{ __('terms and conditions') }}</a>
</x-forms::checkbox>
```

### Checkbox groups

Give each checkbox the same array name, its own `value`, and its own `id` (the generated id comes from the name, so it would be the same for every checkbox in the group):

```blade
<x-forms::form :model="$user">
    <x-forms::checkbox name="channels[]" id="channels-email" value="email" label="އީމެއިލް" />
    <x-forms::checkbox name="channels[]" id="channels-sms" value="sms" label="އެސްއެމްއެސް" />
</x-forms::form>
```

With `$user->channels = ['email']`, the first starts checked. A collection works too.

## Radio

Radio buttons in a group share a `name`. Give each one a `value`, a `label` and its own `id`:

```blade
<x-forms::radio name="status" id="status-draft" value="draft" label="ޑްރާފްޓް" />
<x-forms::radio name="status" id="status-published" value="published" label="ޕަބްލިޝްކުރެވިފައި" />
```

After a failed validation, the radio whose `value` matches the old input is checked.

To check one from the model, compare the value yourself and turn off binding for the radios:

```blade
@foreach (ArticleStatuses::cases() as $status)
    <x-forms::radio
        name="status"
        :id="'status-' . $status->value"
        :value="$status->value"
        :label="$status->getLabel()"
    />
@endforeach
```

Each radio is checked when the bound value (an enum is compared by its value) equals its own `value`.

## How the checked state is decided

1. **Old input.** If the request has old input, the checkbox or radio is checked only when its `value` is in the old input for its name. A field missing from the old input is unchecked, even if the model or `default` would check it.
2. **Bound value.** Without old input, an array or collection checks it when it contains the `value`. Any other value checks it when it's truthy (`true`, `1`). It isn't compared with `value`.
3. **`default`**, when the bound value is `null` or there's no model.

## Layout

With `inline`, the field label goes in the label column and the label beside the checkbox is blank, unless you give a slot:

```blade
<x-forms::checkbox name="send_notifications" label="ނޯޓިފިކޭޝަން" inline>
    {{ __('Email me when my application changes') }}
</x-forms::checkbox>
```

The required marker shows on the field label when `inline`, and on the label beside the checkbox otherwise.

`:show-label="false"` removes the field wrapper. The label beside the checkbox stays.

## Help text and errors

```blade
<x-forms::checkbox name="send_notifications">
    <x-slot:help>{{ __('We send at most one email a week.') }}</x-slot:help>
</x-forms::checkbox>
```

Errors show below the checkbox, and the input gets `aria-invalid="true"`. `:show-errors="false"` turns both off.

## Enabling other fields

To enable, disable, show or hide other fields from a checkbox, see [Conditional wrapper](./conditional-wrapper.md#from-a-checkbox).

## Rendered HTML

`onu` (classes shortened to `…`):

```html
<div class="… mb-4" data-slot="form-field" data-label-layout="stacked">
    <div class="gap-2 grid">
        <div class="min-w-0 gap-1.5 grid">
            <div class="gap-2.5 flex items-start" data-slot="checkbox-field">
                <span class="flex shrink-0 items-center min-h-5">
                    <input class="… forms-checkbox" data-slot="checkbox" id="agree" name="agree" type="checkbox" value="1">
                </span>
                <div class="min-w-0 gap-1 grid">
                    <label class="… checkbox-label" for="agree" data-slot="label">Agree</label>
                </div>
            </div>
        </div>
    </div>
</div>
```

`bootstrap-6`:

```html
<div class="form-field mb-4">
    <div class="form-field">
        <input class="check" id="agree" name="agree" type="checkbox" value="1">
        <label class="form-label check-label" for="agree">Agree</label>
    </div>
</div>
```

Radios use `data-slot="radio-field"`, `data-slot="radio"`, `.forms-radio` and `.radio-label` in `onu`, and `input.radio` with `.radio-label` in `bootstrap-6`.

## Attributes

`checkbox` and `radio` take the same attributes:

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | required | Field name. Use `name[]` for a checkbox group. |
| `label` | `string` | from `name` | Label beside the control. The slot replaces it. |
| `value` | `mixed` | `1` | Value submitted when checked, and compared with old input and bound arrays. |
| `model` | `mixed` | bound model | Model to read the checked state from. `false` turns binding off. |
| `default` | `bool` | `false` | Checked state when there is no old input and no model value. |
| `required` | `bool` | `false` | Adds `required` and the required marker. |
| `show-label` | `bool` | `true` | `false` removes the field wrapper. |
| `show-errors` | `bool` | `true` | Shows errors and marks the control invalid. |
| `inline` | `bool` | `false` | Field label in a label column. |
| `inline-label-class` | `string` | config | Classes for the label column. |
| `inline-input-class` | `string` | config | Classes for the control column. |
| `floating` | `bool` | `false` | Passed to the field wrapper. Has no visible effect. |
| `show-js-errors` | `bool` | `false` | Adds an empty error list for JavaScript validation. |
| `form-group-class` | `string` | `''` | Classes on the field wrapper. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Other attributes (`id`, `class`, `disabled`, `data-*`) go on the `<input>`.

Slots: default (the label), `help`.

## React

```jsx
import { Checkbox, Radio } from "@javaabu/forms"

<Checkbox name="accept_terms" label="ޝަރުތުތަކަށް އެއްބަސްވަން" required />
<Radio name="status" id="status-draft" value="draft" label="ޑްރާފްޓް" />
```

React's checkboxes are Radix buttons from Onu; the Blade ones are native inputs with Onu's classes. See [Onu](../frameworks/onu.md#differences-from-the-react-components).
