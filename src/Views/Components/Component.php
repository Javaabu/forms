<?php

namespace Javaabu\Forms\Views\Components;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\View\Component as BaseComponent;
use Javaabu\Forms\Assets\Assets;
use Javaabu\Forms\Frameworks\Framework;
use Javaabu\Forms\Frameworks\Frameworks;
use Javaabu\Manifest\Contracts\DeclaresAssets;

abstract class Component extends BaseComponent implements DeclaresAssets
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
     * Classes for the field's form group (wrapper). Read from the form-group-class attribute.
     */
    public string $formGroupClass = '';

    /**
     * Type Thaana from a Latin keyboard. Read from the thaana attribute.
     */
    public bool $thaana = false;

    /**
     * Grow a textarea with its content. Read from the auto-resize attribute.
     */
    public bool $autoResize = false;

    /**
     * Most decimals a number input keeps. Read from the decimals attribute.
     */
    public ?int $decimals = null;

    /**
     * Attributes every field accepts without a constructor parameter, mapped to their property.
     *
     * @var array<string, string>
     */
    protected array $field_options = [
        'form-group-class' => 'formGroupClass',
        'formGroupClass' => 'formGroupClass',
        'thaana' => 'thaana',
        'auto-resize' => 'autoResize',
        'autoResize' => 'autoResize',
        'decimals' => 'decimals',
    ];

    /**
     * Pulls the shared field options out of the attributes, so they reach the view as
     * properties instead of HTML attributes.
     */
    public function withAttributes(array $attributes)
    {
        foreach ($this->field_options as $attribute => $property) {
            if (! array_key_exists($attribute, $attributes)) {
                continue;
            }

            $this->setFieldOption($property, $attributes[$attribute]);

            unset($attributes[$attribute]);
        }

        return parent::withAttributes($attributes);
    }

    protected function setFieldOption(string $property, mixed $value): void
    {
        $this->{$property} = match ($property) {
            'thaana', 'autoResize' => filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) ?? (bool) $value,
            'decimals' => is_numeric($value) ? (int) $value : null,
            default => (string) $value,
        };
    }

    /*
     * The shared field options are read through methods in views: Blade captures a
     * component's properties before withAttributes() runs, but calls methods lazily.
     */

    public function groupClass(): string
    {
        return $this->formGroupClass;
    }

    public function shouldAutoResize(): bool
    {
        return $this->autoResize;
    }

    public function decimalPlaces(): ?int
    {
        return $this->decimals;
    }

    /**
     * HTML attributes for a Thaana field, as Onu's TextInput renders them.
     *
     * @return array<string, string>
     */
    public function thaanaAttributes(): array
    {
        if (! $this->thaana) {
            return [];
        }

        return ['dir' => 'rtl', 'lang' => 'dv', 'data-thaana' => ''];
    }

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
     * The package assets (Assets::* names) this component needs on the page.
     * javaabu/manifest loads them when the component renders.
     *
     * @return array<int, string>
     */
    public function assets(): array
    {
        return [Assets::CORE];
    }

    /** @return array<int, string> */
    public function requiredAssets(): array
    {
        return Assets::ids($this->assets(), $this->framework);
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
