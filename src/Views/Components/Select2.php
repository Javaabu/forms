<?php

namespace Javaabu\Forms\Views\Components;

class Select2 extends Select
{
    public bool $tags;
    public bool $allowClear;
    public bool $isFirst;
    public bool $hideSearch;
    public string $child;
    public string $ajaxChild;
    public string $ajaxUrl;
    public string $selectedUrl;
    public string $filterField;
    public string $fallback;
    public string $parentModal;
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
        bool   $isAjax = false,
        bool   $isFirst = false,
        bool   $tags = false,
        bool   $hideSearch = false,
        bool   $allowClear = true,
        public bool $isIconSelect = false,
        string $child = '',
        string $ajaxChild = '',
        string $ajaxUrl = '',
        string $selectedUrl = '',
        string $nameField = '',
        string $idField = '',
        string $filterField = '',
        string $fallback = '',
        string $parentModal = '',
        public string $iconPrefix = '',
        bool $disabled = false,
        bool $excludeSyncField = false,
        string $syncFieldName = '',
        bool $inline = false,
        bool $floating = false,
        string $framework = ''
    ) {
        if ($allowClear && empty($placeholder)) {
            $placeholder = $this->getNothingSelectedText();
        }

        parent::__construct(
            $name,
            label: $label,
            placeholder: $placeholder,
            options: $options,
            model: $model,
            default: $default,
            multiple: $multiple,
            relation: $relation,
            showErrors: $showErrors,
            showLabel: $showLabel,
            showPlaceholder: $showPlaceholder,
            required: $required,
            inline: $inline,
            floating: $floating,
            isSelect2: true,
            isAjax: $isAjax,
            disabled: $disabled,
            excludeSyncField: $excludeSyncField,
            syncFieldName: $syncFieldName,
            nameField: $nameField,
            idField: $idField,
            framework: $framework
        );

        $this->isFirst = $isFirst;
        $this->child = $child;
        $this->ajaxChild = $ajaxChild;
        $this->ajaxUrl = $ajaxUrl;
        $this->selectedUrl = $selectedUrl;
        $this->filterField = $filterField;
        $this->tags = $tags;
        $this->hideSearch = $hideSearch;
        $this->allowClear = $allowClear;
        $this->fallback = $fallback;
        $this->parentModal = $parentModal;
    }

    /**
     * Get the default nothing selected text
     */
    public function getNothingSelectedText(): string
    {
        return trans('forms::strings.nothing_selected');
    }
}
