<?php

namespace Javaabu\Forms\Views\Components;

class NoItems extends Component
{
    protected string $view = 'no-items';

    public null|string|object $model;
    public string $createAction;
    public ?string $modelType = null;
    public string $icon;
    public bool $showCreate;
    public string $title;
    public string $message;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string             $createAction = '#',
        null|string|object $model = null,
        string             $icon = '',
        ?string            $modelType = null,
        ?bool              $showCreate = null,
        ?string            $title = null,
        ?string            $message = null,
        string             $framework = '',
    )
    {
        parent::__construct($framework);

        $this->model = $model;
        $this->createAction = $createAction;
        $this->modelType = $modelType;

        $this->icon = $icon ?: $this->getFrameworkIcon($this->frameworkConfig('no-items-icon'));
        $this->showCreate = is_null($showCreate)
            ? ($this->model && auth()->user() ? auth()->user()->can('create', $this->model) : false)
            : $showCreate;

        $this->title = is_null($title)
            ? __('It\'s a bit lonely here.')
            : $title;
        $this->message = is_null($message)
            ? __('Let\'s create some new :model_type.', ['model_type' => $this->modelType ?? __('items')])
            : $message;
    }
}
