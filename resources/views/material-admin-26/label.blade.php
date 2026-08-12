@if($label || $blankLabel)
    <label {!! $attributes->merge([
    'class' => (! $floating && $inline ? $inlineLabelClass : null)]) !!}>
        @if($slot->isNotEmpty())
            {{ $slot }}
        @else
            {{ $label }}
            @if($required) <x-forms::label-required :framework="$framework" />@endif
        @endif
    </label>
@endif
