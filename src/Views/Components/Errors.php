<?php

namespace Javaabu\Forms\Views\Components;

use Illuminate\Support\Str;

class Errors extends Component
{
    protected string $view = 'errors';

    public string $name;

    public string $bag;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name = '',
        string $bag = 'default',
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->name = static::convertBracketsToDots(Str::before($name, '[]'));

        $this->bag = $bag;
    }
}
