<div {!! $attributes->merge(['class' => 'accordion', 'role' => 'tablist', 'id' => $id]) !!}>
    @foreach($items as $name => $item)
        @php
            $collapse_id = $generateCollapseIdByName($name);
            $slot_name = $generateSlotByName($name);
            $title_slot = $slot_name . 'Header';
        @endphp

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

            @isset(${$slot_name})
                {{ ${$slot_name} }}
            @else
                {!! nl2br(e($item['content'] ?? '')) !!}
            @endisset
        </x-forms::accordion.item>
    @endforeach

    {{ $slot }}
</div>
