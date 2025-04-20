@props(['title' => ''])

<div {{ $attributes->merge(['class' => 'modal fade', 'tabindex' => -1]) }}>
    <div class="modal-dialog {{ $modalSizeClass ?? 'modal-lg' }}">
        <div class="modal-content modal-headed">
            @if($title)
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                </div>
            @endif

            <div class="modal-body">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="modal-footer px-4 pb-4">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
