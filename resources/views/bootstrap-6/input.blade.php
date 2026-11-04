<x-forms::form-group :class="$groupClass()" :wrap="$showLabel && $type != 'hidden'" :label="$label ?: $label()"
                     :name="$attributes->get('id') ?: $id()" :framework="$framework" :inline="$inline"
                     :inline-input-class="$inlineInputClass"
                     :inline-label-class="$inlineLabelClass"
                     :required="$required" :floating="$floating">
    @if($isDateInput() || (! empty($prepend)) || (! empty($append)))
        <div class="input-group">
            @if($isDateInput())
                <span class="input-group-text {{ $iconWrapperClass }}" aria-hidden="true">
                    <x-forms::icon :name="$icon" :framework="$framework" />
                </span>
            @elseif(! empty($prepend))
                {{ $prepend }}
            @endif
            @endif

            @if($isFileInput())
                @include('forms::bootstrap-6.file.file-input')
            @else
                <input
                    {!! $attributes->merge([
                        'class' => 'form-control' . ($type === 'color' ? ' form-control-color' : '') . ($hasError($name) ? ' is-invalid' : '') . ($isDateInput() ? ' ' . $datePickerClass() : ''),
                        'required' => $required,
                        'aria-invalid' => $hasError($name) ? 'true' : null,
                    ] + $thaanaAttributes() + $getDefaultAttributes()) !!}
                    @if($decimalPlaces() !== null)
                        data-decimals="{{ $decimalPlaces() }}"
                    @endif
                    type="{{ $type }}"
                    value="{{ $value ?? ($type === 'color' ? '#000000' : '') }}"
                    name="{{ $name }}"
                    @if($label && ! $attributes->get('id'))
                        id="{{ $id() }}"
                    @endif
                    @if($floating || $placeholder)
                        placeholder="{{ $placeholder ?: ' ' }}"
                    @endif
                />
            @endif

            @if($isDateInput() || (! empty($prepend)) || (! empty($append)))
                @if($isDateInput())
                    <button type="button" data-date-clear="#{{ $attributes->get('id') ?: $id() }}"
                            class="btn-outline theme-secondary input-group-btn btn-date-clear disable-w-input {{ $clearBtnClass }}" title="{{ __('forms::strings.clear') }}" aria-label="{{ __('forms::strings.clear') }}">
                        <x-forms::icon :name="$clearIcon" :framework="$framework" />
                    </button>
                @elseif(! empty($append))
                    {{ $append }}
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
