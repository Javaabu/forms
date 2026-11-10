<div
    {!! $attributes->merge([
        'class' => $inline ? 'btn-group' : 'btn-group-vertical'
    ]) !!}
    role="group"
>{!! $slot !!}</div>
