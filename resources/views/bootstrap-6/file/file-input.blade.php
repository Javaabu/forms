<div data-provides="fileinput" @class([
        'fileinput',
        $fileInputClass,
        'fileinput-exists' => (bool) $value,
        'fileinput-new' => empty($value),
    ])>
    <span class="btn-solid theme-primary btn-file me-3">
        <span class="fileinput-new">{{ trans('forms::strings.fileinput_select_file') }}</span>
        <span class="fileinput-exists">{{ trans('forms::strings.fileinput_change_file') }}</span>
        <input
            {!! $attributes->merge([
                'class' => ($hasError($name) ? 'is-invalid' : ''),
                'required' => $required
            ]) !!}
            type="file"
            accept="{{ implode(',', $mimeTypes) }}"
            name="{{ $name }}"
            @if($label && ! $attributes->get('id'))
                id="{{ $id() }}"
            @endif
    />
    </span>
    <span class="fileinput-filename">
        @unless(empty($value))
            <a href="{{ $value }}" target="_blank">
                <x-forms::icon name="download" :framework="$framework" /> {{ $value }}
            </a>
        @endunless
    </span>
    <button type="button" class="btn-close fileinput-exists" data-dismiss="fileinput" aria-label="{{ __('forms::strings.fileinput_remove_file') }}"></button>
</div>
