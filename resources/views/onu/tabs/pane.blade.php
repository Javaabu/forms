<div {!! $attributes->class([
        'tab-pane',
        $frameworkClasses()->classes('tabs.tabs-content'),
        'active' => $active,
        'hidden' => ! $active,
    ]) !!}
    id="{{ $id() }}"
    role="tabpanel"
    data-slot="tabs-content"
    data-state="{{ $active ? 'active' : 'inactive' }}"
    aria-labelledby="{{ $labelledBy() }}"
    tabindex="0"
>{{ $slot }}</div>
