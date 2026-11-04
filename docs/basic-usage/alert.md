---
title: Alert
sidebar_position: 15
---

# Alert

`<x-forms::alert>` shows a message box: Onu's callout in `onu`, a Bootstrap alert in `bootstrap-6`.

```blade
<x-forms::alert type="success">
    ބަދަލުތައް ސޭވްކުރެވިއްޖެ.
</x-forms::alert>
```

## Types

`type` sets the colour:

| `type` | `onu` tone | `bootstrap-6` classes |
| --- | --- | --- |
| `primary` (default), `info` | `info` | `alert theme-primary`, `alert theme-info` |
| `success` | `success` | `alert theme-success` |
| `warning` | `warning` | `alert theme-warning` |
| `danger` | `danger` | `alert theme-danger` |
| `secondary`, `light`, `dark` | `neutral` | `alert theme-secondary`, `alert theme-secondary`, `alert theme-inverse` |

In `onu`, `danger` and `warning` alerts have `role="alert"`, so screen readers announce them straight away, and the others have `role="status"`. In `bootstrap-6` every alert has `role="alert"`.

## Heading and icon

```blade
<x-forms::alert type="warning" heading="ސަބްސްކްރިޕްޝަން ހަމަވަނީ" icon="alert_warning">
    {{ __('Your subscription ends on :date.', ['date' => $ends_at->format('d M Y')]) }}
</x-forms::alert>
```

`icon` takes a [bundled Lucide name, a logical name from the `icons` config, or icon font classes](./icons.md). The config has `alert_success`, `alert_danger`, `alert_warning` and `alert_info` for alerts. Alerts have no icon unless you pass one.

The slot can hold HTML: paragraphs, lists and links.

## Dismissible alerts

`dismissible` adds a close button:

```blade
<x-forms::alert type="info" dismissible>
    {{ __('New features are available.') }}
</x-forms::alert>
```

- `onu`: the button has `data-dismiss="alert"`, and the package's script removes the alert (see [Assets](../advanced-usage/assets.md)).
- `bootstrap-6`: the button is `.btn-close` with `data-bs-dismiss="alert"`, handled by Bootstrap's JavaScript.

## Flash messages

```blade
@if (session('success'))
    <x-forms::alert type="success" icon="alert_success" dismissible>
        {{ session('success') }}
    </x-forms::alert>
@endif
```

## Rendered HTML

```html
<!-- onu (classes shortened) -->
<div class="alert …" data-slot="callout" data-tone="warning" role="alert">
    <svg data-icon-name="triangle-alert" …></svg>
    <div class="…" data-slot="alert-title">ސަބްސްކްރިޕްޝަން ހަމަވަނީ</div>
    <div class="…" data-slot="alert-description">…</div>
</div>

<!-- bootstrap-6 -->
<div class="alert theme-warning" role="alert">
    <svg class="forms-icon flex-shrink-0" data-icon-name="triangle-alert" …></svg>
    <div class="flex-grow-1">
        <h4 class="alert-heading">ސަބްސްކްރިޕްޝަން ހަމަވަނީ</h4>
        …
    </div>
</div>
```

## Attributes

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `type` | `string` | `'primary'` | Colour. See [Types](#types). |
| `heading` | `string` | `''` | Heading above the message. |
| `icon` | `string` | `''` | Icon before the message. |
| `dismissible` | `bool` | `false` | Adds a close button. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Other attributes go on the wrapper. Slot: the message.

## React

```jsx
import { Alert } from "@javaabu/forms"

<Alert type="warning" heading="ސަބްސްކްރިޕްޝަން ހަމަވަނީ" dismissible>
  …
</Alert>
```

See [Parity](../parity.md).
