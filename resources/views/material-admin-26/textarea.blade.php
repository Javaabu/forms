<x-forms::form-group :inline-input-class="$inlineInputClass" :inline-label-class="$inlineLabelClass" :wrap="$showLabel && $type != 'hidden'" :label="$label ?: $label()" :name="$attributes->get('id') ?: $id()" :framework="$framework" :inline="$inline" :required="$required" :floating="$floating">
    <textarea
        {!! $attributes->merge([
            'class' => 'form-control' . ($hasError($name) ? ' is-invalid' : '') . ($wysiwyg ? ' wysiwyg' : ''),
            'required' => $required
        ]) !!}
        type="{{ $type }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if($label && ! $attributes->get('id'))
            id="{{ $id() }}"
        @endif
        {{--  Placeholder is required as of writing  --}}
        @if($floating || $placeholder)
            @if($placeholder)
                placeholder="{{ $placeholder }}"
            @else
                placeholder="&nbsp;"
            @endif
        @endif
    >{!! $value !!}</textarea>
    <i class="form-group__bar"></i>

    @if(! empty($help))
        <x-forms::input-help :framework="$framework">
            {!! $help !!}
        </x-forms::input-help>
    @endif

    @if($hasErrorAndShow($name))
        <x-forms::errors :framework="$framework" :name="$name" />
    @endif
</x-forms::form-group>

@if($wysiwyg)
    @pushonce(config('forms.scripts_stack'))
        @include('forms::partials.wysiwyg-script')
    @endpushonce
@endif
