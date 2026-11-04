<?php

namespace Javaabu\Forms\Views\Components;

class LinkButton extends Component
{
    protected string $view = 'link-button';

    public string $url;

    public string $color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $url = '',
        string $color = 'primary',
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->url = $url;
        $this->color = $color;
    }
}
