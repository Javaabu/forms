@php($c = $frameworkClasses())
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

        <div class="flex flex-col gap-2">
            <div @class([
                    'fileinput-preview-wrapper',
                    'cover-preview' => $cover || $circle,
                    'relative flex items-center justify-center overflow-hidden rounded-lg border border-dashed border-input bg-muted text-muted-foreground cursor-pointer',
                    'rounded-full' => $circle,
                    'fullwidth-preview' => $fullwidth,
                ])
                 style="aspect-ratio: 1 / {{ $maintainAspectRatio ? $aspectRatio : 1 }};"
                 @if(! $disabled)
                 data-trigger="fileinput"
                 @endif
            >
                <div class="fileinput-preview">
                    <img src="{{ $value }}" alt="">
                </div>

                <div class="fileinput-image-missing fileinput-new">
                    <x-forms::icon :name="$icon" :framework="$framework" class="image-icon" />
                    <span class="px-2 text-sm">{{ trans('forms::strings.imageinput_select_image') }}</span>
                </div>
            </div>

            <div class="fileinput-wrapper flex items-center gap-2">
                <span class="btn-file relative inline-flex overflow-hidden">
                    <span class="fileinput-btn btn-file-selector {{ $upload ? 'upload-btn' : 'fileinput-new' }} {{ $frameworkClasses()->button('light', 'sm') }}">
                        @if($upload)
                            <x-forms::icon :name="$uploadIcon" :framework="$framework" class="me-1" />
                            {{ trans('forms::strings.fileinput_upload_file') }}
                        @else
                            {{ trans('forms::strings.fileinput_select_file') }}
                        @endif
                    </span>
                    @if(! $upload)
                    <span class="fileinput-btn btn-file-selector fileinput-exists {{ $frameworkClasses()->button('light', 'sm') }}">{{ trans('forms::strings.fileinput_change_file') }}</span>
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
                <button type="button" class="fileinput-btn btn-file-selector fileinput-exists {{ $frameworkClasses()->button('danger', 'sm') }}"
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
