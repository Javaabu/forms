<div {!! $attributes->merge(['class' => 'accordion-item']) !!}>
    <x-forms::accordion.header
        :framework="$framework"
        :title="$title"
        :target="$name"
        :show="$show"
    >
        @if(! empty($header))
            {{ $header }}
        @endif
    </x-forms::accordion.header>

    <x-forms::accordion.collapse
        :framework="$framework"
        :parent="$parent"
        :id="$name"
        :show="$show"
    >
        {{ $slot }}
    </x-forms::accordion.collapse>
</div>
