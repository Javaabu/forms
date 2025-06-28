<?php

namespace Javaabu\Forms\Views\Components;

class Hidden extends Input
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        string $label = '',
        $model = null,
        $default = null,
        bool $showErrors = true,
        bool $showLabel = true,
        bool $required = false,
        bool $inline = false,
        bool $floating = false,
        bool $showJsErrors = false,
        string $framework = ''
    ) {
        parent::__construct(
            $name,
            label: $label,
            type: 'hidden',
            model: $model,
            default: $default,
            showErrors: $showErrors,
            showLabel: $showLabel,
            required:$required,
            inline: $inline,
            floating: $floating,
            showJsErrors: $showJsErrors,
            framework: $framework
        );
    }
}
