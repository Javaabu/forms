<?php

namespace Javaabu\Forms\Views\Components\Table;

use Javaabu\Forms\Views\Components\Component;

class EmptyRow extends Component
{
    protected string $view = 'table.empty-row';

    public int $columns;

    public bool $noCheckbox;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        int $columns = 1,
        bool $noCheckbox = false,
        string $framework = '',
    ) {
        parent::__construct($framework);
        $this->columns = $columns;
        $this->noCheckbox = $noCheckbox;
    }
}
