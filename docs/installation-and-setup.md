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

    'use_eloquent_date_casting' => false,

    /*
    |--------------------------------------------------------------------------
    | Framework Settings
    |--------------------------------------------------------------------------
    |
    | Framework specific configs
    |
    */

    'frameworks' => [
        'bootstrap-5' => [
            'icon-prefix' => 'fa',
            'date-icon' => 'fa-calendar',
            'datetime-icon' => 'fa-calendar',
            'time-icon' => 'fa-clock',
            'date-clear-icon' => 'fa-close',
            'date-clear-btn-class' => 'btn btn-outline-secondary btn-date-clear disable-w-input',
            'file-download-icon' => 'fa-arrow-to-bottom',
            'file-upload-icon' => 'fa-arrow-to-top',
            'file-clear-icon' => 'fa-close',
            'image-icon' => 'fa-image',
        ],

        'material-admin-26' => [
            'icon-prefix' => 'zmdi',
            'date-icon' => 'zmdi-calendar',
            'datetime-icon' => 'zmdi-calendar',
            'time-icon' => 'zmdi-clock',
            'date-clear-icon' => 'zmdi-close',
            'date-clear-btn-class' => 'text-body btn-date-clear disable-w-input',
            'file-download-icon' => 'zmdi-open-in-new',
            'file-upload-icon' => 'zmdi-upload',
            'file-clear-icon' => 'zmdi-close',
            'image-icon' => 'zmdi-image',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Scripts Stack
    |--------------------------------------------------------------------------
    |
    | The name of the stack to push scripts
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
