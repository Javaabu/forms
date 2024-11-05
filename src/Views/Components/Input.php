<?php

namespace Javaabu\Forms\Views\Components;

use Javaabu\Forms\Support\HandlesDefaultAndOldValue;
use Javaabu\Forms\Support\HandlesValidationErrors;

class Input extends Component
{
    use HandlesValidationErrors;
    use HandlesDefaultAndOldValue;

    protected string $view = 'input';
    public string $name;
    public string $label;
    public string $type;
    public string $placeholder;
    public bool $showPlaceholder;
    public bool $required;
    public bool $inline;
    public bool $floating;
    public bool $showLabel;
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        string $label = '',
        string $type = 'text',
        $model = null,
        $default = null,
        bool   $showErrors = true,
        bool   $showLabel = true,
        string $placeholder = '',
        bool   $showPlaceholder = false,
        bool   $required = false,
        bool   $inline = false,
        bool   $floating = false,
        public string $inlineLabelClass = '',
        public string $inlineInputClass = '',
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->showErrors = $showErrors;
        $this->showLabel = $showLabel;
        $this->floating = $floating;
        $this->required = $required;
        $this->inline = $inline;
        $this->showPlaceholder = $showPlaceholder;
        $this->placeholder = $placeholder ?: ($showPlaceholder ? ($label ?: $this->generateLabelByName()) : '');

        if ($type !== 'password') {
            $this->setValue($name, $model, $default);
        }
    }

    public function datePickerClass(): string
    {
        return '';
    }

    public function isDateInput(): bool
    {
        return false;
    }

    public function isFileInput(): bool
    {
        return false;
    }

    public function getDefaultAttributes(): array
    {
        return [];
    }
}
