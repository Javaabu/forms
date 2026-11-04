<?php

namespace Javaabu\Forms\Views\Components;

class PerPage extends Component
{
    protected string $view = 'per-page';

    public array $amounts;

    public string $name = 'per_page';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        array $amounts = [10 => 10, 20 => 20, 50 => 50, 100 => 100, 500 => 500],
        public string $label = '',
        public bool $showLabel = false,
        public int|string|null $perPage = null,
        string $framework = '',
    ) {
        $this->amounts = $amounts;
        parent::__construct($framework);
    }

    public function label(): string
    {
        return $this->label ?: trans('forms::strings.per_page');
    }
}
