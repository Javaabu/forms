@php
    $items = [
        'collapseOne' => ['show' => true, 'id' => 'item-1'],
        'collapseTwo' => ['title' => 'Accordion Item #2', 'id' => 'item-2']
    ]
@endphp

<x-forms::accordion id="accordionExample" :items="$items">
    <x-slot:collapse-one-header>
        Accordion Item #1
    </x-slot:collapse-one-header>

    <x-slot:collapse-one>
        <strong>First item Body</strong>
    </x-slot:collapse-one>

    <x-slot:collapse-two>
        <strong>Second item Body</strong>
    </x-slot:collapse-two>
</x-forms::accordion>

