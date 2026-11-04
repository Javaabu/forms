<?php

namespace Javaabu\Forms\Views\Components;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\View\Component as BaseComponent;
use Javaabu\Forms\Frameworks\Framework;
use Javaabu\Forms\Frameworks\Frameworks;

abstract class Component extends BaseComponent
{
    /**
     * ID for this component.
     *
     * @var string
     */
    protected $id;

    /**
     * Framework used for this component
     */
    public string $framework;

    /**
     * The view to be used
     */
    protected string $view;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $framework = '')
    {
        if (! $framework) {
            $framework = config('forms.framework');
        }

        $this->framework = $framework;
    }

    /**
     * Resolves a logical icon (date, clear, upload, ...) from the forms.icons config.
     */
    public function getFrameworkIcon(string $icon): string
    {
        return $this->frameworkConfig("icons.{$icon}")
            ?? config("forms.icons.{$icon}")
            ?? $icon;
    }

    /**
     * The framework's class map (button colours, badges, alerts).
     */
    public function frameworkClasses(): Framework
    {
        return Frameworks::get($this->framework);
    }

    public function frameworkConfig(string $config, mixed $default = null): mixed
    {
        return config("forms.frameworks.{$this->framework}.{$config}", $default);
    }

    public function getView(): string
    {
        return 'forms::{framework}.' . $this->view;
    }

    /**
     * The framework's own view, or the shared one in forms::common when the framework has none.
     */
    public function render()
    {
        $view = str_replace('{framework}', $this->framework, $this->getView());

        if (View::exists($view)) {
            return $view;
        }

        $common = str_replace('{framework}', 'common', $this->getView());

        return View::exists($common) ? $common : $view;
    }

    /**
     * Generates an ID, once, for this component.
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
     */
    protected function generateIdByName(): string
    {
        return str_replace(['[', ']'], ['-', ''], Str::before($this->name, '[]'));
    }

    /**
     * Generates an ID by the name attribute.
     */
    public function stringToId($text): string
    {
        return str_replace(['[', ']'], ['-', ''], Str::before($text, '[]'));
    }

    /**
     * Generates a label, once, for this component.
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
     */
    protected function generateLabelByName(): string
    {
        return trans(Str::of(str_replace(['[', ']'], ['_', ''], Str::before($this->name, '[]')))
            ->camel()
            ->snake()
            ->replace('_', ' ')
            ->title()
            ->toString());
    }

    /**
     * Converts a bracket-notation to a dotted-notation
     */
    protected static function convertBracketsToDots(string $name): string
    {
        return str_replace(['[', ']'], ['.', ''], $name);
    }
}
