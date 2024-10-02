<div {!! $attributes->merge(['class' => 'accordion', 'id' => $id]) !!}>
    @foreach($items as $name => $item)
        @php
            $collapse_id = $generateCollapseIdByName($name);
            $slot_name = $generateSlotByName($name);
            $title_slot = $slot_name . 'Header';
        @endphp

        @isset(${$slot_name})
            <x-forms::accordion.item
                :framework="$framework"
                :id="$item['id'] ?? null"
                :name="$collapse_id"
                :parent="$id"
                :title="$item['title'] ?? ''"
                :show="! empty($item['show'])"
            >
                @isset(${$title_slot})
                    <x-slot:header>
                        {{ ${$title_slot} }}
                    </x-slot:header>
                @endisset

                {{ ${$slot_name} }}
            </x-forms::accordion.item>
        @endisset
    @endforeach

    {{ $slot }}
</div>
