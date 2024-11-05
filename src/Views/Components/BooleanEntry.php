<?php

namespace Javaabu\Forms\Views\Components;

class BooleanEntry extends TextEntry
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name = '',
        string $label = '',
        $value = null,
        $model = null,
        bool $showLabel = true,
        bool $inline = false,
        string $inlineEntryLabelClass = '',
        string $inlineEntryClass = '',
        string $framework = ''
    ) {
        parent::__construct(
            $name,
            label: $label,
            value: $value,
            model: $model,
            showLabel: $showLabel,
            inline: $inline,
            multiline: false,
            inlineEntryLabelClass: $inlineEntryLabelClass,
            inlineEntryClass: $inlineEntryClass,
            framework: $framework
        );

        if (is_null($this->value)) {
            $this->value = trans('forms::strings.blank');
        } else {
            $this->value = $this->value ? trans('forms::strings.yes') : trans('forms::strings.no');
        }
    }
}
