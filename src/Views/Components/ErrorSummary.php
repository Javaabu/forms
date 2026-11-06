<?php

namespace Javaabu\Forms\Views\Components;

use Illuminate\Support\Str;
use Javaabu\Forms\Support\HandlesValidationErrors;

class ErrorSummary extends Component
{
    use HandlesValidationErrors;

    protected string $view = 'error-summary';

    /**
     * Lists every validation error in the bag, each linking to its field.
     *
     * @param  array<string, string>  $labels  Field labels by name, e.g. ['email' => 'Email']
     */
    public function __construct(
        public string $title = '',
        public string $bag = 'default',
        public array $labels = [],
        string $framework = '',
    ) {
        parent::__construct($framework);
    }

    /**
     * @return array<int, array{name: string, id: string, label: string, messages: array<int, string>}>
     */
    public function items(): array
    {
        $items = [];

        foreach ($this->getErrorBag($this->bag)->messages() as $name => $messages) {
            $items[] = [
                'name' => $name,
                'id' => $this->idForErrorKey($name),
                'label' => $this->labels[$name] ?? '',
                'messages' => $messages,
            ];
        }

        return $items;
    }

    public function heading(): string
    {
        return $this->title ?: trans('forms::strings.error_summary_title');
    }

    /**
     * The id javaabu/forms generates for the field an error key belongs to: address.city → address-city.
     */
    protected function idForErrorKey(string $key): string
    {
        return Str::of($key)->replaceMatches('/\.\d+$/', '')->replace('.', '-')->toString();
    }
}
