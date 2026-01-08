---
title: Installation & Setup
sidebar_position: 1.2
---

You can install the package via composer:

```bash
composer require javaabu/forms
```

# Publishing the config file

Publishing the config file is optional:

```bash
php artisan vendor:publish --provider="Javaabu\Forms\FormsServiceProvider" --tag="forms-config"
```

This is the default content of the config file:

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default CSS Framework
    |--------------------------------------------------------------------------
    |
    | This option controls the default CSS framework that will be used by the
    | package when rendering form components
    |
    | Supported: "bootstrap-5", "material-admin-26"
    |
    */

    'framework' => 'bootstrap-5',

    /*
    |--------------------------------------------------------------------------
    | Eloquent Date Casting
    |--------------------------------------------------------------------------
    |
    | If enabled, date inputs will automatically try to cast values from
    | Eloquent models to the appropriate format for the date picker.
    |
    */

    'use_eloquent_date_casting' => false,

    /*
    |--------------------------------------------------------------------------
    | Framework Settings
    |--------------------------------------------------------------------------
    |
    | Here you can customize the classes and icons used for each framework.
    | You can add your own framework here and reference it in the 'framework' key.
    |
    */

    'frameworks' => [
        'bootstrap-5' => [
            'icon-prefix' => 'fa', // FontAwesome prefix
            'date-icon' => 'fa-calendar',
            'datetime-icon' => 'fa-calendar',
            'time-icon' => 'fa-clock',
            'date-clear-icon' => 'fa-close',
            'date-clear-btn-class' => 'btn btn-outline-secondary btn-date-clear disable-w-input',
            'file-download-icon' => 'fa-arrow-to-bottom',
            'file-upload-icon' => 'fa-arrow-to-top',
            'file-clear-icon' => 'fa-close',
            'image-icon' => 'fa-image',
            // Classes for inline form layouts
            'inline-label-class' => 'col-sm-3 col-lg-2 col-form-label',
            'inline-input-class' => 'col-sm-9 col-lg-10',
            'inline-entry-label-class' => 'col-sm-6 col-md-4',
            'inline-entry-class' => 'col-sm-6 col-md-8',
        ],

        'material-admin-26' => [
            'icon-prefix' => 'zmdi', // Material Design Iconic Font
            'date-icon' => 'zmdi-calendar',
            'datetime-icon' => 'zmdi-calendar',
            'time-icon' => 'zmdi-clock',
            'date-clear-icon' => 'zmdi-close',
            'date-clear-btn-class' => 'text-body btn-date-clear disable-w-input',
            'file-download-icon' => 'zmdi-open-in-new',
            'file-upload-icon' => 'zmdi-upload',
            'file-clear-icon' => 'zmdi-close',
            'image-icon' => 'zmdi-image',
            'inline-label-class' => 'col-sm-3 col-lg-2 col-form-label',
            'inline-input-class' => 'col-sm-9 col-lg-10',
            'inline-entry-label-class' => 'col-sm-6 col-md-4',
            'inline-entry-class' => 'col-sm-6 col-md-8',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Scripts Stack
    |--------------------------------------------------------------------------
    |
    | The name of the blade stack where scripts (like Google Maps or Select2 init)
    | should be pushed to. Make sure `@stack('scripts')` exists in your layout.
    |
    */

    'scripts_stack' => 'scripts',

    /*
    |--------------------------------------------------------------------------
    | Google Maps API Key
    |--------------------------------------------------------------------------
    |
    | Required if you use the <x-forms::map /> component.
    |
    */

    'map_api_key' => env('MAP_API_KEY'),
];

```

# Publishing the component views

If you want to override the generated markup for the form components, you can publish the components and modify them:

```php
php artisan vendor:publish --provider="Javaabu\Forms\FormsServiceProvider" --tag="forms-views"
```

The view files will be available in the `resources/views/vendor/forms` directory after you publish them.

# Publishing translations

If you want to override the required * in labels, you can publish the language files and modify them:

```php
php artisan vendor:publish --provider="Javaabu\Forms\FormsServiceProvider" --tag="forms-translations"
```

The language files will be available in the `lang/vendor/forms` directory after you publish them.
