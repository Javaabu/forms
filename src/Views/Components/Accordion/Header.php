<?php

namespace Javaabu\Forms\Views\Components\Accordion;

use Javaabu\Forms\Views\Components\Component;

class Header extends Component
{
    protected string $view = 'accordion.header';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $target,
        public string $title = '',
        public bool $show = false,
        string $framework = ''
    ) {
        parent::__construct($framework);
    }
}
