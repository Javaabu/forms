<?php

use Javaabu\Forms\Components;

return [
    'prefix' => '',

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
    | Default Input Settings
    |--------------------------------------------------------------------------
    |
    | Controls the default settings for rendering form controls
    |
    */

    'inputs' => [
        'floating_labels' => false,

        'inline' => true,

        'show_errors' => true,

        'show_la'
    ],

    'components' => [
        /*
        'form' => [
            'view'  => 'forms::{framework}.form',
            'class' => Components\Form::class,
        ],

        'form-checkbox' => [
            'view'  => 'forms::{framework}.form-checkbox',
            'class' => Components\FormCheckbox::class,
        ],

        'form-errors' => [
            'view'  => 'forms::{framework}.form-errors',
            'class' => Components\FormErrors::class,
        ],

        'form-group' => [
            'view'  => 'forms::{framework}.form-group',
            'class' => Components\FormGroup::class,
        ],

        'form-input' => [
            'view'  => 'forms::{framework}.form-input',
            'class' => Components\FormInput::class,
        ],

        'form-input-group' => [
            'view'  => 'forms::{framework}.form-input-group',
            'class' => Components\FormInputGroup::class,
        ],

        'form-input-group-text' => [
            'view'  => 'forms::{framework}.form-input-group-text',
            'class' => Components\FormInputGroupText::class,
        ],

        'form-label' => [
            'view'  => 'forms::{framework}.form-label',
            'class' => Components\FormLabel::class,
        ],

        'form-radio' => [
            'view'  => 'forms::{framework}.form-radio',
            'class' => Components\FormRadio::class,
        ],

        'form-range' => [
            'view'  => 'forms::{framework}.form-range',
            'class' => Components\FormRange::class,
        ],

        'form-select' => [
            'view'  => 'forms::{framework}.form-select',
            'class' => Components\FormSelect::class,
        ],

        'form-submit' => [
            'view'  => 'forms::{framework}.form-submit',
            'class' => Components\FormSubmit::class,
        ],

        'form-textarea' => [
            'view'  => 'forms::{framework}.form-textarea',
            'class' => Components\FormTextarea::class,
        ],
        */
    ],
];
