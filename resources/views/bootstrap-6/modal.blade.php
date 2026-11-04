<dialog
    {{ $attributes->merge(['class' => 'dialog ' . ($modalSizeClass ? str_replace('modal-', 'dialog-', $modalSizeClass) : 'dialog-' . $size)]) }}
    id="{{ $attributes->get('id') ?: $id() }}"
    @if($title)
    aria-labelledby="{{ ($attributes->get('id') ?: $id()) . '-title' }}"
    @endif
>
    @if($title)
        <div class="dialog-header">
            <h2 class="dialog-title" id="{{ ($attributes->get('id') ?: $id()) . '-title' }}">
                {{ $title }}
            </h2>

            <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="{{ __('forms::strings.close') }}"></button>
        </div>
    @endif

    <div class="dialog-body">
        {{ $slot }}
    </div>

    @if(! empty($footer))
        <div class="dialog-footer">
            {{ $footer }}
        </div>
    @endif
</dialog>
