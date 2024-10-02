<div {!! $attributes->class([
    'collapse',
    'show' => $show
]) !!}
     data-parent="#{{ $parent }}">
    <div class="accordion__content">
        @if($content)
            {!! nl2br(e($content)) !!}
        @else
            {{ $slot }}
        @endif
    </div>
</div>
