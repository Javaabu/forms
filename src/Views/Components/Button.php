<?php

namespace Javaabu\Forms\Views\Components;

class Button extends Component
{
    protected string $view = 'button';

    public string $type;

    public string $color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $type = '',
        string $color = 'primary',
        public bool $animate = false,
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->type = $type;
        $this->color = $color;
    }
}
