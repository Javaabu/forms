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
        string $placeholder = '',
        bool   $showPlaceholder = false,
        bool $required = false,
        bool $inline = false,
        bool $floating = false,
        string $inlineLabelClass = '',
        string $inlineInputClass = '',
        bool $showJsErrors = false,
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
            placeholder: $placeholder,
            showPlaceholder: $showPlaceholder,
            required:$required,
            inline: $inline,
            floating: $floating,
            inlineLabelClass: $inlineLabelClass,
            inlineInputClass: $inlineInputClass,
            showJsErrors: $showJsErrors,
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
