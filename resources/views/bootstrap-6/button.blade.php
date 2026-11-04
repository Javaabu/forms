<button
    {!! $attributes->class([
        $frameworkClasses()->button($color),
        'animate-submit' => $animate,
    ]) !!}

    @if($type)
        type="{{ $type }}"
    @endif
>{!! $slot !!}</button>
