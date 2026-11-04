@if($slot->isNotEmpty() || $label || $blankLabel)
    <label {!! $attributes->merge(['class' => $frameworkClasses()->classes('field.label') . ($inline ? ' ' . $inlineLabelClass : '')]) !!} data-slot="label">
        @if($slot->isNotEmpty())
            {{ $slot }}
        @else
            {{ $label }}
            @if($required)<x-forms::label-required :framework="$framework" />@endif
        @endif
    </label>
@endif
