<?php

namespace Javaabu\Forms\Views\Components\Accordion;

use Javaabu\Forms\Views\Components\Component;

class Item extends Component
{
    protected string $view = 'accordion.item';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $name,
        public string $parent,
        public string $title = '',
        public bool $show = false,
        string $framework = ''
    ) {
        parent::__construct($framework);
    }
}
