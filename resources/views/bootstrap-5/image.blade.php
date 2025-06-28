<x-forms::form-group :wrap="$showLabel" :label="$label ?: $label()" :name="$attributes->get('id') ?: $id()" :framework="$framework" :inline="$inline" :required="$required" :floating="$floating">
    <div @class([
        'fileinput',
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

        <div class="d-flex flex-column">
            <div @class([
                    'fileinput-preview-wrapper',
                    'cover-preview' => $cover || $circle,
                    'rounded-circle' => $circle,
                    'fullwidth-preview' => $fullwidth,
                    'ratio'
                ])
                 style="--bs-aspect-ratio: {{ ($maintainAspectRatio ? $aspectRatio : 1) * 100 }}%;"
                 @if(! $disabled)
                 data-trigger="fileinput"
                 @endif
            >
                <div class="fileinput-preview">
                    <img src="{{ $value }}">
                </div>

                <div class="fileinput-image-missing fileinput-new">
                    <i class="image-icon {{ $icon }}"></i>
                    <span class="px-2">{{ trans('forms::strings.imageinput_select_image') }}</span>
                </div>
            </div>

            <div class="fileinput-wrapper border-0">
                <span class="btn-file flex-grow-0 me-2">
                    <span class="fileinput-btn btn-file-selector {{ $upload ? 'upload-btn' : 'fileinput-new' }}">
                        @if($upload)
                            <i class="{{ $uploadIcon }} me-2"></i>&nbsp;
                            {{ trans('forms::strings.fileinput_upload_file') }}
                        @else
                            {{ trans('forms::strings.fileinput_select_file') }}
                        @endif
                    </span>
                    @if(! $upload)
                    <span class="fileinput-btn btn-file-selector fileinput-exists">{{ trans('forms::strings.fileinput_change_file') }}</span>
                    @endif
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
                    />
                </span>
                <button type="button" class="fileinput-btn btn-file-selector fileinput-exists"
                        @if($disabled)
                            disabled
                        @else
                            data-dismiss="fileinput"
                       @endif
                >{{ trans('forms::strings.fileinput_remove_file') }}</button>
            </div>
        </div>
    </div>

    @if($showHint || (! empty($help)))
        <x-forms::input-help :framework="$framework">
            @empty($help)
                {{ $getImageHint() }}<br>
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
