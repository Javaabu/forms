<?php

namespace Javaabu\Forms\Views\Components\Accordion;

use Javaabu\Forms\Views\Components\Component;

class Collapse extends Component
{
    protected string $view = 'accordion.collapse';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $parent,
        public bool $show = false,
        string $framework = ''
    ) {
        parent::__construct($framework);
    }
}
