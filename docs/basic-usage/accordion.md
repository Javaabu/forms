---
title: Accordion
sidebar_position: 10
---

The `accordion` component groups content into collapsible panels. It supports Bootstrap 5 and Material Admin 2.6 and can render items from an array or Collection, or from components in its default slot.

## Basic Usage

Provide a unique `id` for the accordion and pass an array or Collection to `items`.

```html
@php
    $items = [
        'applicationRequirements' => [
            'title' => 'What do I need to apply?',
            'content' => 'Have your identification and supporting documents ready.',
            'show' => true,
        ],
        'applicationStatus' => [
            'title' => 'How do I check my application status?',
            'content' => 'Sign in and open the applications page.',
        ],
    ];
@endphp

<x-forms::accordion id="application-faq" :items="$items" />
```

The first panel starts open because its `show` value is `true`. Panels default to closed; the component does not automatically open the first item.

Opening and closing panels requires the Bootstrap collapse JavaScript used by your theme. Load it in your application layout; the component generates the markup without loading JavaScript itself.

### Item Options

Each entry in `items` accepts these keys:

| Key | Default | Description |
| --- | --- | --- |
| `title` | `''` | Header text. A header slot takes precedence. No title is generated from the item key. |
| `content` | `''` | Body text. A body slot takes precedence. HTML is escaped and line breaks are converted to `<br>` tags. |
| `show` | `false` | Whether the panel is initially expanded. |
| `id` | Not set | Optional ID for the item wrapper, separate from the collapsible panel's ID. |

### Panel IDs

For named items, the array key becomes the panel ID, with spaces replaced by hyphens. In the example above, the panels have IDs `applicationRequirements` and `applicationStatus`.

For numeric keys, the panel ID is `{accordion-id}-item-{key}-collapse`. For example, key `0` inside `application-faq` produces `application-faq-item-0-collapse`.

Keep panel IDs unique across the page. Named keys are not prefixed with the accordion ID, so use different keys when rendering multiple accordions. Setting an item's `id` changes its wrapper ID, not its panel ID.

## Custom Headers and Content

Use named slots when headers or bodies need HTML. For a named item, use its key in kebab case for the body slot and append `-header` for the header slot. For example, `applicationRequirements` uses `application-requirements` and `application-requirements-header`.

```html
@php
    $items = [
        'applicationRequirements' => ['show' => true, 'id' => 'requirements-item'],
        'applicationStatus' => [
            'title' => 'Checking your status',
            'content' => 'Sign in to view your application status.',
        ],
    ];
@endphp

<x-forms::accordion id="application-faq" :items="$items">
    <x-slot:application-requirements-header>
        <strong>Required documents</strong>
    </x-slot:application-requirements-header>

    <x-slot:application-requirements>
        <p>Please prepare the following documents:</p>
        <ul>
            <li>Identification</li>
            <li>Proof of address</li>
        </ul>
    </x-slot:application-requirements>
</x-forms::accordion>
```

A body slot replaces the corresponding item's `content`, and a non-empty header slot replaces its `title`.

### Numeric Item Keys

For a list with numeric keys, use `item-{key}` and `item-{key}-header` slots. Keys are used as supplied, rather than renumbered by position.

```html
@php
    $items = [
        ['title' => 'Required documents', 'show' => true],
        ['title' => 'Next steps', 'content' => 'Submit your application for review.'],
    ];
@endphp

<x-forms::accordion id="application-faq" :items="$items">
    <x-slot:item-0-header>
        <strong>Before you apply</strong>
    </x-slot:item-0-header>

    <x-slot:item-0>
        <p>Have your identification ready.</p>
    </x-slot:item-0>
</x-forms::accordion>
```

## Creating Items Manually

Omit `items` and place `accordion.item` components in the default slot. Each item requires a `name` for its panel ID and a `parent` matching the accordion ID, without a leading `#`.

