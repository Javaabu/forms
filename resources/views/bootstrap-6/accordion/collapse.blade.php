<div {!! $attributes->merge(['class' => 'accordion-body']) !!} data-accordion="{{ $parent }}">
    @if($content)
        {!! nl2br(e($content)) !!}
    @else
        {{ $slot }}
    @endif
</div>
