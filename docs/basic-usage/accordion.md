---
title: Accordion
sidebar_position: 17
---

# Accordion

`<x-forms::accordion>` groups content into panels that open and close. Each panel is a native `<details>` element, so it works without JavaScript. Panels in one accordion share a `name`, so opening one closes the others.

## From an array

Give the accordion an `id` and pass the panels to `items`:

```blade
@php
    $faq = [
        'documents' => [
            'title' => 'ބޭނުންވާ ލިޔެކިޔުންތައް',
            'content' => 'ދިވެހި ރައްޔިތެއްކަން އަންގައިދޭ ކާޑު.',
            'show' => true,
        ],
        'status' => [
            'title' => __('How do I check my application?'),
            'content' => __('Sign in and open Applications.'),
        ],
    ];
@endphp

<x-forms::accordion id="application-faq" :items="$faq" />
```

Each item takes:

| Key | Default | Description |
| --- | --- | --- |
| `title` | `''` | Header text. |
| `content` | `''` | Body text. It's escaped, and line breaks become `<br>`. |
| `show` | `false` | Starts open. |
| `id` | none | `id` of the item's `<details>` element. |

Items can be an array or a `Collection`.

## HTML in headers and bodies

Use slots named after the item's key in kebab case: `{key}` for the body and `{key}-header` for the header. A slot replaces the item's `content` or `title`:

```blade
<x-forms::accordion id="application-faq" :items="$faq">
    <x-slot:documents-header>
        <strong>ބޭނުންވާ ލިޔެކިޔުންތައް</strong>
    </x-slot:documents-header>

    <x-slot:documents>
        <ul>
            <li>{{ __('ID card') }}</li>
            <li>{{ __('Proof of address') }}</li>
        </ul>
    </x-slot:documents>
</x-forms::accordion>
```

A key like `applicationStatus` uses `application-status` and `application-status-header`. For a list without keys, use `item-{index}` and `item-{index}-header` (`item-0`, `item-0-header`).

## Writing the items yourself

Leave out `items` and put `accordion.item` components in the slot. Each needs a `name` (the panel id) and a `parent` (the accordion's `id`):

```blade
<x-forms::accordion id="application-faq">
    <x-forms::accordion.item name="documents" parent="application-faq" show>
        <x-slot:header>
            <strong>ބޭނުންވާ ލިޔެކިޔުންތައް</strong>
        </x-slot:header>

        <p>{{ __('Have your ID card ready.') }}</p>
    </x-forms::accordion.item>

    <x-forms::accordion.item
        name="status"
        parent="application-faq"
        :title="__('How do I check my application?')"
        :content="__('Sign in and open Applications.')"
    />

    <x-forms::accordion.item name="payments" parent="application-faq" :title="__('Payments')" disabled>
        …
    </x-forms::accordion.item>
</x-forms::accordion>
```

- The `header` slot replaces `title`; `content` replaces the default slot.
- `disabled` keeps the item closed and makes it inert (it can't be opened or focused). `show` is ignored on a disabled item.

## Panel ids

The panel inside each item gets an `id`, which the header's `aria-controls` points at:

- For a keyed item, the key, with spaces replaced by hyphens (`documents`).
- For a list item, `{accordion-id}-item-{index}-collapse` (`application-faq-item-0-collapse`).

Keyed panels aren't prefixed with the accordion's id, so use different keys in two accordions on one page.

## Custom item markup

`accordion.header` renders the `<summary>` and `accordion.collapse` the panel. Wrap them in your own `<details>` with the accordion's id as its `name`:

```blade
<x-forms::accordion id="custom-faq">
    <details name="custom-faq" class="border-b" open>
        <x-forms::accordion.header target="requirements">{{ __('Requirements') }}</x-forms::accordion.header>
        <x-forms::accordion.collapse id="requirements" parent="custom-faq">
            <p>{{ __('Have your ID card ready.') }}</p>
        </x-forms::accordion.collapse>
    </details>
</x-forms::accordion>
```

## Rendered HTML

```html
<!-- onu (classes shortened) -->
<div class="…" id="application-faq" data-slot="accordion">
    <details class="… group/accordion-item" name="application-faq" data-slot="accordion-item" open>
        <summary class="…" aria-controls="documents" data-slot="accordion-trigger">
            ބޭނުންވާ ލިޔެކިޔުންތައް <svg data-slot="accordion-trigger-icon" …></svg>
        </summary>
        <div class="…" data-slot="accordion-content" data-accordion="application-faq" id="documents">…</div>
    </details>
</div>

<!-- bootstrap-6 -->
<div class="accordion" id="application-faq">
    <details class="accordion-item" name="application-faq" open>
        <summary class="accordion-header" aria-controls="documents">ބޭނުންވާ ލިޔެކިޔުންތައް <svg class="accordion-icon" …></svg></summary>
        <div class="accordion-body" data-accordion="application-faq" id="documents">…</div>
    </details>
</div>
```

## Attributes

### `accordion`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `id` | `string` | required | Accordion id. Items use it as their `name`. |
| `items` | `array` or `Collection` | `[]` | Panels. See [From an array](#from-an-array). |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Other attributes go on the wrapper. Slots: default (items), `{key}`, `{key}-header`.

### `accordion.item`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | required | Panel id. |
| `parent` | `string` | required | The accordion's id, without `#`. |
| `title` | `string` | `''` | Header text. The `header` slot replaces it. |
| `content` | `string` | `''` | Body text. Replaces the default slot. |
| `show` | `bool` | `false` | Starts open. |
| `disabled` | `bool` | `false` | Closed and inert. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Slots: default (the body), `header`.

### `accordion.header`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `target` | `string` | required | Id of the panel it controls. |
| `title` | `string` | `''` | Header text. The slot replaces it. |
| `show` | `bool` | `false` | Not used by the markup; open state is on the `<details>`. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

### `accordion.collapse`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `parent` | `string` | required | The accordion's id. |
| `content` | `string` | `''` | Body text. Replaces the slot. |
| `show` | `bool` | `false` | Not used by the markup; open state is on the `<details>`. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Pass the panel's `id` as an attribute.

## React

```jsx
import { Accordion, AccordionItem } from "@javaabu/forms"

<Accordion id="application-faq">
  <AccordionItem name="documents" parent="application-faq" title="ބޭނުންވާ ލިޔެކިޔުންތައް" show>
    …
  </AccordionItem>
</Accordion>
```

`accordion.header` and `accordion.collapse` are Blade only. See [Parity](../parity.md).
