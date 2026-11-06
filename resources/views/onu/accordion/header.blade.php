<summary {!! $attributes->merge(['class' => $frameworkClasses()->classes('accordion.accordion-trigger') . ' list-none cursor-pointer [&::-webkit-details-marker]:hidden', 'aria-controls' => $target]) !!} data-slot="accordion-trigger">
    @if($slot->isNotEmpty()){{ $slot }}@else{{ $title }}@endif
    <x-forms::icon name="chevron-down" :framework="$framework" class="pointer-events-none shrink-0 transition-transform group-open/accordion-item:rotate-180" data-slot="accordion-trigger-icon" />
</summary>
