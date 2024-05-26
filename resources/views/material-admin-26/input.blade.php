<x-forms::form-group :wrap="$showLabel && $type != 'hidden'" :label="$label ?: $label()" :name="$attributes->get('id') ?: $id()" :framework="$framework" :inline="$inline" :required="$required" :floating="$floating">
    @if($isDateInput() || (! empty($prepend)) || (! empty($append)))
    <div class="input-group mb-0">
        @if($isDateInput() || (! empty($prepend)))
            <div class="input-group-prepend">
                @if($isDateInput())
                    <span class="input-group-text">
                    <i class="{{ $icon }}"></i>
                </span>
                @elseif(! empty($prepend))
                    {{ $prepend }}
                @endif
            </div>
        @endif
    @endif

    @if($isFileInput())
        @include('forms::material-admin-26.file.file-input')
    @else
        <input
            {!! $attributes->merge([
                'class' => 'form-control' . ($type === 'color' ? ' form-control-color' : '') . ($hasError($name) ? ' is-invalid' : '') . ($isDateInput() ? ' ' . $datePickerClass() : ''),
                'required' => $required
            ]) !!}
            type="{{ $type }}"
            value="{{ $value ?? ($type === 'color' ? '#000000' : '') }}"
            name="{{ $name }}"
            @if($label && ! $attributes->get('id'))
                id="{{ $id() }}"
            @endif
            {{--  Placeholder is required as of writing  --}}
            @if($floating && !$attributes->get('placeholder'))
                placeholder="&nbsp;"
            @endif
        />
        @if($showLabel)
        <i class="form-group__bar"></i>
        @endif
    @endif

    @if($isDateInput() || (! empty($prepend)) || (! empty($append)))
        @if($isDateInput() || (! empty($append)))
            <div class="input-group-append">
                @if($isDateInput())
                    <div class="input-group-text input-group-text-link">
                        <a href="#" data-date-clear="#{{ $attributes->get('id') ?: $id() }}" class="{{ $clearBtnClass }}" title="{{ __('Clear') }}">
                            <i class="{{ $clearIcon }}"></i>
                        </a>
                    </div>
                @elseif(! empty($append))
                    {{ $append }}
                @endif
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
        <x-forms::errors :framework="$framework" :name="$name" />
    @endif
</x-forms::form-group>
