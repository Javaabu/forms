<div
    {{ $attributes }}

    @if(! $enableCheckbox)
    data-enable-elem="{{ $enableElem }}"
    data-enable-section-value="{{ $jsonEncode ? json_encode($enableValue) : $enableValue }}"
    @else
    data-enable-section-checkbox="{{ $enableElem }}"
    @endif

    @if($hideFields)
    data-hide-fields="true"
    @endif

    @if($disable)
    data-disable="true"
    @endif
>
    {{ $slot }}
</div>
