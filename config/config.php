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

    'framework' => env('FORMS_FRAMEWORK', 'onu'),

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
        'max_upload_file_size' => null, // 10240 KB, when javaabu/settings isn't installed
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
            // Onu lays out inline fields with container queries and --onu-label-width;
            // these classes are added on top.
            'inline_label_class' => '',
            'inline_input_class' => '',
            'inline_entry_label_class' => '',
            'inline_entry_class' => '',
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
    | Assets
    |--------------------------------------------------------------------------
    |
    | Components load the JS and CSS they need through javaabu/manifest: on
    | their own (injected into the page), or where you put @manifestScripts
    | and @manifestStyles. Turn "styles" off when your app's own Tailwind
    | build imports resources/css/onu.css, so Onu's CSS isn't loaded twice.
    |
    */

    'assets' => [
        'enabled' => env('FORMS_ASSETS', true),
        'styles' => env('FORMS_STYLES', true),
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
    | WYSIWYG
    |--------------------------------------------------------------------------
    |
    | Wysiwyg textareas use TinyMCE, which your app hosts (it isn't bundled).
    | Defaults to asset('vendors/tinymce/tinymce.min.js').
    |
    */

    'wysiwyg' => [
        'tinymce_url' => env('TINYMCE_URL'),
    ],

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
