<?php

namespace Javaabu\Forms\Views\Components;

class Date extends Input
{
    public string $icon;
    public string $iconWrapperClass;
    public string $clearIcon;
    public string $clearBtnClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        string $label = '',
        string $type = 'date',
        $model = null,
        $default = null,
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
        string $framework = ''
    ) {
        parent::__construct(
            $name,
            label: $label,
            type: $type,
            model: $model,
            default: $default,
            showErrors: $showErrors,
            showLabel: $showLabel,
            placeholder: $placeholder,
            showPlaceholder: $showPlaceholder,
            required: $required,
            inline: $inline,
            floating: $floating,
            inlineLabelClass: $inlineLabelClass,
            inlineInputClass: $inlineInputClass,
            framework: $framework,
        );

        $this->icon = $icon ?: $this->getFrameworkIcon($this->frameworkConfig('date-icon'));
        $this->icon = $icon ?: $this->getFrameworkIcon($this->frameworkConfig('date-icon'));
        $this->iconWrapperClass = $iconWrapperClass ?: $this->frameworkConfig('date-icon-wrapper-class');
        $this->clearBtnClass = $clearBtnClass ?: $this->frameworkConfig('date-clear-btn-class');
    }

    public function datePickerClass(): string
    {
        return 'date-picker';
    }

    public function isDateInput(): bool
    {
        return true;
    }
}
