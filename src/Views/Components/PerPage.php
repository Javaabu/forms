<?php

namespace Javaabu\Forms\Views\Components;

class PerPage extends Component
{
    protected string $view = 'per-page';

    public array $amounts;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        array  $amounts = [10 => 10, 20 => 20, 50 => 50, 100 => 100, 500 => 500],
        string $framework = '',
    )
    {
        $this->amounts = $amounts;
        parent::__construct($framework);
    }

}
