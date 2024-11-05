<?php

namespace Javaabu\Forms\Views\Components;

class Wysiwyg extends Textarea
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        string $label = '',
        int $rows = 3,
        $model = null,
        $default = null,
        $value = null,
        bool $showErrors = true,
        bool $showLabel = true,
        string $placeholder = '',
        bool   $showPlaceholder = false,
        bool $required = false,
        bool $inline = false,
        bool $floating = false,
        string $inlineLabelClass = '',
        string $inlineInputClass = '',
        string $framework = ''
    ) {
        parent::__construct(
            name: $name,
            label: $label,
            rows: $rows,
            model: $model,
            default: $default,
            value: $value,
            showErrors: $showErrors,
            showLabel: $showLabel,
            placeholder: $placeholder,
            showPlaceholder: $showPlaceholder,
            wysiwyg: true,
            required: $required,
            inline: $inline,
            floating: $floating,
            inlineLabelClass: $inlineLabelClass,
            inlineInputClass: $inlineInputClass,
            framework: $framework,
        );
    }
}
