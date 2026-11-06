<div
    {!! $attributes->merge([
        'class' => $frameworkClasses()->classes('button_group.button-group') . ($inline ? '' : ' flex-col'),
    ]) !!}
    data-slot="button-group"
    data-orientation="{{ $inline ? 'horizontal' : 'vertical' }}"
    role="group"
>{!! $slot !!}</div>
