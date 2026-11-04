<a
    {!! $attributes->merge([
        'class' => $frameworkClasses()->button($color),
    ]) !!}
    data-slot="button"
    data-variant="{{ $frameworkClasses()->buttonVariant($color) }}"
    data-size="default"
    @if($url)
        href="{{ $url }}"
    @endif
>{!! $slot !!}</a>
