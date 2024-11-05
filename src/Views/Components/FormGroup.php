<?php

namespace Javaabu\Forms\Views\Components;

class FormGroup extends Component
{
    protected string $view = 'form-group';
    public string $name;
    public string $label;
    public bool $required;
    public bool $inline;
    public bool $floating;
    public bool $wrap;
    public bool $showLabel;
    public string $inlineInputClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name = '',
        string $label = '',
        bool   $required = false,
        bool   $inline = false,
        bool   $floating = false,
        bool   $wrap = true,
        bool   $showLabel = true,
        public string $inlineLabelClass = '',
        string $inlineInputClass = '',
        public bool $blankLabel = false,
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->name = $name;
        $this->label = $label;
        $this->required = $required;
        $this->inline = $inline;
        $this->floating = $floating;
        $this->wrap = $wrap;
        $this->showLabel = $showLabel;

        $this->inlineInputClass = $inlineInputClass ?: $this->frameworkConfig('inline-input-class');
    }

    public function label(): string
    {
        if ($this->blankLabel) {
            return '';
        }

        return parent::label();
    }
}
