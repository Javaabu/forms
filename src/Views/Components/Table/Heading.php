<?php

namespace Javaabu\Forms\Views\Components\Table;

use Illuminate\Support\Facades\Request;
use Javaabu\Forms\Views\Components\Component;

class Heading extends Component
{
    protected string $view = 'table.heading';

    public int $colspan;

    public string $sortable;

    public string $label;

    public string $name;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $label = '',
        int $colspan = 1,
        string $sortable = '',
        string $name = '',
        string $framework = '',
    ) {
        parent::__construct($framework);
        $this->label = $label;
        $this->colspan = $colspan;
        $this->name = $name;
        $this->sortable = $sortable ?: $name;
    }

    /**
     * Adds sorting class
     */
    public function addSortClass(string $classes = ''): string
    {
        $sorting_class = 'sorting';
        if (Request::get('orderby') == $this->sortable) {
            $sorting_class .= '_' . strtolower(Request::get('order', 'ASC'));
        }

        if ($classes) {
            $sorting_class .= ' ' . $classes;
        }

        return $sorting_class;
    }

    /**
     * The logical icon (forms.icons) for the current sort state of this column.
     */
    public function sortIcon(): string
    {
        if (Request::get('orderby') != $this->sortable) {
            return 'sort';
        }

        return strtolower(Request::get('order', 'ASC')) === 'desc' ? 'sort_desc' : 'sort_asc';
    }
}
