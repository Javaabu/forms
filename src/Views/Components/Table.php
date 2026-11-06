<?php

namespace Javaabu\Forms\Views\Components;

class Table extends Component
{
    protected string $view = 'table';

    public bool $striped;

    public bool $no_bulk;

    public string $model;

    public string $table_class;

    public ?string $filter_id;

    public bool $no_pagination;

    public bool $noCheckbox;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $framework = '',
        bool $striped = false,
        bool $noBulk = false,
        string $model = '',
        string $tableClass = '',
        ?string $filterId = null,
        bool $noPagination = false,
        bool $noCheckbox = false,
    ) {
        parent::__construct($framework);
        $this->striped = $striped;
        $this->no_bulk = $noBulk;
        $this->model = $model;
        $this->table_class = $tableClass;
        $this->filter_id = $filterId;
        $this->no_pagination = $noPagination;
        $this->noCheckbox = $noCheckbox;
    }
}
