@php($c = $frameworkClasses())
@php($sizes = ['sm' => 'sm', 'md' => 'default', 'default' => 'default', 'lg' => 'lg', 'xl' => 'xl', 'fullscreen' => 'full', 'full' => 'full'])
@php($size_key = $sizes[$modalSizeClass ? \Illuminate\Support\Str::after($modalSizeClass, 'modal-') : $size] ?? 'lg')
@php($modal_id = $attributes->get('id') ?: $id())
<dialog
    {{ $attributes->merge(['class' => 'forms-dialog ' . $c->classes("modal.sizes.{$size_key}")]) }}
    id="{{ $modal_id }}"
    data-slot="dialog-content"
    @if($title)
    aria-labelledby="{{ $modal_id }}-title"
    @endif
>
    @if($title)
        <div class="{{ $c->classes('modal.modal-header') }}" data-slot="modal-header">
            <h2 class="{{ $c->classes('modal.modal-title') }}" id="{{ $modal_id }}-title" data-slot="modal-title">
                {{ $title }}
            </h2>
        </div>
    @endif

    <button type="button" class="{{ $c->classes('modal.button') }} absolute top-3 end-3" data-slot="button" data-variant="ghost" data-size="icon-sm" data-dismiss="modal" aria-label="{{ __('forms::strings.close') }}">
        <x-forms::icon name="x" :framework="$framework" />
    </button>

    <div class="{{ $c->classes('modal.modal-body') }}" data-slot="modal-body">
        {{ $slot }}
    </div>

    @if(! empty($footer))
        <div class="{{ $c->classes('modal.modal-footer') }}" data-slot="modal-footer">
            {{ $footer }}
        </div>
    @endif
</dialog>
