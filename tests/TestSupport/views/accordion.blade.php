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

