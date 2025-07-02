<?php

namespace Javaabu\Forms\Views\Components;

use Javaabu\Forms\Support\FormatsValues;
use Javaabu\Forms\Support\HandlesBoundValues;

class ConditionalLink extends Component
{
    use HandlesBoundValues;
    use FormatsValues;

    protected string $view = 'conditional-link';
    public bool $multiline;
    public bool $showLink;
    public string $name;
    public string $url;
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $url,
        string $name = '',
        ?bool $showLink = null,
        string $can = '',
        $arg = [],
        ?string $guard = null,
        $value = null,
        $model = null,
        bool $multiline = false,
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->url = $url;
        $this->showLink = is_null($showLink) && $can ? auth()->guard($guard)->user()->can($can, $arg) : (bool) $showLink;
        $this->name = $name;
        $this->multiline = $multiline;
        $this->value = $value ?: ($name ? $this->getBoundValue($model, $name) : '');
    }
}
