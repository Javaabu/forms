<?php

namespace Javaabu\Forms\Views\Components;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Accordion extends Component
{
    protected string $view = 'accordion';

    public Collection $items;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string    $id,
        array|Collection $items = [],
        string           $framework = ''
    ) {
        parent::__construct($framework);

        $this->id = $id;
        $this->items = is_array($items) ? collect($items) : $items;
    }

    public function generateSlotByName(string $name): string
    {
        if (is_numeric($name)) {
            return 'item' . $name;
        }

        return Str::of($name)
            ->camel()
            ->snake()
            ->replace('_', ' ')
            ->camel()
            ->toString();
    }

    public function generateCollapseIdByName(string $name): string
    {
        if (is_numeric($name)) {
            return $this->id . '-item-' . $name . '-collapse';
        }

        return Str::of($name)
            ->replace(' ', '-')
            ->toString();
    }
}
