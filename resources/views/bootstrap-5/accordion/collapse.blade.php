<div {!! $attributes->class([
    'accordion-collapse',
    'collapse',
    'show' => $show
]) !!}
     data-bs-parent="#{{ $parent }}">
    <div class="accordion-body">
        {{ $slot }}
    </div>
</div>
