---
title: Conditional wrapper
sidebar_position: 12
---

# Conditional wrapper

`<x-forms::conditional-wrapper>` enables the fields inside it only when another field has a given value or a checkbox is checked, and can hide them too. Disabled fields aren't submitted, so the server only gets the fields that apply. It works in the browser, with the package's script (see [Assets](../advanced-usage/assets.md)).

## From another field's value

```blade
<x-forms::select name="type" label="ބާވަތް" :options="[
    'quiz' => 'ކުއިޒް',
    'video' => 'ވީޑިއޯ',
]" />

<x-forms::conditional-wrapper enable-elem="#type" enable-value="quiz" hide-fields>
    <x-forms::datetime name="expires_at" />
    <x-forms::number name="pass_mark" />
</x-forms::conditional-wrapper>
```

`expires_at` and `pass_mark` are enabled and shown while "ކުއިޒް" is selected, and disabled and hidden otherwise. It's applied when the page loads, so a pre-filled form starts in the right state.

- `enable-elem` is a CSS selector for the field to watch. For radio buttons, select the whole group: `enable-elem="[name=delivery]"`.
- `enable-value` is the value, or an array of values, that enables the section. Pass arrays with `:enable-value`:

```blade
<x-forms::conditional-wrapper enable-elem="#type" :enable-value="['quiz', 'video']">
    …
</x-forms::conditional-wrapper>
```

For a multiple select or a group of checkboxes, the section is enabled when any selected value matches.

## Hiding as well as disabling

Without `hide-fields`, the fields stay visible but disabled. With it, the wrapper gets the `hidden` attribute while its fields are disabled.

## The other way round

`disable` inverts the condition: the fields are disabled when the value matches.

```blade
<x-forms::conditional-wrapper enable-elem="#delivery_method" enable-value="pickup" disable hide-fields>
    <x-forms::textarea name="delivery_address" label="އެޑްރެސް" thaana />
</x-forms::conditional-wrapper>
```

## From a checkbox

`enable-checkbox` watches whether a checkbox is checked instead. `enable-value` is still required but isn't used:

```blade
<x-forms::checkbox name="online_interview" label="އޮންލައިން އިންޓަވިއު" />

<x-forms::conditional-wrapper enable-elem="#online_interview" :enable-value="1" enable-checkbox hide-fields>
    <x-forms::url name="meeting_link" />
</x-forms::conditional-wrapper>

<x-forms::conditional-wrapper enable-elem="#online_interview" :enable-value="1" enable-checkbox hide-fields disable>
    <x-forms::text name="venue" />
</x-forms::conditional-wrapper>
```

The first section shows while the checkbox is checked, the second while it isn't. In checkbox mode, buttons inside the section are disabled too.

## Only fields the wrapper disabled

Fields the wrapper disables get the `auto-disabled` class, and only those are enabled again. A field you rendered `disabled` stays disabled.

## Without a wrapper

The same script reads these attributes, which you can put on fields directly:

| Attribute | On | Effect |
| --- | --- | --- |
| `data-toggle-checkbox="#field"` | a checkbox | Disables the matching fields while the checkbox is checked. |
| `data-enable-checkbox="#section"` | a checkbox | Enables and shows the inputs and selects in the section while checked. With `data-disable`, while unchecked. |
| `data-disable-on-select="#section"` | a select or input | Disables the inputs and selects in the section while it has a value. With `data-hide-fields`, hides them too. |

```blade
<x-forms::number name="max_salary" />
<x-forms::checkbox name="no_max_salary" label="ލިމިޓެއް ނެތް" data-toggle-checkbox="#max_salary" />
```

## Rendered HTML

The wrapper is a plain `<div>` with data attributes. Other attributes, such as `class` and `id`, go on it:

```html
<div data-enable-elem="#type" data-enable-section-value="quiz" data-hide-fields="true">…</div>

<div data-enable-section-checkbox="#online_interview" data-hide-fields="true" data-disable="true">…</div>
```

## Attributes

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `enable-elem` | `string` | required | Selector of the field (or checkbox) to watch. |
| `enable-value` | `mixed` | required | Value or array of values that enables the section. Unused with `enable-checkbox`. |
| `hide-fields` | `bool` | `false` | Hides the section while its fields are disabled. |
| `disable` | `bool` | `false` | Inverts the condition. |
| `enable-checkbox` | `bool` | `false` | Watches whether `enable-elem` is checked instead of its value. |
| `json-encode` | `bool` | `true` for arrays | JSON-encodes `enable-value` in the data attribute. |
| `framework` | `string` | config | Not used by the markup. |

Slot: the fields.

## React

```jsx
import { ConditionalWrapper } from "@javaabu/forms"

<ConditionalWrapper enableElem="#type" enableValue="quiz" hideFields>
  <Datetime name="expires_at" />
</ConditionalWrapper>
```

`json-encode` is Blade only. See [Parity](../parity.md).
