---
title: Checkbox
sidebar_position: 2.5
---

The `checkbox` component renders a checkbox with a label, model binding, and validation errors. It supports Bootstrap 5 and Material Admin 2.6.

## Basic Usage

Only the `name` attribute is required. The label is generated from the name, so `send_notifications` becomes "Send Notifications".

```html
<x-forms::checkbox name="send_notifications" />

<x-forms::checkbox name="send_notifications" label="Send me notifications" />
```

When checked, the checkbox submits its `value`, which defaults to `1`. An unchecked checkbox does not submit a value. The component does not add a hidden input for the unchecked state; handle missing values in your request handling.

## Values and Checked State

Use `value` to set the value submitted when checked, and `default` to set the initial checked state.

```html
<x-forms::checkbox name="newsletter" value="yes" :default="true" />
```

This checkbox starts checked and submits `newsletter=yes`. Use Blade's `:` syntax to pass a boolean, such as `:default="false"`, rather than the string `default="false"`.

The component determines its checked state in this order:

1. **Old input:** After a submission with flashed input, the checkbox is checked when its `value` appears in the old input for its name. Missing or empty old input leaves it unchecked, even if a model or default would otherwise check it.
2. **Bound value:** Without old input, an array or an `Arrayable` value, such as a collection, checks the checkbox when it contains the checkbox's `value`. A scalar bound value determines the checked state by its boolean value.
3. **Default:** When the bound value is `null`, `default` determines the checked state. It defaults to `false`.

A scalar bound value is not compared to `value`. For a single checkbox, bind a boolean or a `0`/`1` attribute; for a group of choices, bind an array of selected values.

### Model Binding

Bind a model or array to a single checkbox, or inherit the model from the surrounding form:

```html
<x-forms::checkbox name="send_notifications" :model="$user" />

<x-forms::form :model="$user">
    <x-forms::checkbox name="send_notifications" />
</x-forms::form>
```

These examples use `$user->send_notifications` to determine whether the checkbox is checked. A bound `false` value takes precedence over `:default="true"`.

To ignore the surrounding model for a checkbox, pass `:model="false"`:

```html
<x-forms::checkbox name="newsletter" :model="false" :default="true" />
```

See [Model Binding and Default Values](./model-binding.md) for other binding methods. For checkboxes, `value` is always the submitted value; the checked-state rules above determine selection.

### Checkbox Groups

Use an array-style name and a different `value` for each choice. Give each checkbox a unique `id`, because the generated ID depends on the name and would otherwise be shared by every checkbox in the group.

```html
<x-forms::form :model="['channels' => ['email']]">
    <x-forms::checkbox
        name="channels[]"
        id="channels-email"
        label="Email"
        value="email"
    />

    <x-forms::checkbox
        name="channels[]"
        id="channels-sms"
        label="SMS"
        value="sms"
    />
</x-forms::form>
```

Here, Email starts checked and SMS starts unchecked. Selecting both submits `channels` as an array containing `email` and `sms`. Old input for `channels` restores each choice after a submission.

## Labels and Layout

Use the default slot for a label containing HTML:

```html
<x-forms::checkbox name="accept_terms" required>
    I agree to the <a href="/terms">terms and conditions</a>.
</x-forms::checkbox>
```

For a horizontal form layout, add `inline`. The field label appears in a separate column; the label beside the checkbox is blank unless you supply slot content.

```html
<x-forms::checkbox
    name="send_notifications"
    label="Notifications"
    inline
    inline-label-class="col-sm-4 col-form-label"
    inline-input-class="col-sm-8"
>
    Send me email notifications
</x-forms::checkbox>
```

Default column classes come from the selected framework's `inline-label-class` and `inline-input-class` configuration.

Set `:show-label="false"` to remove the wrapping form group. The label beside the checkbox is still rendered.

## Help Text and Validation

Add helper text with the named `help` slot:

```html
<x-forms::checkbox name="send_notifications">
    <x-slot:help>
        Receive an email when your application status changes.
    </x-slot:help>
</x-forms::checkbox>
```

Validation errors are displayed below the checkbox automatically, and the input receives the `is-invalid` class. Set `:show-errors="false"` to suppress both the messages and the invalid class.

```html
<x-forms::checkbox name="accept_terms" required />

<x-forms::checkbox name="send_notifications" :show-errors="false" />
```

The `required` option adds the HTML `required` attribute and the configured required indicator to the label. In an inline layout, the indicator appears on the separate field label. Add server-side validation rules in your application as well.

## Available Options

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | **Required** | Input name, also used to generate the ID and look up bound values, old input, and validation errors. |
| `label` | `string` | `''` | Label text. When empty, a translated, title-cased label is generated from `name`. |
| `model` | `mixed` | `null` | Binding target. Uses the surrounding binding when omitted; `false` disables model binding for this checkbox. |
| `default` | `bool` | `false` | Initial checked state when there is no old input and the bound value is `null`. |
| `value` | `mixed` | `1` | Value submitted when checked, and the value matched against old input or a bound array. |
| `show-errors` | `bool` | `true` | Displays validation errors and applies the invalid input class. |
| `show-label` | `bool` | `true` | Controls the wrapping form group. The checkbox's own label remains visible. |
| `required` | `bool` | `false` | Requires the checkbox to be checked and adds the configured required indicator. |
| `inline` | `bool` | `false` | Places the field label and checkbox in separate columns. |
| `floating` | `bool` | `false` | Applies the selected framework's floating form-group layout. |
| `inline-label-class` | `string` | `''` | Overrides the inline label column classes; otherwise uses the framework configuration. |
| `inline-input-class` | `string` | `''` | Overrides the inline input column classes; otherwise uses the framework configuration. |
| `show-js-errors` | `bool` | `false` | Renders the `js-errors` component for client-side validation messages. |
| `framework` | `string` | `''` | Uses `forms.framework` when omitted. Supports `bootstrap-5` and `material-admin-26`. |

The default slot supplies the checkbox label, and the named `help` slot supplies helper text. Additional HTML attributes, such as `id`, `class`, `disabled`, and `data-*`, are passed to the checkbox input.

```html
<x-forms::checkbox name="send_notifications" id="notifications" disabled />
```

To enable or disable other fields based on a checkbox's state, see [Conditional Wrapper](./conditional-wrapper.md).
