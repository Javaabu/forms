<?php

namespace Javaabu\Forms\Views\Components;

class Datetime extends Date
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
        string $dateFormat = '',
        string $icon = '',
        string $clearIcon = '',
        string $clearBtnClass = '',
        string $iconWrapperClass = '',
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
            type: 'datetime',
            model: $model,
            default: $default,
            dateFormat: $dateFormat,
            icon: $icon,
            clearIcon: $clearIcon,
            clearBtnClass: $clearBtnClass,
            iconWrapperClass: $iconWrapperClass,
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

        if (! $icon) {
            $this->icon = $this->getFrameworkIcon($this->frameworkConfig('datetime-icon'));
        }
    }

    public function datePickerClass(): string
    {
        return 'datetime-picker';
    }
}
