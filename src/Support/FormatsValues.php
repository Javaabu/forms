<?php

namespace Javaabu\Forms\Support;

use BackedEnum;
use Illuminate\Database\Eloquent\Model;

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
        return $this->value instanceof Model && method_exists($this->value, 'getAdminLinkAttribute');
    }

    public function formatValue()
    {
        if (is_bool($this->value)) {
            return $this->value ? trans('forms::strings.yes') : trans('forms::strings.no');
        } elseif (empty($this->value)) {
            return trans('forms::strings.blank');
        }

        return $this->value;
    }
}
