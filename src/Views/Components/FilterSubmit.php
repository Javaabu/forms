<?php

namespace Javaabu\Forms\Views\Components;

class FilterSubmit extends Component
{
    protected string $view = 'filter-submit';

    public string $cancelUrl;

    public bool|array $export;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $cancelUrl,
        bool|array|string $export = false,
        string $framework = '',
    ) {
        parent::__construct($framework);

        $this->export = is_string($export) ? [$export] : $export;
        $this->cancelUrl = $cancelUrl;
    }
}
