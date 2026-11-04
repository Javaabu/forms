<div data-provides="fileinput" @class([
        'fileinput',
        $fileInputClass,
        'fileinput-exists' => (bool) $value,
        'fileinput-new' => empty($value),
    ])>
    <span class="btn-file relative inline-flex overflow-hidden me-3 {{ $frameworkClasses()->button('primary') }}">
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
    <button type="button" class="fileinput-exists {{ $frameworkClasses()->button('link', 'icon-sm') }}" data-dismiss="fileinput" aria-label="{{ __('forms::strings.fileinput_remove_file') }}"><x-forms::icon name="x" :framework="$framework" /></button>
</div>
