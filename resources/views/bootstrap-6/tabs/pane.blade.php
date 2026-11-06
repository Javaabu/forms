<div {!! $attributes->class([
        'tab-pane',
        'active' => $active,
        'show' => $active
    ]) !!}
    id="{{ $id() }}"
    role="tabpanel"
    aria-labelledby="{{ $labelledBy() }}"
    tabindex="0"
>{{ $slot }}</div>
