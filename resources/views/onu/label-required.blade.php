@if($text)
    <span {!! $attributes->merge(['class' => 'required ' . $frameworkClasses()->classes('field.required-marker')]) !!} data-slot="required-marker" aria-hidden="true">{{ $text }}</span>
@endif
