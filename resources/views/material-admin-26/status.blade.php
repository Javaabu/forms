<span {!! $attributes->merge(['class' => 'status solid bg-' . $color]) !!}>
    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        {{ $name }}
    @endif
</span>
