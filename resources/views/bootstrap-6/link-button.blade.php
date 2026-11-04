<a
    {!! $attributes->merge([
        'class' => $frameworkClasses()->button($color),
    ]) !!}

    @if($url)
        href="{{ $url }}"
    @endif
>{!! $slot !!}</a>
