@if($label || $blankLabel)
    <label {!! $attributes->merge([
    'class' => (! $floating && $inline ? $inlineLabelClass : null)]) !!}>
        {{ $label }}
        @if($required)
            <x-forms::label-required :framework="$framework"></x-forms::label-required>
        @endif
    </label>
@endif