```html
<x-forms::accordion id="application-faq">
    <x-forms::accordion.item
        id="requirements-item"
        name="applicationRequirements"
        parent="application-faq"
        show
    >
        <x-slot:header>
            <strong>Required documents</strong>
        </x-slot:header>

        <p>Have your identification ready.</p>
    </x-forms::accordion.item>

    <x-forms::accordion.item
        name="applicationStatus"
        parent="application-faq"
        title="Checking your status"
        content="Sign in to view your application status."
        :show="false"
    />
</x-forms::accordion>
```

The item's `header` slot takes precedence over `title`. For a manually created item, a non-empty `content` attribute takes precedence over the default body slot. Use the default slot for HTML and leave `content` empty.

The accordion's default slot is rendered after any generated items, so you can also combine an `items` array with manually created items.

### Accordion Options

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `id` | `string` | **Required** | ID of the outer accordion and the parent used by generated panels. |
| `items` | `array` or `Collection` | `[]` | Items to render. Omit when creating items in the default slot. |
| `framework` | `string` | `''` | Uses `forms.framework` when omitted. Supports `bootstrap-5` and `material-admin-26`. |

### Accordion Item Options

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | **Required** | ID of the collapsible panel, also used as the header's target. |
| `parent` | `string` | **Required** | ID of the parent accordion, without `#`. |
| `title` | `string` | `''` | Header text when no non-empty `header` slot is provided. |
| `content` | `string` | `''` | Body text, escaped with line breaks preserved. When non-empty, overrides the default slot. |
| `show` | `bool` | `false` | Sets the initial expanded state of both the header and panel. |
| `framework` | `string` | `''` | Uses `forms.framework` when omitted. |

## Separate Header and Collapse Components

For a custom item layout, use `accordion.header` and `accordion.collapse` directly. Match the header's `target` to the collapse element's `id`, and use the same `show` value on both.

```html
<x-forms::accordion id="custom-faq">
    <div class="accordion-item">
        <x-forms::accordion.header target="custom-requirements" show>
            Required documents
        </x-forms::accordion.header>

        <x-forms::accordion.collapse id="custom-requirements" parent="custom-faq" show>
            <p>Have your identification ready.</p>
        </x-forms::accordion.collapse>
    </div>
</x-forms::accordion>
```

This example uses Bootstrap 5's item wrapper class. For Material Admin 2.6, use `accordion__item` on the wrapper.

### Header Options

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `target` | `string` | **Required** | ID of the panel to toggle, without `#`. |
| `title` | `string` | `''` | Header text when the default slot is empty. |
| `show` | `bool` | `false` | Initial `aria-expanded` state. Match the panel's `show` value. |
| `framework` | `string` | `''` | Uses `forms.framework` when omitted. |

### Collapse Options

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `parent` | `string` | **Required** | ID of the parent accordion, without `#`. |
| `content` | `string` | `''` | Body text, escaped with line breaks preserved. When non-empty, overrides the default slot. |
| `show` | `bool` | `false` | Adds the `show` class to initially expand the panel. |
| `framework` | `string` | `''` | Uses `forms.framework` when omitted. |

Set the collapse element's `id` as an HTML attribute; the collapse component does not generate one itself.

## Frameworks and HTML Attributes

Generated items inherit the accordion's `framework`. When creating items or separate header and collapse components manually, pass the same `framework` to each if you are overriding the configured default.

Bootstrap 5 uses `data-bs-toggle`, `data-bs-target`, and `data-bs-parent` for collapse behavior. Material Admin 2.6 uses `data-toggle`, `data-target`, and `data-parent`. Load the matching theme styles and JavaScript.

Additional HTML attributes are passed to the outer element of each component. Classes are merged with the component's default classes.

```html
<x-forms::accordion id="application-faq" :items="$items" class="mb-4" data-section="faq" />
```

See [Installation & Setup](../installation-and-setup.md) to configure the default framework or publish the component views.
