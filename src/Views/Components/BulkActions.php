<?php

namespace Javaabu\Forms\Views\Components;

use Javaabu\Forms\Support\HandlesValidationErrors;

class BulkActions extends Component
{
    use HandlesValidationErrors;

    protected string $view = 'bulk-actions';

    public string $model;

    public array $actions;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $model,
        array $actions,
        string $framework = '',
    ) {
        parent::__construct($framework);

        $this->model = $model;
        $this->actions = $actions;
    }
}
