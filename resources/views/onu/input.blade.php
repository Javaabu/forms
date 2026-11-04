@php($c = $frameworkClasses())
@php($grouped = $isDateInput() || (! empty($prepend)) || (! empty($append)))
<x-forms::form-group :wrap="$showLabel && $type != 'hidden'" :label="$label ?: $label()"
                     :name="$attributes->get('id') ?: $id()" :framework="$framework" :inline="$inline"
                     :inline-input-class="$inlineInputClass"
                     :inline-label-class="$inlineLabelClass"
                     :required="$required" :floating="$floating">
    @if($grouped)
        <div class="{{ $c->classes('input_group.input-group') }}" data-slot="input-group" role="group">
            @if($isDateInput())
                <div class="{{ $c->classes('input_group.input-group-addon') }} {{ $iconWrapperClass }}" data-slot="input-group-addon" data-align="inline-start" aria-hidden="true">
                    <x-forms::icon :name="$icon" :framework="$framework" />
                </div>
            @elseif(! empty($prepend))
                <div class="{{ $c->classes('input_group.input-group-addon') }}" data-slot="input-group-addon" data-align="inline-start">
                    <span class="{{ $c->classes('input_group_text') }}">{{ $prepend }}</span>
                </div>
            @endif
    @endif

            @if($isFileInput())
                @include('forms::onu.file.file-input')
            @else
                <input
                    {!! $attributes->merge([
                        'class' => ($grouped ? $c->classes('input_group.input-group-control') : $c->classes('input.input')) . ($hasError($name) ? ' is-invalid' : '') . ($isDateInput() ? ' ' . $datePickerClass() : ''),
                        'required' => $required,
                        'aria-invalid' => $hasError($name) ? 'true' : null,
                    ] + $getDefaultAttributes()) !!}
                    data-slot="{{ $grouped ? 'input-group-control' : 'input' }}"
                    type="{{ $type }}"
                    value="{{ $value ?? ($type === 'color' ? '#000000' : '') }}"
                    name="{{ $name }}"
                    @if($label && ! $attributes->get('id'))
                        id="{{ $id() }}"
                    @endif
                    @if($placeholder)
                        placeholder="{{ $placeholder }}"
                    @endif
                />
            @endif

    @if($grouped)
            @if($isDateInput())
                <div class="{{ $c->classes('input_group.input-group-addon') }}" data-slot="input-group-addon" data-align="inline-end">
                    <button type="button" data-date-clear="#{{ $attributes->get('id') ?: $id() }}"
                            class="{{ $c->classes('input_group.button') }} btn-date-clear disable-w-input {{ $clearBtnClass }}" data-slot="button" title="{{ __('forms::strings.clear') }}" aria-label="{{ __('forms::strings.clear') }}">
                        <x-forms::icon :name="$clearIcon" :framework="$framework" />
                    </button>
                </div>
            @elseif(! empty($append))
                <div class="{{ $c->classes('input_group.input-group-addon') }}" data-slot="input-group-addon" data-align="inline-end">
                    <span class="{{ $c->classes('input_group_text') }}">{{ $append }}</span>
                </div>
            @endif
        </div>
    @endif

    @if(! empty($help))
        <x-forms::input-help :framework="$framework" :attributes="$help->attributes">
            {{ $help }}
        </x-forms::input-help>
    @endif

    @if($hasErrorAndShow($name))
        <x-forms::errors :framework="$framework" :name="$name"/>
    @endif

    @if($showJsErrors)
        <x-forms::js-errors :framework="$framework" :name="$name" />
    @endif
</x-forms::form-group>
