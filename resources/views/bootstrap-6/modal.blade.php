@php($dialog_size = $modalSizeClass ? \Illuminate\Support\Str::after($modalSizeClass, 'modal-') : $size)
@php($dialog_size = match ($dialog_size) { 'md', 'default', '' => '', 'full' => 'fullscreen', default => $dialog_size })
<dialog
    {{ $attributes->merge(['class' => 'dialog' . ($dialog_size ? " dialog-{$dialog_size}" : '')]) }}
    id="{{ $attributes->get('id') ?: $id() }}"
    @if($title)
    aria-labelledby="{{ ($attributes->get('id') ?: $id()) . '-title' }}"
    @endif
>
    @if(! $title)
        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="dialog" aria-label="{{ __('forms::strings.close') }}"></button>
    @endif

    @if($title)
        <div class="dialog-header">
            <h2 class="dialog-title" id="{{ ($attributes->get('id') ?: $id()) . '-title' }}">
                {{ $title }}
            </h2>
            @if($description)
                <p class="dialog-description fg-3 mb-0">{{ $description }}</p>
            @endif

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
