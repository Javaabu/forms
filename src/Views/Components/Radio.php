<?php

namespace Javaabu\Forms\Views\Components;

use BackedEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Radio extends Input
{
    protected string $view = 'radio';

    public bool $checked = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        string $label = '',
        $model = null,
        $default = false,
        $value = 1,
        bool $showErrors = true,
        bool $showLabel = true,
        bool $required = false,
        bool $inline = false,
        bool $floating = false,
        string $inlineLabelClass = '',
        string $inlineInputClass = '',
        bool $showJsErrors = false,
        string $framework = ''
    ) {
        parent::__construct(
            $name,
            label: $label,
            type: 'radio',
            model: $model,
            default: $default,
            showErrors: $showErrors,
            showLabel: $showLabel,
            required: $required,
            inline: $inline,
            floating: $floating,
            inlineLabelClass: $inlineLabelClass,
            inlineInputClass: $inlineInputClass,
            showJsErrors: $showJsErrors,
            framework: $framework
        );

        $this->value = $value;

        $inputName = static::convertBracketsToDots(Str::before($name, '[]'));

        if ($oldData = old($inputName)) {
            $this->checked = in_array($value, Arr::wrap($oldData));
        }

        if (! session()->hasOldInput()) {
            $boundValue = $this->getBoundValue($model, $inputName);

            if ($boundValue instanceof Arrayable) {
                $boundValue = $boundValue->toArray();
            }

            if (is_array($boundValue)) {
                $this->checked = in_array($value instanceof BackedEnum ? $value->value : $value, array_map(fn ($item) => $item instanceof BackedEnum ? $item->value : $item, $boundValue));

                return;
            }

            $this->checked = is_null($boundValue) ? (bool) $default : $this->matchesValue($boundValue, $value);
        }
    }

    /**
     * A radio is checked when the bound value is its value (backed enums by their value).
     */
    protected function matchesValue(mixed $bound, mixed $value): bool
    {
        if ($bound instanceof BackedEnum) {
            $bound = $bound->value;
        }

        if ($value instanceof BackedEnum) {
            $value = $value->value;
        }

        if (is_bool($bound)) {
            return $bound === (bool) $value;
        }

        return (string) $bound === (string) $value;
    }
}
