<?php

namespace Javaabu\Forms\Support;

use BackedEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait FormatsValues
{
    public function getEnumLabel(): string
    {
        if ($this->value instanceof BackedEnum) {
            return method_exists($this->value, 'getLabel') ? $this->value->getLabel() : $this->value->name;
        }

        return '';
    }

    public function isStatusEnum(): bool
    {
        return $this->value instanceof BackedEnum && method_exists($this->value, 'getColor');
    }

    public function isAdminModel(): bool
    {
        return $this->checkIfIsAdminModel($this->value);
    }

    public function checkIfIsAdminModel(mixed $value): bool
    {
        return $value instanceof Model && method_exists($value, 'getAdminLinkAttribute');
    }

    public function isAdminModelCollection(): bool
    {
        if (! $this->value instanceof Collection) {
            return false;
        }

        foreach ($this->value as $item) {
            if (! $this->checkIfIsAdminModel($item)) {
                return false;
            }
        }

        return true;
    }

    public function formatValue()
    {
        if ($this->value instanceof BackedEnum) {
            return $this->getEnumLabel();
        } elseif (is_bool($this->value)) {
            return $this->value ? trans('forms::strings.yes') : trans('forms::strings.no');
        } elseif (empty($this->value) && (! is_numeric($this->value))) {
            return trans('forms::strings.blank');
        }

        return $this->value;
    }
}
