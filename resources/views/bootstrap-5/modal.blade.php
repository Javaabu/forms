<div
    {{ $attributes->merge(['class' => 'modal fade', 'tabindex' => -1]) }}
    id="{{ $attributes->get('id') ?: $id() }}"
>
    <div class="modal-dialog {{ $modalSizeClass ?? 'modal-lg' }}">
        <div class="modal-content">
            @if($title)
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $title }}
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            @endif

            <div class="modal-body">
                {{ $slot }}
            </div>

            @if($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
