<?php

namespace Javaabu\Forms\Views\Components;

class Alert extends Component
{
    protected string $view = 'alert';

    public string $type;
    public string $icon;
    public bool $dismissible;

    public string $heading;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $type = 'primary',
        bool   $dismissible = false,
        string $icon = null,
        string $heading = '',
        string $framework = ''
    )
    {
        parent::__construct($framework);

        $this->type = $type;
        $this->dismissible = $dismissible;
        $this->icon = $icon;
        $this->heading = $heading;
    }
}
