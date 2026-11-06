<span {!! $attributes->merge(['class' => 'status ' . $frameworkClasses()->badge($color)]) !!} data-slot="status-badge" data-tone="{{ $frameworkClasses()->tone($color) }}">
    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        {{ $label }}
    @endif
</span>
