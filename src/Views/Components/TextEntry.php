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
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->label = $label;
        $this->showLabel = $showLabel;
        $this->inline = $inline;
        $this->name = $name;
        $this->multiline = $multiline;
        $this->value = $value ?: ($name ? $this->getBoundValue($model, $name) : '');
    }
}
