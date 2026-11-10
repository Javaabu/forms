<?php

namespace Javaabu\Forms\Views\Components;

use Javaabu\Forms\Support\FormatsValues;
use Javaabu\Forms\Support\HandlesBoundValues;

class FormattedValue extends Component
{
    use FormatsValues;
    use HandlesBoundValues;

    protected string $view = 'formatted-value';

    public mixed $value;

    /**
     * Shows a value the way text entries and table cells do: enums as labels or status
     * badges, admin models as links, arrays joined, booleans as Yes/No, blanks as "-".
     */
    public function __construct(
        public string $name = '',
        $value = null,
        $model = null,
        public bool $multiline = false,
        string $framework = '',
    ) {
        parent::__construct($framework);

        $this->value = ! is_null($value) ? $value : ($name ? $this->getBoundValue($model, $name) : '');
    }
}
