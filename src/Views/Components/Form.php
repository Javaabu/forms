<?php

namespace Javaabu\Forms\Views\Components;

use Javaabu\Forms\Support\HandlesBoundValues;

class Form extends Component
{
    use HandlesBoundValues;

    protected string $view = 'form';

    /**
     * Request method.
     */
    public string $method;

    /**
     * Form method spoofing to support PUT, PATCH and DELETE actions.
     * https://laravel.com/docs/master/routing#form-method-spoofing
     */
    public bool $spoofMethod = false;

    /**
     * Whether the form should have files.
     */
    public bool $files = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $method = 'POST',
        $model = null,
        bool $files = false,
        public bool $summary = false,
        public string $summaryTitle = '',
        public bool $focusOnError = true,
        public string $errorBag = 'default',
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->bindModel($model);

        $this->method = strtoupper($method);

        $this->spoofMethod = in_array($this->method, ['PUT', 'PATCH', 'DELETE']);

        $this->files = $files;
    }
}
