<x-forms::form-group :inline-input-class="$inlineInputClass" :inline-label-class="$inlineLabelClass" :wrap="$showLabel" :label="$label ?: $label()" :name="$attributes->get('id') ?: $id()" :framework="$framework" :inline="$inline" :required="$required" :floating="$floating">
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

        <div class="mb-3 fileinput-preview-outer-wrapper{{ $fullwidth ? ' fullwidth-preview' : '' }}">
            <div class="embed-responsive" style="padding-top: {{ ($maintainAspectRatio ? $aspectRatio : 1) * 100 }}%;">
                <div class="embed-responsive-item">
                    <div @class([
                                'fileinput-preview-wrapper',
                                'cover-preview' => $cover || $circle,
                                'rounded-circle' => $circle,
                            ])
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
                </div>
            </div>
        </div>

        <div>
            <span class="btn btn-info btn-file {{ $disabled ? 'disabled' : '' }} mb-1">
                <span class="btn--icon-text{{ $upload ? ' upload-btn' : ' fileinput-new' }}">
                    <i class="{{ $upload ? $uploadIcon : $icon }}"></i>&nbsp;
                    {{ $upload ? trans('forms::strings.fileinput_upload_file') : trans('forms::strings.fileinput_select_file') }}
                </span>
                @if(! $upload)
                <span class="fileinput-exists btn--icon-text">
                    <i class="{{ 'zmdi zmdi-folder' }}"></i> {{ trans('forms::strings.fileinput_change_file') }}
                </span>
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
            <a href="#" class="mb-1 btn btn-danger btn--icon-text {{ $disabled ? 'disabled' : '' }} fileinput-exists"
               @if(! $disabled)
                   data-dismiss="fileinput"
                @endif
            >
                <i class="{{ $clearIcon }}"></i> {{ __('Remove') }}
            </a>
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
