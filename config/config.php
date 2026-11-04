<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default CSS Framework
    |--------------------------------------------------------------------------
    |
    | The framework the components render for. Any component can override it
    | with a framework="..." attribute.
    |
    | Supported: "onu", "bootstrap-6"
    |
    */

    'framework' => env('FORMS_FRAMEWORK', 'bootstrap-6'),

    /*
    |--------------------------------------------------------------------------
    | Eloquent date casting
    |--------------------------------------------------------------------------
    |
    | When true, date inputs format bound model dates with the model's own
    | date casts instead of the component's date format.
    |
    */

    'use_eloquent_date_casting' => false,

    /*
    |--------------------------------------------------------------------------
    | Defaults
    |--------------------------------------------------------------------------
    |
    | Defaults used when a component isn't given a value. Leave one null to
    | read it from javaabu/settings (get_setting()) when that is installed,
    | falling back to the value shown in the comment.
    |
    */

    'defaults' => [
        'per_page' => null, // 20
        'default_lat' => null, // 4.1755 (Malé)
        'default_lng' => null, // 73.5093 (Malé)
    ],

    /*
    |--------------------------------------------------------------------------
    | Icons
    |--------------------------------------------------------------------------
    |
    | The icon each component uses. A value is either the name of one of the
    | bundled Lucide icons (rendered as inline SVG, see resources/icons) or
    | CSS classes for an icon font, e.g. "fa-regular fa-calendar". A
    | framework can override these under frameworks.<name>.icons.
    |
    */

    'icons' => [
        'date' => 'calendar',
        'datetime' => 'calendar',
        'time' => 'clock',
        'clear' => 'x',
        'download' => 'download',
        'upload' => 'upload',
        'image' => 'image',
        'search' => 'search',
        'no_items' => 'file',
        'create' => 'plus',
        'sort' => 'arrow-up-down',
        'sort_asc' => 'arrow-up',
        'sort_desc' => 'arrow-down',
        'alert_success' => 'circle-check',
        'alert_danger' => 'circle-x',
        'alert_warning' => 'triangle-alert',
        'alert_info' => 'info',
    ],

    /*
    |--------------------------------------------------------------------------
    | Framework Settings
    |--------------------------------------------------------------------------
    |
    | Framework specific settings. Each framework can also have its own
    | "icons" array, merged over the icons above.
    |
    */

    'frameworks' => [
        'onu' => [
            'inline_label_class' => 'sm:w-1/4 lg:w-1/6 sm:shrink-0',
            'inline_input_class' => 'min-w-0 flex-1',
            'inline_entry_label_class' => 'sm:w-1/2 md:w-1/3 sm:shrink-0',
            'inline_entry_class' => 'min-w-0 flex-1',
            'date_icon_wrapper_class' => '',
            'date_clear_btn_class' => '',
        ],

        'bootstrap-6' => [
            'inline_label_class' => 'sm:col-3 lg:col-2 col-form-label',
            'inline_input_class' => 'sm:col-9 lg:col-10',
            'inline_entry_label_class' => 'sm:col-6 md:col-4',
            'inline_entry_class' => 'sm:col-6 md:col-8',
            'date_icon_wrapper_class' => '',
            'date_clear_btn_class' => '',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Scripts Stack
    |--------------------------------------------------------------------------
    |
    | The Blade stack the components push their scripts to when javaabu/manifest
    | isn't handling assets. Render it with @stack('scripts') in your layout.
    |
    */

    'scripts_stack' => 'scripts',

    /*
    |--------------------------------------------------------------------------
    | Google Maps API Key
    |--------------------------------------------------------------------------
    |
    | API key to use for map inputs
    |
    */

    'map_api_key' => env('MAP_API_KEY'),
];
