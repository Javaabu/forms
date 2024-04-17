<?php

namespace Javaabu\Forms\Views\Components;

class Card extends Component
{
    protected string $view = 'card';

    public string $title;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $title = '',
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->title = $title;
    }
}
