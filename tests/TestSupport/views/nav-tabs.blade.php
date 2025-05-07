@php
$items = [
    [
        'title'    => __('Active Tab'),
        'url'      => 'https://active-tab.test',
        'active'   => true,
        'disabled' => false,
    ],
    [
        'title'    => __('Inactive Tab'),
        'url'      => 'https://inactive-tab.test',
        'active'   => false,
        'disabled' => false,
    ],
    [
        'title'    => __('Disabled Tab'),
        'url'      => 'https://disabled-tab.test',
        'active'   => false,
        'disabled' => true,
    ],
    [
        'title'    => __('Icon Tab'),
        'url'      => 'https://active-tab.test',
        'icon'     => 'zmdi zmdi-shield-security',
        'active'   => false,
        'disabled' => false,
    ],
];
@endphp

<x-forms::nav-tabs :tabs="$items" />
