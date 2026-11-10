@if($wrap)
    @if($inline && ! $floating)
<div {!! $attributes->merge(['class' => 'row mb-4']) !!}>
    @if($showLabel)
        <x-forms::label :blank-label="$blankLabel" :label="$label ?: $label()" for="{{ $blankLabel ? '' : $name }}" :inline-label-class="$inlineLabelClass" :framework="$framework" :inline="true" :required="$required" />
    @endif
    <div class="{{ $inlineInputClass }}">
        <div class="form-field">
            {!! $slot !!}
        </div>
    </div>
</div>
    @else
<div {!! $attributes->merge(['class' => 'form-field mb-4' . ($floating ? ' form-floating' : '')]) !!}>
    @if($showLabel)
        <x-forms::label :blank-label="$blankLabel" :label="$label ?: $label()" for="{{ $blankLabel ? '' : $name }}" :framework="$framework" :required="$required" :floating="$floating" />
    @endif

    {!! $slot !!}
</div>
    @endif
@else
    {!! $slot !!}
@endif
