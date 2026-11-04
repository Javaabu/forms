@php($c = $frameworkClasses())
@if($wrap)
    @php($layout = $inline && ! $floating ? 'field_inline' : 'field')
<div {!! $attributes->merge(['class' => $c->classes("{$layout}.form-field") . ' mb-4']) !!} data-slot="form-field" data-label-layout="{{ $inline && ! $floating ? 'inline' : 'stacked' }}">
    <div class="{{ $c->classes("{$layout}.grid") }}">
        @if($showLabel)
            <div class="{{ $c->classes("{$layout}.label_row") }} {{ $inline ? $inlineLabelClass : '' }}">
                <x-forms::label :blank-label="$blankLabel" :label="$label ?: $label()" for="{{ $blankLabel ? '' : $name }}" :framework="$framework" :required="$required" />
            </div>
        @endif
        <div class="{{ $c->classes("{$layout}.control") }} {{ $inline ? $inlineInputClass : '' }}">
            {!! $slot !!}
        </div>
    </div>
</div>
@else
    {!! $slot !!}
@endif
