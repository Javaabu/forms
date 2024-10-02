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

