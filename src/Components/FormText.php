<?php

namespace Javaabu\Forms\Components;

class FormText extends FormInput
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
        bool $required = false,
        ?bool $inline = null,
        bool $floating = false,
        string $framework = ''
    )
    {
        parent::__construct(
            $name,
            $label,
            'text',
            $model,
            $default,
            $showErrors,
            $required,
            $inline,
            $floating,
            $framework
        );
    }
}
