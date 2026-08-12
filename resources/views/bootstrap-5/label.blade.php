@if($slot->isNotEmpty() || $label || $blankLabel)
    <label {!! $attributes->merge(['class' => ($floating ? null : ($inline ? $inlineLabelClass : 'form-label'))]) !!}>
        @if($slot->isNotEmpty())
            {{ $slot }}
        @else
            {{ $label }}
            @if($required) <x-forms::label-required :framework="$framework" />@endif
        @endif
    </label>
@endif
