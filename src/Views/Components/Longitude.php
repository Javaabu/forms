<?php

namespace Javaabu\Forms\Views\Components;

use Illuminate\View\ComponentAttributeBag;

class Longitude extends Input
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
        string $framework = ''
    ) {
        parent::__construct(
            $name,
            label: $label,
            type: 'number',
            model: $model,
            default: $default,
            showErrors: $showErrors,
            showLabel: $showLabel,
            required:$required,
            inline: $inline,
            floating: $floating,
            framework: $framework
        );
    }

    public function getDefaultAttributes(): array
    {
        return [
            'step' => '0.000001',
            'min' => -180,
            'max' => 180
        ];
    }
}
