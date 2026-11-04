<?php

namespace Javaabu\Forms\Views\Components;

use Javaabu\Forms\Support\HandlesBoundValues;

class FormOpen extends Form
{
    // TODO: Write test
    use HandlesBoundValues;

    protected string $view = 'form-open';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $method = 'POST',
        $model = null,
        bool $files = false,
        string $framework = ''
    ) {
        parent::__construct(
            $method,
            $model,
            $files,
            $framework,
        );
    }
}
