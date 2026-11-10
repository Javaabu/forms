<?php

namespace Javaabu\Forms\Views\Components;

class ButtonGroup extends Component
{
    protected string $view = 'button-group';

    public bool $inline;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        ?bool $inline = true,
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->inline = $inline;
    }
}
