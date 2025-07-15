<?php

namespace Javaabu\Forms\Views\Components;

use Javaabu\Forms\Support\FormatsValues;
use Javaabu\Forms\Support\HandlesBoundValues;

class TextEntry extends Component
{
    use HandlesBoundValues;
    use FormatsValues;

    protected string $view = 'text-entry';
    public bool $inline;
    public bool $multiline;
    public string $label;
    public string $name;
    public bool $showLabel;
    public $value;
    public string $inlineEntryLabelClass;
    public string $inlineEntryClass;

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
        bool $multiline = false,
        public bool $wysiwyg = false,
        string $inlineEntryLabelClass = '',
        string $inlineEntryClass = '',
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->label = $label;
        $this->showLabel = $showLabel;
        $this->inline = $inline;
        $this->name = $name;
        $this->multiline = $multiline;
        $this->value = ! is_null($value) ? $value : ($name ? $this->getBoundValue($model, $name) : '');

        $this->inlineEntryLabelClass = $inlineEntryLabelClass ?: $this->frameworkConfig('inline-entry-label-class');
        $this->inlineEntryClass = $inlineEntryClass ?: $this->frameworkConfig('inline-entry-class');
    }
}
