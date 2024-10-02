<?php

namespace Javaabu\Forms\Views\Components;

use Illuminate\Support\Collection;

class NavTabs extends Component
{
    protected string $view = 'nav-tabs';

    public array|Collection $tabs;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        array|Collection $accordion = [],
        string           $framework = ''
    ) {
        parent::__construct($framework);

        $this->tabs = $accordion;
    }
}
