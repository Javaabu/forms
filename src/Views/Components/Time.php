<?php

namespace Javaabu\Forms\Views\Components;

class Time extends Date
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
        string $icon = '',
        string $clearIcon = '',
        string $clearBtnClass = '',
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
            type: 'time',
            model: $model,
            default: $default,
            icon: $icon,
            clearIcon: $clearIcon,
            clearBtnClass: $clearBtnClass,
            showErrors: $showErrors,
            showLabel: $showLabel,
            required:$required,
            inline: $inline,
            floating: $floating,
            framework: $framework
        );

        if (! $icon) {
            $this->icon = $this->getFrameworkIcon($this->frameworkConfig('time-icon'));
        }
    }

    public function datePickerClass(): string
    {
        return 'time-picker';
    }
}
