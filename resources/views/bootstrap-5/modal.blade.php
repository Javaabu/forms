<div class="modal" tabindex="-1" id="{{ $attributes->get('id') ?: $id() }}">
    <div class="modal-dialog {{ $modalSizeClass ?? 'modal-lg' }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ $title ?? '' }}
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                {{ $slot }}
            </div>

            <div class="modal-footer">
                {{ $footer ?? '' }}
            </div>
        </div>
    </div>
</div>
