<?php

namespace Javaabu\Forms\Views\Components\Table;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Javaabu\Forms\Support\HandlesBoundValues;
use Javaabu\Forms\Views\Components\Component;

class Row extends Component
{
    use HandlesBoundValues;
    protected string $view = 'table.row';
    public string $rowId;
    public string $name;
    public string $modelId;
    public bool $noCheckbox;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name = '',
        string $rowId = '',
        $model = null,
        string $modelId = '',
        bool $noCheckbox = false,
        public bool $disableCheckbox = false,
        string $framework = '',
    ) {
        parent::__construct($framework);

        $this->rowId = $rowId;
        $this->noCheckbox = $noCheckbox;

        $this->bindModel($model);

        $this->name = $name ?: ($this->model instanceof Model ? Str::plural($this->model->getMorphClass()) : '');
        $this->modelId = $modelId ?: ($this->model instanceof Model ? (string) $this->model->getKey() : '');
    }

    public function generateRowId(): void
    {
        if (! $this->rowId) {
            $this->rowId = ($this->name ? $this->name . '-' : '') . ($this->modelId ?: rand()) . '-row';
        }
    }

    public function getRowId(): string
    {
        if (! $this->rowId) {
            $this->generateRowId();
        }

        return $this->rowId;
    }

    public function getCheckboxId(): string
    {
        return $this->getRowId() . '-check';
    }
}
