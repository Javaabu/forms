<?php

namespace Javaabu\Forms\Views\Components;

class Label extends Component
{
    protected string $view = 'label';

    public string $label;
    public bool $required;
    public bool $inline;
    public bool $floating;
    public string $inlineLabelClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $label = '',
        bool $required = false,
        bool $inline = false,
        bool $floating = false,
        string $inlineLabelClass = '',
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->label = $label;

        $this->required = $required;

        $this->inline = $inline;

        $this->floating = $floating;

        $this->inlineLabelClass = $inlineLabelClass ?: $this->frameworkConfig('inline-label-class');
    }
}
