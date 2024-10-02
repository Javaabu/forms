<div {!! $attributes->merge(['class' => 'accordion__title']) !!}
        data-toggle="collapse"
        data-target="#{{ $target }}"
        aria-expanded="{{ $show ? 'true' : 'false' }}"
        aria-controls="{{ $target }}">
    @if($slot->isNotEmpty()){{ $slot }}@else{{ $title }}@endif
</div>

