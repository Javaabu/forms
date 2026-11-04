<?php

namespace Javaabu\Forms\Views\Components;

use Illuminate\Support\Str;
use Javaabu\Forms\Support\HandlesValidationErrors;

class Errors extends Component
{
    use HandlesValidationErrors;

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
        public bool $firstOnly = true,
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->name = static::convertBracketsToDots(Str::before($name, '[]'));

        $this->bag = $bag;
    }

    /**
     * The messages to show: the first, like @error, or all of them when first-only is false.
     *
     * @return array<int, string>
     */
    public function messages(): array
    {
        $errors = $this->getErrorBag($this->bag);

        $messages = $errors->get($this->name) ?: $errors->get($this->name . '.*');

        $messages = collect($messages)->flatten()->all();

        return $this->firstOnly ? array_slice($messages, 0, 1) : $messages;
    }
}
