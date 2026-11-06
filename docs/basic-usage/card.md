---
title: Card
sidebar_position: 16
---

# Card

`<x-forms::card>` groups content in a box with an optional header, title, subtitle and footer.

```blade
<x-forms::card title="ފަރުދުގެ މަޢުލޫމާތު">
    <x-forms::text name="name" label="ނަން" />
    <x-forms::email name="email" />

    <x-slot:footer>
        <x-forms::submit>{{ __('Save') }}</x-forms::submit>
    </x-slot:footer>
</x-forms::card>
```

## Title, subtitle and header

```blade
<x-forms::card title="ރިޕޯޓް">
    <x-slot:subtitle class="italic">{{ __('Updated daily') }}</x-slot:subtitle>

    <x-slot:header class="flex justify-between">
        <x-forms::link-button :url="route('reports.export')" size="sm" color="light" start-icon="download">
            {{ __('Export') }}
        </x-forms::link-button>
    </x-slot:header>

    …
</x-forms::card>
```

- `title` can be an attribute or a `<x-slot:title>` slot, for a title with HTML.
- Attributes on the `header`, `subtitle` and `footer` slots go on those elements.
- An `image_top` slot is rendered first, before the header: `<x-slot name="image_top"><img src="…" alt=""></x-slot>`.

The layout differs between the frameworks:

- `onu`: the header, title and subtitle share Onu's card header (`data-slot="card-header"`), and the slot goes in `data-slot="card-content"`.
- `bootstrap-6`: the `header` slot is a `.card-header`; the title and subtitle are at the top of `.card-body`, with the slot.

## Building a card from parts

Use the parts directly for markup the slots don't cover:

```blade
<div class="grid gap-4 md:grid-cols-2">
    <x-forms::card>
        <x-forms::card.title>{{ __('Applications') }}</x-forms::card.title>
        <x-forms::card.subtitle>{{ __('This month') }}</x-forms::card.subtitle>
        <p class="text-3xl">{{ $applications_count }}</p>
    </x-forms::card>
</div>
```

`card.header`, `card.title`, `card.subtitle` and `card.footer` each render their slot in the framework's element for that part (`data-slot="card-header"`, `card-title`, `card-description` and `card-footer` in `onu`; `.card-header`, `.card-title`, `.card-subtitle` and `.card-footer` in `bootstrap-6`).

## Showing record details

[`<x-forms::infolist>`](./text-entry.md#showing-a-record) is a card that also binds a model, for showing a record's details with text entries.

## Attributes

### `card`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `title` | `string` | `''` | Card title. A `title` slot replaces it. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Other attributes go on the card. Slots: default (the body), `title`, `subtitle`, `header`, `footer`, `image_top`.

### `card.header`, `card.title`, `card.subtitle`, `card.footer`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Other attributes go on the element. Slot: the content.

## React

```jsx
import { Card, Submit, Text } from "@javaabu/forms"

<Card title="ފަރުދުގެ މަޢުލޫމާތު" footer={<Submit>Save</Submit>}>
  <Text name="name" label="ނަން" />
</Card>
```

Named slots are props of the same name. The parts are `CardHeader`, `CardTitle`, `CardSubtitle` and `CardFooter`. See [Parity](../parity.md).
