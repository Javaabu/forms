<?php

namespace Javaabu\Forms\Views\Components;

use Illuminate\Contracts\Pagination\Paginator;

class Pagination extends Component
{
    protected string $view = 'pagination-links';

    /**
     * Renders a Laravel paginator with the framework's pagination view.
     */
    public function __construct(
        public Paginator $paginator,
        string $framework = '',
    ) {
        parent::__construct($framework);
    }

    public function paginationView(): string
    {
        return "forms::{$this->framework}.pagination";
    }
}
