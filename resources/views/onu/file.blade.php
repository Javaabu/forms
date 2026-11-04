@php($c = $frameworkClasses())
<x-forms::form-group :inline-input-class="$inlineInputClass" :inline-label-class="$inlineLabelClass" :wrap="$showLabel" :label="$label ?: $label()" :name="$attributes->get('id') ?: $id()" :framework="$framework" :inline="$inline" :required="$required" :floating="$floating">
    <div @class([
        'fileinput',
        'fileinput-wrapper',
        $c->classes('input.input') . ' flex h-auto min-h-8 items-center gap-2 py-1 ps-1',
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
        <span class="fileinput-filename hidden"></span>
        <span class="btn-file relative inline-flex shrink-0 overflow-hidden {{ $frameworkClasses()->button('light', 'sm') }}">
            @if($upload)
                <span class="btn-file-selector upload-btn">
                    <x-forms::icon :name="$uploadIcon" :framework="$framework" class="me-1" />
                    {{ trans('forms::strings.fileinput_upload_file') }}
                </span>
            @else
                <span class="btn-file-selector fileinput-new">{{ trans('forms::strings.fileinput_select_file') }}</span>
                <span class="btn-file-selector fileinput-exists">{{ trans('forms::strings.fileinput_change_file') }}</span>
            @endif
            <span class="fileinput-selected-filename fileinput-missing fileinput-new truncate text-muted-foreground">{{ trans('forms::strings.fileinput_nothing_selected') }}</span>
            <span class="fileinput-filename fileinput-selected-filename fileinput-exists truncate"></span>
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
            <a class="fileinput-filelink fileinput-exists inline-flex min-w-0 items-center gap-1 truncate text-primary-7 hover:underline" title="{{ $value }}" target="_blank" href="{{ $value }}">
                <x-forms::icon :name="$downloadIcon" :framework="$framework" class="me-1" /> {{ $fileName ?: $value }}
            </a>
        @endunless

        <button type="button" class="btn-dismiss fileinput-exists ms-auto {{ $frameworkClasses()->button('link', 'icon-sm') }}" aria-label="{{ __('forms::strings.fileinput_remove_file') }}"
                @if($disabled)
                    disabled
                @else
                    data-dismiss="fileinput"
                @endif
        >
            <x-forms::icon :name="$clearIcon" :framework="$framework" />
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
