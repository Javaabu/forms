---
title: Status
sidebar_position: 20
---

# Status

`<x-forms::status>` renders a coloured badge for a status: Onu's status badge in `onu`, a Bootstrap badge in `bootstrap-6`.

```blade
<x-forms::status color="success" label="ޝާއިޢުކުރެވިފައި" />

<x-forms::status color="danger">
    {{ __('Rejected') }}
</x-forms::status>
```

## Colours

| `color` | `onu` tone | `bootstrap-6` classes |
| --- | --- | --- |
| `primary` (default), `info` | `info` | `badge theme-primary`, `badge theme-info` |
| `success` | `success` | `badge theme-success` |
| `warning` | `warning` | `badge theme-warning` |
| `danger` | `danger` | `badge theme-danger` |
| `secondary`, `light`, `dark` | `neutral` | `badge theme-secondary`, `badge theme-secondary`, `badge theme-inverse` |

In `onu`, other names get the `neutral` tone. The badge has the `status` class and, in `onu`, `data-slot="status-badge"` and `data-tone`.

## Status enums

[Text entries](./text-entry.md), [table cells](./tables-and-listings.md#cells) and [formatted values](./text-entry.md#formatting-a-value-anywhere) show a status badge by themselves for a backed enum with `getLabel()` and `getColor()` methods (for example one implementing `Javaabu\Helpers\Enums\IsStatusEnum`):

```php
enum ApplicationStatuses: string
{
    case Pending = 'pending';
    case Approved = 'approved';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => __('Pending'),
            self::Approved => __('Approved'),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Approved => 'success',
        };
    }
}
```

```blade
@model($application)
    <x-forms::text-entry name="status" />
@endmodel

{{-- the same, by hand --}}
<x-forms::status :color="$application->status->getColor()" :label="$application->status->getLabel()" />
```

## Attributes

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `label` | `string` | `''` | Badge text. The slot replaces it. |
| `color` | `string` | `'primary'` | See [Colours](#colours). |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Other attributes go on the `<span>`. Slot: the content.

## React

```jsx
import { Status } from "@javaabu/forms"

<Status color="success" label="ޝާއިޢުކުރެވިފައި" />
```

See [Parity](../parity.md).
