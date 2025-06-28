<?php

namespace Javaabu\Forms\Views\Components;

use Illuminate\Support\Str;

class JsErrors extends Component
{
    protected string $view = 'js-errors';
    public string $name;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name = '',
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->name = Str::slug(static::convertBracketsToDots(Str::before($name, '[]')));
    }
}
