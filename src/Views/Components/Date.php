<?php

namespace Javaabu\Forms\Views\Components;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Javaabu\Forms\Assets\Assets;

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
        public string $dateFormat = '',
        string $icon = '',
        string $clearIcon = '',
        string $clearBtnClass = '',
        string $iconWrapperClass = '',
        bool $showErrors = true,
        bool $showLabel = true,
        string $placeholder = '',
        bool $showPlaceholder = false,
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
            showJsErrors: $showJsErrors,
            framework: $framework,
        );

        $this->icon = $icon ?: $this->getFrameworkIcon('date');
        $this->clearIcon = $clearIcon ?: $this->getFrameworkIcon('clear');
        $this->clearBtnClass = $clearBtnClass ?: $this->frameworkConfig('date_clear_btn_class', '');
        $this->iconWrapperClass = $iconWrapperClass ?: $this->frameworkConfig('date_icon_wrapper_class', '');
    }

    public function datePickerClass(): string
    {
        return 'date-picker';
    }

    public function isDateInput(): bool
    {
        return true;
    }

    /**
     * The format bound dates are shown in when date-format isn't given: the format the picker uses.
     */
    public function defaultDateFormat(): string
    {
        return 'Y-m-d';
    }

    protected function formatDateTime(Model $model, string $key, DateTimeInterface $date)
    {
        if ($this->dateFormat) {
            return $date->format($this->dateFormat);
        }

        if (config('forms.use_eloquent_date_casting')) {
            return parent::formatDateTime($model, $key, $date);
        }

        return $date->format($this->defaultDateFormat());
    }

    /** @return array<int, string> */
    public function assets(): array
    {
        return [Assets::CORE, Assets::DATES];
    }
}
