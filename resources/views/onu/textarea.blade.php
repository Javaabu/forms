<x-forms::form-group :class="$groupClass()" :inline-input-class="$inlineInputClass" :inline-label-class="$inlineLabelClass" :wrap="$showLabel && $type != 'hidden'" :label="$label ?: $label()" :name="$attributes->get('id') ?: $id()" :framework="$framework" :inline="$inline" :required="$required" :floating="$floating">
    <textarea
        {!! $attributes->merge([
            'class' => $frameworkClasses()->classes('textarea.textarea') . ($hasError($name) ? ' is-invalid' : '') . ($wysiwyg ? ' wysiwyg' : ''),
            'required' => $required,
            'aria-invalid' => $hasError($name) ? 'true' : null,
        ] + $thaanaAttributes()) !!}
        @if($shouldAutoResize())
            data-auto-resize="true"
        @endif
        data-slot="textarea"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if($label && ! $attributes->get('id'))
            id="{{ $id() }}"
        @endif
        @if($placeholder)
            placeholder="{{ $placeholder }}"
        @endif
    >{{ $value }}</textarea>

    @if(! empty($help))
        <x-forms::input-help :framework="$framework">
            {!! $help !!}
        </x-forms::input-help>
    @endif

    @if($hasErrorAndShow($name))
        <x-forms::errors :framework="$framework" :name="$name" />
    @endif

    @if($showJsErrors)
        <x-forms::js-errors :framework="$framework" :name="$name" />
    @endif
</x-forms::form-group>

@if($wysiwyg)
    @include('forms::partials.assets', ['assets' => ['wysiwyg']])
@endif
