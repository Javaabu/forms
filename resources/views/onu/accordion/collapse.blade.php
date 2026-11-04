<div {!! $attributes->merge(['class' => $frameworkClasses()->classes('accordion.accordion-content')]) !!} data-slot="accordion-content" data-accordion="{{ $parent }}">
    <div class="pt-0 pb-2.5">
        @if($content)
            {!! nl2br(e($content)) !!}
        @else
            {{ $slot }}
        @endif
    </div>
</div>
