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

