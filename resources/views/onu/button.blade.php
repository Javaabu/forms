<button
    {!! $attributes->class([
        $frameworkClasses()->button($color),
        'animate-submit' => $animate,
    ]) !!}
    data-slot="button"
    data-variant="{{ $frameworkClasses()->buttonVariant($color) }}"
    data-size="default"
    type="{{ $type ?: 'button' }}"
>{!! $slot !!}</button>
