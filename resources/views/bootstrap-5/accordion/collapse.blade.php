<div {!! $attributes->class([
    'accordion-collapse',
    'collapse',
    'show' => $show
]) !!}
     data-bs-parent="#{{ $parent }}">
    <div class="accordion-body">
        @if($content)
            {!! nl2br(e($content)) !!}
        @else
            {{ $slot }}
        @endif
    </div>
</div>
