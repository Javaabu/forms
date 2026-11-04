<x-forms::form-group :class="$groupClass()" :inline-input-class="$inlineInputClass" :inline-label-class="$inlineLabelClass" :show-label="$inline" :wrap="$showLabel && $type != 'hidden'" :label="$label ?: $label()" :name="$attributes->get('id') ?: $id()" :framework="$framework" :inline="$inline" :required="$required" :floating="$floating">
    <div class="form-field">
        <input
            {!! $attributes->merge([
                'class' => 'check' . ($hasErrorAndShow($name) ? ' is-invalid' : ''),
                'aria-invalid' => $hasErrorAndShow($name) ? 'true' : null,
            ]) !!}
            id="{{ $attributes->get('id') ?: $id() }}"
            name="{{ $name }}"
            type="checkbox"
            value="{{ $value }}"
            @required($required)
            @checked($checked)
        >
        @if(! empty($help))
            <div class="form-field-content">
        @endif
        <x-forms::label
            :label="$inline ? ' ' : ($label ?: $label())"
            :for="$attributes->get('id') ?: $id()"
            class="check-label"
            :framework="$framework"
            :required="$inline ? false : $required"
        >@if($slot->isNotEmpty()){{ $slot }}@endif
        </x-forms::label>
        @if(! empty($help))
                <x-forms::input-help :framework="$framework" :attributes="$help->attributes">
                    {{ $help }}
                </x-forms::input-help>
            </div>
        @endif
    </div>

    @if($hasErrorAndShow($name))
        <x-forms::errors :framework="$framework" :name="$name" />
    @endif

    @if($showJsErrors)
        <x-forms::js-errors :framework="$framework" :name="$name" />
    @endif
</x-forms::form-group>
