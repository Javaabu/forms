---
title: Dates and times
sidebar_position: 8
---

# Dates and times

`<x-forms::date>`, `<x-forms::datetime>` and `<x-forms::time>` render an input with a calendar or clock icon, a clear button and a picker. The picker is [flatpickr](https://flatpickr.js.org), loaded with the component (see [Assets](../advanced-usage/assets.md)).

```blade
<x-forms::date name="published_at" label="ޝާއިޢުކުރި ތާރީޚު" />
<x-forms::datetime name="expires_at" />
<x-forms::time name="opening_time" />
```

## What the user sees

- Clicking the field opens a calendar (`date`), a calendar with a time (`datetime`) or a time picker (`time`). Users can also type.
- The clear button empties the field and fires a `change` event.
- The calendar is in Dhivehi when the page is (`<html lang="dv">`), and right to left in RTL pages.
- `min` and `max` attributes limit the dates that can be picked.

```blade
<x-forms::date name="birth_date" :max="now()->format('Y-m-d')" />
```

## Formats

The picker reads and writes these formats, which are also what the browser submits:

| Component | Format | Example |
| --- | --- | --- |
| `date` | `Y-m-d` | `2026-11-04` |
| `datetime` | `Y-m-d H:i` | `2026-11-04 14:30` |
| `time` | `H:i` | `14:30` |

Validate them with Laravel's `date_format` rule, for example `'published_at' => ['nullable', 'date_format:Y-m-d']`.

## Values from a model

A date attribute on a bound Eloquent model is shown in the format the picker uses: `Y-m-d` for `date`, `Y-m-d H:i` for `datetime` and `H:i` for `time`. Set `date-format` to use another format:

```blade
<x-forms::form :model="$article">
    <x-forms::date name="published_at" />
    <x-forms::datetime name="expires_at" date-format="Y-m-d H:i" />
</x-forms::form>
```

`date-format` applies to values read from a bound Eloquent model. Pass `default` as a string in the right format:

```blade
<x-forms::date name="published_at" :default="now()->format('Y-m-d')" />
```

To use the model's own casts instead, set `use_eloquent_date_casting` to `true` in `config/forms.php`. Then a field without `date-format` is formatted with its `date:…` or `datetime:…` cast (`'published_at' => 'date:Y-m-d'`). Attributes cast as plain `date` or `datetime`, or not cast, become JSON dates (`2026-11-04T00:00:00.000000Z`).


## Icons

The icons come from the `icons` config (`date` and `datetime` use `calendar`, `time` uses `clock`, the clear button `clear`). Change them for one field with `icon` and `clear-icon`, using a [Lucide name or icon font classes](./icons.md):

```blade
<x-forms::date name="due_on" icon="clock" clear-icon="circle-x" />
```

`icon-wrapper-class` and `clear-btn-class` add classes to the icon and to the clear button. Their defaults are `frameworks.<name>.date_icon_wrapper_class` and `date_clear_btn_class` in `config/forms.php`.

## Rendered HTML

The input has the `date-picker`, `datetime-picker` or `time-picker` class, and the clear button has `data-date-clear` pointing at the input:

```html
<!-- bootstrap-6 -->
<div class="input-group">
    <span class="input-group-text" aria-hidden="true"><svg data-icon-name="calendar" …></svg></span>
    <input class="form-control date-picker" type="date" value="2026-11-04" name="published_at" id="published_at" />
    <button type="button" data-date-clear="#published_at" class="btn-outline theme-secondary input-group-btn btn-date-clear disable-w-input" title="Clear" aria-label="Clear">
        <svg data-icon-name="x" …></svg>
    </button>
</div>
```

In `onu` it's Onu's input group (`data-slot="input-group"`) with the icon and button in `input-group-addon` slots. The script changes the input's `type` to `text` so the browser's own picker doesn't open as well.

## Attributes

`date`:

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | required | Field name. |
| `label` | `string` | from `name` | Label text. |
| `type` | `string` | `'date'` | HTML input type. |
| `model` | `mixed` | bound model | Model to read the value from. `false` turns binding off. |
| `default` | `mixed` | `null` | Value when there is no old input and no model value. |
| `date-format` | `string` | `''` | PHP date format for values from a bound Eloquent model. Default: the picker's format (`Y-m-d`, `Y-m-d H:i`, `H:i`). |
| `icon` | `string` | `icons.date` | Icon before the input. |
| `clear-icon` | `string` | `icons.clear` | Icon of the clear button. |
| `icon-wrapper-class` | `string` | config | Classes on the icon wrapper. |
| `clear-btn-class` | `string` | config | Classes on the clear button. |
| `placeholder` | `string` | `''` | Placeholder text. |
| `show-placeholder` | `bool` | `false` | Uses the label as the placeholder. |
| `required` | `bool` | `false` | Adds `required` and the required marker. |
| `show-label` | `bool` | `true` | `false` removes the label and field wrapper. |
| `show-errors` | `bool` | `true` | Shows errors and marks the input invalid. |
| `inline` | `bool` | `false` | Label beside the input. |
| `inline-label-class` | `string` | config | Classes for the label column. |
| `inline-input-class` | `string` | config | Classes for the control column. |
| `floating` | `bool` | `false` | Floating label (`bootstrap-6` only). |
| `form-group-class` | `string` | `''` | Classes on the field wrapper. |
| `show-js-errors` | `bool` | `false` | Adds an empty error list for JavaScript validation. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

`datetime` takes the same attributes except `type`; its `icon` defaults to `icons.datetime`. `time` takes the same attributes except `type`; its `icon` defaults to `icons.time`.

Other attributes (`min`, `max`, `disabled`, `id`) go on the `<input>`. Slot: `help`.

## React

```jsx
import { Date, Datetime, Time } from "@javaabu/forms"

<Date name="published_at" label="ޝާއިޢުކުރި ތާރީޚު" />
<Datetime name="expires_at" />
<Time name="opening_time" />
```

React formats dates on the client and uses Onu's pickers, so `date-format`, `icon`, `clear-icon`, `clear-btn-class` and `icon-wrapper-class` are Blade only. See [Parity](../parity.md).
