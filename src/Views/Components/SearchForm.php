<?php

namespace Javaabu\Forms\Views\Components;

class SearchForm extends Form
{
    protected string $view = 'search-form';

    public string $icon;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $name = 'search',
        public string $action = '',
        public string $route = '',
        public array $params = [],
        public string $placeholder = '',
        string $icon = '',
        string $method = 'GET',
        $model = null,
        bool $files = false,
        string $framework = ''
    ) {
        if (! $model) {
            $model = request()->query();
        }

        parent::__construct($method, $model, $files, $framework);

        $this->icon = $icon ?: $this->getFrameworkIcon($this->frameworkConfig('search-icon'));
    }
}
