@if($label)
    <label {!! $attributes->merge(['class' => ($floating ? null : ($inline ? $inlineLabelClass : 'form-label'))]) !!}>{{ $label }}@if($required) <x-forms::label-required :framework="$framework" />@endif</label>
@endif
