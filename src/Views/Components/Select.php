<?php

namespace Javaabu\Forms\Views\Components;

use BackedEnum;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Javaabu\Forms\Support\HandlesDefaultAndOldValue;
use Javaabu\Forms\Support\HandlesValidationErrors;

class Select extends Component
{
    use HandlesValidationErrors;
    use HandlesDefaultAndOldValue;

    protected string $view = 'select';

    public string $name;
    public string $label;
    public $options;
    public $selectedKey;
    public bool $multiple;
    public bool $required;
    public bool $inline;
    public bool $floating;
    public string $placeholder;
    public bool $showPlaceholder;
    public bool $isSelect2;
    public string $nameField;
    public string $idField;
    public bool $showLabel;
    public string $syncFieldName;
    public bool $isAjax;
    public bool $tags;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        string $label = '',
        string $placeholder = '',
        $options = [],
        $model = null,
        $default = null,
        bool   $multiple = false,
        bool   $relation = false,
        bool   $showErrors = true,
        bool   $showLabel = true,
        bool   $showPlaceholder = false,
        bool   $required = false,
        bool    $inline = false,
        bool   $floating = false,
        bool   $isSelect2 = false,
        bool   $isAjax = false,
        public bool $disabled = false,
        public bool $excludeSyncField = false,
        string $syncFieldName = '',
        string $nameField = '',
        string $idField = '',
        bool $tags = false,
        public string $inlineLabelClass = '',
        public string $inlineInputClass = '',
        public string $formGroupClass = '',
        public bool $showJsErrors = false,
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->isAjax = $isAjax;
        $this->name = $name;
        $this->label = $label;
        $this->nameField = $nameField;
        $this->idField = $idField;
        $this->isSelect2 = $isSelect2;
        $this->relation = $relation;
        $this->showPlaceholder = $showPlaceholder;
        $this->placeholder = $placeholder ?: ($showPlaceholder ? ($label ?: $this->generateLabelByName()) : '');

        $inputName = static::convertBracketsToDots(Str::before($name, '[]'));

        $this->syncFieldName = $syncFieldName ?: 'sync_' . $inputName;

        if (is_null($default)) {
            $default = $this->getBoundValue($model, $inputName);
        }

        if ($default instanceof Model) {
            $default = $idField ? $default->{$idField} : $default->getKey();
        }

        if ($default instanceof Collection && $idField) {
            $default = $default->pluck($idField);
        }

        if ($default instanceof BackedEnum) {
            $default = $default->value;
        }

        $this->selectedKey = old($inputName, $default);

        if ($this->selectedKey instanceof Arrayable) {
            $this->selectedKey = $this->selectedKey->toArray();
        }

        $this->multiple = $multiple;
        $this->showErrors = $showErrors;
        $this->showLabel = $showLabel;
        $this->floating = $floating;
        $this->required = $required;
        $this->inline = $inline;
        $this->tags = $tags;

        $this->options = $options instanceof BuilderContract ? $this->getOptionsFromQueryBuilder($options) : $options;

        // include old values for tags
        if ($this->tags && is_array($this->options)) {
            $old_value = Arr::wrap(old($inputName));

            foreach ($old_value as $value) {
                if (! array_key_exists($value, $this->options)) {
                    $this->options[$value] = $value;
                }
            }
        }
    }

    public function getOptionsFromQueryBuilder(BuilderContract $query): array
    {
        $model = $query->getModel();

        $name_field = $this->nameField ?: 'name';
        $id_field = $this->idField ?: ($model instanceof Model && $model->getKeyName() ? $model->getKeyName() : 'id');
        $is_accessor = false;

        // load only selected
        if ($this->isAjax) {
            $selected_keys = $this->selectedKey instanceof Arrayable ? $this->selectedKey->toArray() : Arr::wrap($this->selectedKey);
            $query->whereIn($id_field, $selected_keys);
        }

        if ($model instanceof Model) {
            $is_accessor = $model->hasAttributeMutator($name_field) ||
                           $model->hasGetMutator($name_field) ||

                           $model->hasAttributeMutator($id_field) ||
                           $model->hasGetMutator($id_field);
        }

        if ($is_accessor) {
            return $query->get()
                         ->pluck($name_field, $id_field)
                         ->all();
        }

        return $query->pluck($name_field, $id_field)->all();
    }

    public function isSelected($key): bool
    {
        return in_array($key, Arr::wrap($this->selectedKey));
    }

    public function nothingSelected(): bool
    {
        return is_array($this->selectedKey) ? empty($this->selectedKey) : is_null($this->selectedKey);
    }

    public function shouldShowSyncField(): bool
    {
        return (!$this->excludeSyncField) && $this->multiple && (!$this->disabled);
    }
}
