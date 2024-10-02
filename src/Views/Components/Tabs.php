<?php

namespace Javaabu\Forms\Views\Components;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Tabs extends Component
{
    protected string $view = 'tabs';

    public Collection $tabs;
    public string $active;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        array|Collection $accordion = [],
        string           $active = '',
        string           $framework = ''
    ) {
        parent::__construct($framework);

        $this->tabs = is_array($accordion) ? collect($accordion) : $accordion;

        if (! $active) {
            $active = $this->tabs->first()['name'] ?? '';
        }

        $this->active = $active;
    }

    public function isActive(string $name): bool
    {
        return $this->active && $this->active == $name;
    }

    public function generateSlotByName(string $name): string
    {
        return Str::of($name)
            ->camel()
            ->snake()
            ->replace('_', ' ')
            ->camel()
            ->toString();
    }

    public function generateTitleByName(string $name): string
    {
        return trans(Str::of($name)
            ->camel()
            ->snake()
            ->replace('_', ' ')
            ->title()
            ->toString());
    }
}
