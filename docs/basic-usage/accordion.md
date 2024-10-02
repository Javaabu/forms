---
title: Accordion
sidebar_position: 10
---

You can use the `accordion` component to render JavaScript accordion. The `accordion` component requires an array or Collection of items. The content for each item can be passed as named slots with the slot names same as the key of the item in kebab case. If you want to add html content to the item header, you can use the `{item-slot-name}-header` slot to provide the content for that item's header.


```bladehtml
@php
$items = [
    'collapseOne' => ['show' => true, 'id' => 'item-1'],
    'collapseTwo' => ['title' => 'Accordion Item #2', 'id' => 'item-2', 'content' => 'Second item Body']
]
@endphp

<x-forms::accordion id="accordionExample" :items="$items">
    <x-slot:collapse-one-header>
        Accordion Item #1
    </x-slot:collapse-one-header>

    <x-slot:collapse-one>
        <strong>First item Body</strong>
    </x-slot:collapse-one>
</x-forms::accordion>
```

The accordion items support the following values:
- `'show'` - Whether to have the item open or not.
- `'title'` - Title for the item
- `'content'` - Content for the item
- `'id''` - The css id for the item

If your items array is not associative, the slots name for each item will be `item-{index}`.

```bladehtml
@php
    $items = [
        ['show' => true, 'id' => 'item-1'],
        ['title' => 'Accordion Item #2', 'id' => 'item-2']
    ]
@endphp

<x-forms::accordion id="accordionExample" :items="$items">
    <x-slot:item-0-header>
        Accordion Item #1
    </x-slot:item-0-header>

    <x-slot:item-0>
        <strong>First item Body</strong>
    </x-slot:item-0>

    <x-slot:item-1>
        <strong>Second item Body</strong>
    </x-slot:item-1>
</x-forms::accordion>
```

Without passing an items array, you can manually create accordion items using the `accordion.item` component as well.

```bladehtml
<x-forms::accordion id="accordionExample">
    <x-forms::accordion.item id="item-1" name="collapseOne" parent="accordionExample" show>
        <x-slot:header>
            Accordion Item #1
        </x-slot:header>

        <strong>First item Body</strong>
    </x-forms::accordion.item>

    <x-forms::accordion.item id="item-2" name="collapseTwo" parent="accordionExample" :show="false" title="Accordion Item #2">
        <strong>Second item Body</strong>
    </x-forms::accordion.item>
</x-forms::accordion>
```

The `accordion.item` component supports the following attributes.
- `name` - (Required) Name of the item. This will be used for the collpase id.
- `parent` - (Required) CSS id of the parent accordion.
- `title` - Title for the item. Title can be passed through the `header` slot as well if HTML content is needed in the title.
- `content` - Content for the item. Content can be passed through the main slot as well if HTML content is needed.
- `show` - Whether to have the item open or not
- `framework` - Which css framework to use.
