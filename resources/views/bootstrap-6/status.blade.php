<span {!! $attributes->merge(['class' => 'status ' . $frameworkClasses()->badge($color)]) !!}>
    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        {{ $label }}
    @endif
</span>
