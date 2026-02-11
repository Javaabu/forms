<x-forms::form-group :inline-input-class="$inlineInputClass" :inline-label-class="$inlineLabelClass" :wrap="$showLabel" :label="$label ?: $label()" :name="$attributes->get('id') ?: $id()" :framework="$framework" :inline="$inline" :required="$required" :floating="$floating">
    <div @class([
        'fileinput',
        'fileinput-wrapper',
        $fileInputClass,
        'fileinput-exists' => (bool) $value,
        'fileinput-new' => empty($value),
        'is-invalid' => $hasError($name),
        'disabled' => $disabled,
    ])
        @if(! $disabled)
            data-provides="fileinput{{ $upload ? '-upload' : '' }}"
        @endif
    >
        <span class="fileinput-filename d-none"></span>
        <span class="btn-file">
            @if($upload)
                <span class="btn-file-selector upload-btn">
                    <i class="{{ $uploadIcon }} me-2"></i>&nbsp;
                    {{ trans('forms::strings.fileinput_upload_file') }}
                </span>
            @else
                <span class="btn-file-selector fileinput-new">{{ trans('forms::strings.fileinput_select_file') }}</span>
                <span class="btn-file-selector fileinput-exists">{{ trans('forms::strings.fileinput_change_file') }}</span>
            @endif
            <span class="fileinput-selected-filename fileinput-missing fileinput-new text-truncate">{{ trans('forms::strings.fileinput_nothing_selected') }}</span>
            <span class="fileinput-filename fileinput-selected-filename fileinput-exists text-truncate"></span>
            <input
                {!! $attributes->merge([
                    'class' => ($hasError($name) ? 'is-invalid' : ''),
                    'required' => $required,
                    'disabled' => $disabled
                ]) !!}
                type="file"
                accept="{{ implode(',', $mimetypes) }}"
                name="{{ $name }}"
                @if($label && ! $attributes->get('id'))
                    id="{{ $id() }}"
                @endif
                @if($upload && $maxSize)
                    data-max-file-size="{{ $maxSize }}"
                @endif
            />
        </span>

        @unless(empty($value))
            <a class="fileinput-filelink text-truncate btn btn-link text-decoration-none fileinput-exists" title="{{ $value }}" target="_blank" href="{{ $value }}">
                <i class="{{ $downloadIcon }} me-2"></i> {{ $fileName ?: $value }}
            </a>
        @endunless

        <button type="button" class="btn btn-outline-secondary btn-dismiss fileinput-exists"
                @if($disabled)
                    disabled
                @else
                    data-dismiss="fileinput"
                @endif
        >
            <i class="{{ $clearIcon }}"></i>
        </button>
    </div>

    @if($showHint || (! empty($help)))
        <x-forms::input-help :framework="$framework">
            @empty($help)
                {{ $getHint() }}
            @else
            {!! $help !!}
            @endempty
        </x-forms::input-help>
    @endif

    @if($hasErrorAndShow($name))
        <x-forms::errors :framework="$framework" :name="$name" />
    @endif

    @if($showJsErrors)
        <x-forms::js-errors :framework="$framework" :name="$name" />
    @endif
</x-forms::form-group>
