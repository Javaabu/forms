<x-forms::form-group :inline-input-class="$inlineInputClass" :inline-label-class="$inlineLabelClass" :show-label="$inline" :wrap="$showLabel && $type != 'hidden'" :label="$label ?: $label()" :name="$attributes->get('id') ?: $id()" :framework="$framework" :inline="$inline" :required="$required" :floating="$floating">
    <div
        @class([
            'checkbox',
            'mt-2' => $inline,
            'mb-2' => ! $inline,
        ])>
        <input
            {!! $attributes->merge([
                'class' => ($hasErrorAndShow($name) ? 'is-invalid' : '')
            ]) !!}
            id="{{ $attributes->get('id') ?: $id() }}"
            name="{{ $name }}"
            type="checkbox"
            value="{{ $value }}"
            @required($required)
            @checked($checked)
        />

        <x-forms::label
            :label="$inline ? ' ' : ($label ?: $label())"
            :for="$attributes->get('id') ?: $id()"
            class="checkbox__label"
            :required="$inline ? false : $required" />
    </div>

    @if(! empty($help))
        <x-forms::input-help :framework="$framework" :attributes="$help->attributes">
            {{ $help }}
        </x-forms::input-help>
    @endif

    @if($hasErrorAndShow($name))
        <x-forms::errors :framework="$framework" :name="$name" />
    @endif

    @if($showJsErrors)
        <x-forms::js-errors :framework="$framework" :name="$name" />
    @endif
</x-forms::form-group>
