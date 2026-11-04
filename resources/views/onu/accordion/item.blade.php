<details {!! $attributes->merge(['class' => $frameworkClasses()->classes('accordion.accordion-item') . ' group/accordion-item', 'name' => $parent]) !!} data-slot="accordion-item" @if($show) open @endif>
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
        @if($content)
            {!! nl2br(e($content)) !!}
        @else
            {{ $slot }}
        @endif
    </x-forms::accordion.collapse>
</details>
