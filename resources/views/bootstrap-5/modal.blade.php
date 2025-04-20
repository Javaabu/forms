<div
    {{ $attributes->merge(['class' => 'modal fade', 'tabindex' => -1]) }}
    id="{{ $attributes->get('id') ?: $id() }}"
>
    <div class="modal-dialog {{ $modalSizeClass ?? 'modal-lg' }}">
        <div class="modal-content">
            <div class="modal-header">
                @if($title)
                    <h5 class="modal-title">
                        {{ $title }}
                    </h5>
                @endif

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

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
