<?php

namespace Javaabu\Forms\Views\Components\Table;

use Javaabu\Forms\Support\FormatsValues;
use Javaabu\Forms\Support\HandlesBoundValues;
use Javaabu\Forms\Views\Components\Component;

class Cell extends Component
{
    use HandlesBoundValues;
    use FormatsValues;

    protected string $view = 'table.cell';
    public bool $multiline;
    public bool $showLabel;
    public string $label;
    public string $name;
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name = '',
        string $label = '',
        bool $showLabel = true,
        $value = null,
        $model = null,
        bool $multiline = false,
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->label = $label;
        $this->showLabel = $showLabel;
        $this->name = $name;
        $this->multiline = $multiline;
        $this->value = ! is_null($value) ? $value : ($name ? $this->getBoundValue($model, $name) : '');
    }
}
