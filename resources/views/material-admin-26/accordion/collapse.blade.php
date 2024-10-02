<div {!! $attributes->class([
    'collapse',
    'show' => $show
]) !!}
     data-parent="#{{ $parent }}">
    <div class="accordion__content">
        {{ $slot }}
    </div>
</div>
