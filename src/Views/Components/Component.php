<?php

namespace Javaabu\Forms\Views\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\Component as BaseComponent;

abstract class Component extends BaseComponent
{
    /**
     * ID for this component.
     *
     * @var string
     */
    private $id;

    /**
     * Framework used for this component
     *
     * @var string
     */
    public string $framework;

    /**
     * The view to be used
     *
     * @var string
     */
    protected string $view;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $framework = '')
    {
        if (!$framework) {
            $framework = config('forms.framework');
        }

        $this->framework = $framework;
    }

    public function getView(): string
    {
        return 'forms::{framework}.' . $this->view;
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $view = $this->getView();

        $framework = $this->framework;

        return str_replace('{framework}', $framework, $view);
    }

    /**
     * Generates an ID, once, for this component.
     *
     * @return string
     */
    public function id(): string
    {
        if ($this->id) {
            return $this->id;
        }

        if (property_exists($this, 'name') && $this->name) {
            return $this->id = $this->generateIdByName();
        }

        return $this->id = Str::random(4);
    }

    /**
     * Generates an ID by the name attribute.
     *
     * @return string
     */
    protected function generateIdByName(): string
    {
        return str_replace(['[', ']'], ['-', ''], Str::before($this->name, '[]'));
    }

    /**
     * Generates a label, once, for this component.
     *
     * @return string
     */
    public function label(): string
    {
        if ($this->label) {
            return $this->label;
        }

        return $this->label = $this->generateLabelByName();
    }

    /**
     * Generates a label by the name attribute.
     *
     * @return string
     */
    protected function generateLabelByName(): string
    {
        return Str::of(str_replace(['[', ']'], ['_', ''], Str::before($this->name, '[]')))
                    ->camel()
                    ->snake()
                    ->replace('_', ' ')
                    ->title()
                    ->toString();
    }

    /**
     * Converts a bracket-notation to a dotted-notation
     *
     * @param  string  $name
     * @return string
     */
    protected static function convertBracketsToDots(string $name): string
    {
        return str_replace(['[', ']'], ['.', ''], $name);
    }
}
