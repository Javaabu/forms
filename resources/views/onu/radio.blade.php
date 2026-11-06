@php($c = $frameworkClasses())
<x-forms::form-group :class="$groupClass()" :inline-input-class="$inlineInputClass" :inline-label-class="$inlineLabelClass" :show-label="$inline" :wrap="$showLabel && $type != 'hidden'" :label="$label ?: $label()" :name="$attributes->get('id') ?: $id()" :framework="$framework" :inline="$inline" :required="$required" :floating="$floating">
    <div class="{{ $c->classes('choice.checkbox-field') }}" data-slot="radio-field">
        <span class="{{ $c->classes('choice.control') }}">
            <input
                {!! $attributes->except(['id'])->merge([
                    'class' => $c->classes('radio.native') . ' forms-radio' . ($hasErrorAndShow($name) ? ' is-invalid' : ''),
                    'aria-invalid' => $hasErrorAndShow($name) ? 'true' : null,
                ]) !!}
                data-slot="radio"
                id="{{ $attributes->get('id') ?: $id() }}"
                name="{{ $name }}"
                type="radio"
                value="{{ $value }}"
                @required($required)
                @checked($checked)
            >
        </span>
        <div class="{{ $c->classes('choice.content') }}">
            <x-forms::label
                :label="$inline ? ' ' : ($label ?: $label())"
                :for="$attributes->get('id') ?: $id()"
                class="radio-label"
                :framework="$framework"
                :required="$inline ? false : $required"
            >@if($slot->isNotEmpty()){{ $slot }}@endif
            </x-forms::label>
            @if(! empty($help))
                <x-forms::input-help :framework="$framework" :attributes="$help->attributes">
                    {{ $help }}
                </x-forms::input-help>
            @endif
        </div>
    </div>

    @if($hasErrorAndShow($name))
        <x-forms::errors :framework="$framework" :name="$name" />
    @endif

    @if($showJsErrors)
        <x-forms::js-errors :framework="$framework" :name="$name" />
    @endif
</x-forms::form-group>
